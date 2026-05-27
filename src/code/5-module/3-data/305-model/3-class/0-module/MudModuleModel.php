<?php

class MudModuleModel extends MudModuleBasic {

  protected ?MudDatabaseLite $database = null;

  public function set_database( MudDatabaseLite $database ) : self {
    $this->database = $database;
    return $this;
  }

  public function get_database() : MudDatabaseLite {
    if ( $this->database === null ) {
      mud_fail( MUD_ERR_MODEL_DATABASE_NOT_SET );
    }
    return $this->database;
  }

  public function declare_schema( string $namespace, string $name, string $path ) : MudSchemaLite {

    return MudSchemaLite::Create( $namespace, $name, $path );

  }

  public function declare_database(
    array  $schema_list,
    string $db_host = DB_HOST,
    int    $db_port = DB_PORT,
    ?string $db_cert = DB_CERT,
    string $db_name = DB_NAME,
    string $db_user = DB_USER,
    string $db_pass = DB_PASS,
    string $db_user_dba = DB_USER_DBA,
    string $db_pass_dba = DB_PASS_DBA,
) : MudDatabaseLite {

    return MudDatabaseLite::Create(
      $schema_list,
      $db_host,
      $db_port,
      $db_cert,
      $db_name,
      $db_user,
      $db_pass,
      $db_user_dba,
      $db_pass_dba
    );

  }

  function validate_connection(
    PDO $pdo,
    string $expected_isolation_level,
    string $expected_time_zone,
    string $expected_character_set,
    string $expected_collation,
  ) {

    // 2024-02-13 jj5 - first we check the transaction isolation level...

    $tx_isolation = $pdo->query( 'select @@tx_isolation' )->fetchAll()[ 0 ][ '@@tx_isolation' ];

    $tx_isolation = str_replace( '-', ' ', $tx_isolation );

    mud_verify(
      $tx_isolation === $expected_isolation_level,
      [
        'tx_isolation' => $tx_isolation,
        'expected_isolation_level' => $expected_isolation_level,
      ]
    );

    // 2024-02-13 jj5 - then we check the time zone setting...

    $time_zone_setting = $pdo->query( 'select @@time_zone' )->fetchAll()[ 0 ][ '@@time_zone' ];

    mud_verify(
      strlen( $time_zone_setting ) > 0,
      [
        'time_zone_setting' => $time_zone_setting,
      ]
    );

    mud_verify(
      $time_zone_setting === $expected_time_zone,
      [
        'time_zone_setting' => $time_zone_setting,
        'expected_time_zone' => $expected_time_zone,
      ]
    );

    // 2024-02-13 jj5 - then we check the sql_mode settings...

    $sql_mode_setting = $pdo->query( 'select @@sql_mode' )->fetchAll()[ 0 ][ '@@sql_mode' ];

    $sql_mode_array = explode( ',', $sql_mode_setting );

    static $sql_mode_expected = [
      'TRADITIONAL',
      'STRICT_TRANS_TABLES', 'STRICT_ALL_TABLES',
      'NO_ZERO_IN_DATE', 'NO_ZERO_DATE',
      'NO_AUTO_CREATE_USER', 'NO_ENGINE_SUBSTITUTION',
      'ERROR_FOR_DIVISION_BY_ZERO',
    ];

    foreach ( $sql_mode_expected as $expected_item ) {

      mud_verify(
        in_array( $expected_item, $sql_mode_array, $strict = true ),
        [
          'expected_item' => $expected_item,
          'sql_mode_array' => $sql_mode_array,
        ]
      );

    }

    // 2024-02-13 jj5 - then we check the character set and collation settings...

    foreach (
      [ 'character_set_client', 'character_set_connection', 'character_set_results' ]
      as $character_set
    ) {

      $sql = "show session variables like '$character_set'";

      $setting = $pdo->query( $sql )->fetchAll()[ 0 ][ 'value' ];

      mud_verify(
        $setting === $expected_character_set,
        [
          'setting' => $setting,
          'expected_character_set' => $expected_character_set,
        ]
      );

    }

    foreach ( [ 'collation_connection' ] as $collation ) {

      $sql = "show session variables like '$collation'";

      $setting = $pdo->query( $sql )->fetchAll()[ 0 ][ 'value' ];

      mud_verify(
        $setting === $expected_collation,
        [
          'setting' => $setting,
          'expected_collation' => $expected_collation,
        ]
      );

    }

    // finally we check some connection attributes which our code generally assumes...

    $error_mode = $pdo->getAttribute( PDO::ATTR_ERRMODE );

    mud_verify(
      $error_mode === PDO::ERRMODE_EXCEPTION,
      [
        'error_mode' => $error_mode,
        'expected_error_mode' => PDO::ERRMODE_EXCEPTION,
      ]
    );

    $attr_case = $pdo->getAttribute( PDO::ATTR_CASE );

    mud_verify(
      $attr_case === PDO::CASE_LOWER,
      [
        'attr_case' => $attr_case,
        'expected_attr_case' => PDO::CASE_LOWER,
      ]
    );

  }
}
