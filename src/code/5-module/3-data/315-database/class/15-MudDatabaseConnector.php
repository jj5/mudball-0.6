<?php

define( 'CONNECTION_OPTION', [
  MudDatabaseConnectionType::RAW->value => [
    'connection_class' => PDO_RAW::class,
    'isolation_level' => 'REPEATABLE READ',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudDatabaseConnectionType::TRN->value => [
    'connection_class' => PDO_TRN::class,
    'isolation_level' => 'SERIALIZABLE',
    'auto_commit' => false,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudDatabaseConnectionType::AUX->value => [
    'connection_class' => PDO_AUX::class,
    'isolation_level' => 'REPEATABLE READ',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudDatabaseConnectionType::EMU->value => [
    'connection_class' => PDO_EMU::class,
    'isolation_level' => 'REPEATABLE READ',
    'auto_commit' => true,
    'emulate_prepares' => true,
    'allow_multi_statements' => false,
  ],
  MudDatabaseConnectionType::DBA->value => [
    'connection_class' => PDO_DBA::class,
    'isolation_level' => 'READ COMMITTED',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => true,
  ],
]);

class MudDatabaseConnector {

  protected $connection_map = [];

  public function get_connection( MudDatabaseConnectionType $type ) : MudDatabaseConnection {
    if ( ! array_key_exists( $type->value, $this->connection_map ) ) {
      $connection = $this->new_connection( $type );
      assert( $connection === $this->connection_map[ $type->value ] );
    }
    return $this->connection_map[ $type->value ];
  }

  public function get_raw() : PDO_RAW {
    return $this->get_connection( MudDatabaseConnectionType::RAW );
  }

  public function get_trn() : PDO_TRN {
    return $this->get_connection( MudDatabaseConnectionType::TRN );
  }

  public function get_aux() : PDO_AUX {
    return $this->get_connection( MudDatabaseConnectionType::AUX );
  }

  public function get_emu() : PDO_EMU {
    return $this->get_connection( MudDatabaseConnectionType::EMU );
  }

  public function get_dba() : PDO_DBA {
    return $this->get_connection( MudDatabaseConnectionType::DBA );
  }

  public function reset() : void {
    foreach ( $this->connection_map as $type => $connection ) {
      $connection->cancel();
      unset( $this->connection_map[ $type ] );
    }
  }

  protected function new_connection( MudDatabaseConnectionType $type ) : MudDatabaseConnection {

    static $isolation_levels = [
      'READ UNCOMMITTED', 'READ COMMITTED', 'REPEATABLE READ', 'SERIALIZABLE',
    ];

    $connection_class = CONNECTION_OPTION[ $type->value ]['connection_class'];
    $isolation_level = CONNECTION_OPTION[ $type->value ]['isolation_level'];
    $auto_commit = CONNECTION_OPTION[ $type->value ]['auto_commit'];
    $emulate_prepares = CONNECTION_OPTION[ $type->value ]['emulate_prepares'] ?? false;
    $allow_multi_statements = CONNECTION_OPTION[ $type->value ]['allow_multi_statements'];
    $options = CONNECTION_OPTION[ $type->value ]['options'] ?? [];

    $db_user = \DB_USER;
    $db_pass = \DB_PASS;
    $db_name = \DB_NAME;
    $db_host = \DB_HOST;
    $silent = false;

    if ( $type === MudDatabaseConnectionType::DBA ) {

      $db_user = \DB_USER_DBA;
      $db_pass = \DB_PASS_DBA;

    }

    if ( ! in_array( $isolation_level, $isolation_levels, $strict = true ) ) {

      throw new Exception( "invalid isolation level '$isolation_level'." );

    }

    // 2024-02-12 jj5 - set any options not already specified in $user_options...
    $options += [
      PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_CASE                      => PDO::CASE_LOWER,
      PDO::ATTR_ORACLE_NULLS              => PDO::NULL_NATURAL,
      PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
      PDO::ATTR_AUTOCOMMIT                => $auto_commit,
      PDO::ATTR_EMULATE_PREPARES          => $emulate_prepares,
      PDO::ATTR_PERSISTENT                => false,
      PDO::ATTR_STRINGIFY_FETCHES         => false,
      PDO::MYSQL_ATTR_MULTI_STATEMENTS    => $allow_multi_statements,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => true,
      PDO::ATTR_STATEMENT_CLASS           => [ MudDatabaseStatement::class ],
    ];

    // here we make sure there are no surprises in the database connection settings... you can
    // relax these requirements if necessary, but be careful with untrusted values.
    foreach ( [ $db_name, $db_host ] as $check_name ) {

      if ( mud_is_valid_table_name( $check_name ) ) { continue; }

      throw new Exception( "Invalid name '$check_name'." );

    }

    $connection_string = "mysql:dbname=$db_name;host=$db_host;charset=utf8mb4";

    $pdo = new PDO( $connection_string, $db_user, $db_pass, $options );

    $connection = new $connection_class( $pdo );

    $time_zone = date_default_timezone_get();

    $pdo->exec( 'set time_zone = ' . $pdo->quote( $time_zone ) );

    $pdo->exec( "set sql_mode='traditional'" );

    $pdo->exec( "set session transaction isolation level $isolation_level" );

    $pdo->exec( 'set names utf8mb4 collate utf8mb4_unicode_520_ci' );

    // 2024-09-13 jj5 - TODO: log the connection_id for this connection...

    if ( ! $silent ) {

      $connection->print_info();

    }

    if ( defined( 'DEBUG' ) && DEBUG ) {

      mud_validate_connection( $pdo, $isolation_level, $time_zone );

    }

    $this->connection_map[ $type->value ] = $connection;

    return $connection;

  }
}
