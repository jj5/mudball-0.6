<?php

function ka_validate_connection(
  PDO $pdo,
  string $expected_isolation_level,
  string|null $expected_time_zone = null,
  string $expected_character_set = 'utf8mb4',
  string $expected_collation = 'utf8mb4_unicode_520_ci',
) {

  // 2024-02-13 jj5 - first we check the transaction isolation level...

  $tx_isolation = $pdo->query( 'select @@tx_isolation' )->fetchAll()[ 0 ][ '@@tx_isolation' ];

  $tx_isolation = str_replace( '-', ' ', $tx_isolation );

  assert(
    $tx_isolation === $expected_isolation_level,
    "$tx_isolation === $expected_isolation_level",
  );

  // 2024-02-13 jj5 - then we check the time zone setting...

  if ( $expected_time_zone === null ) {

    $expected_time_zone = date_default_timezone_get();

  }

  $time_zone_setting = $pdo->query( 'select @@time_zone' )->fetchAll()[ 0 ][ '@@time_zone' ];

  assert( strlen( $time_zone_setting ) > 0 );
  assert(
     $time_zone_setting === $expected_time_zone,
     "$time_zone_setting === $expected_time_zone",
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

    assert(
      in_array( $expected_item, $sql_mode_array, $strict = true ),
      "expected item '$expected_item' in sql_mode setting.",
    );

  }

  // 2024-02-13 jj5 - then we check the character set and collation settings...

  foreach (
    [ 'character_set_client', 'character_set_connection', 'character_set_results' ]
    as $character_set
  ) {

    $sql = "show session variables like '$character_set'";

    $setting = $pdo->query( $sql )->fetchAll()[ 0 ][ 'value' ];

    assert(
      $setting === $expected_character_set,
      "$setting === $expected_character_set",
    );

  }

  foreach ( [ 'collation_connection' ] as $collation ) {

    $sql = "show session variables like '$collation'";

    $setting = $pdo->query( $sql )->fetchAll()[ 0 ][ 'value' ];

    assert(
      $setting === $expected_collation,
      "$setting === $expected_collation",
    );

  }

  // finally we check some connection attributes which our code generally assumes...

  $error_mode = $pdo->getAttribute( PDO::ATTR_ERRMODE );

  assert(
    $error_mode === PDO::ERRMODE_EXCEPTION,
    "$error_mode === PDO::ERRMODE_EXCEPTION",
  );

  $attr_case = $pdo->getAttribute( PDO::ATTR_CASE );

  assert(
    $attr_case === PDO::CASE_LOWER,
    "$attr_case === PDO::CASE_LOWER",
  );

}
