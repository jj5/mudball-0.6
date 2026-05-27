<?php

class MudDatabaseLite extends MudGadget {

  protected array $schema_list;

  protected string $db_host;
  protected int    $db_port;
  protected ?string $db_cert;
  protected string $db_name;
  protected string $db_user;
  protected string $db_pass;
  protected string $db_user_dba;
  protected string $db_pass_dba;

  protected array $connection_map = [];

  public function __construct(
    array   $schema_list,
    string  $db_host = DB_HOST,
    int     $db_port = DB_PORT,
    ?string $db_cert = DB_CERT,
    string  $db_name = DB_NAME,
    string  $db_user = DB_USER,
    string  $db_pass = DB_PASS,
    string  $db_user_dba = DB_USER_DBA,
    string  $db_pass_dba = DB_PASS_DBA,
  ) {

    parent::__construct();

    $this->schema_list = $schema_list;

    $this->db_host = $db_host;
    $this->db_port = $db_port;
    $this->db_cert = $db_cert;
    $this->db_name = $db_name;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
    $this->db_user_dba = $db_user_dba;
    $this->db_pass_dba = $db_pass_dba;

  }

  public function get_connection( MudConnectionTypeLite $type, array $options = [] ) : MudConnectionLite {

    static $isolation_levels = [
      'READ UNCOMMITTED', 'READ COMMITTED', 'REPEATABLE READ', 'SERIALIZABLE',
    ];

    if ( ! isset( $this->connection_map[ $type->value ] ) ) {

      if ( $this->db_cert ) {
        if ( ! file_exists( $this->db_cert ) ) {
          mud_fail( MUD_ERR_MODEL_CERTIFICATE_MISSING, [ 'db_cert' => $this->db_cert ] );
        }
      }

      $host = $this->db_host;
      $port = $this->db_port;
      $name = $this->db_name;
      $user = $this->db_user;
      $pass = $this->db_pass;

      // here we make sure there are no surprises in the database connection settings... you can
      // relax these requirements if necessary, but be careful with untrusted values.
      foreach ( [ $name, $host ] as $check_name ) {

        if ( mud_is_valid_table_name( $check_name ) ) { continue; }

        mud_fail( MUD_ERR_MODEL_INVALID_NAME, [ 'name' => $check_name ] );

      }

      $pdo_class = MUD_CONNECTION_SETTING[ $type->value ][ 'pdo_class' ];
      $connection_class = MUD_CONNECTION_SETTING[ $type->value ][ 'connection_class' ];
      $isolation_level = MUD_CONNECTION_SETTING[ $type->value ][ 'isolation_level' ];
      $auto_commit = MUD_CONNECTION_SETTING[ $type->value ][ 'auto_commit' ];
      $emulate_prepares = MUD_CONNECTION_SETTING[ $type->value ][ 'emulate_prepares' ] ?? false;
      $allow_multi_statements = MUD_CONNECTION_SETTING[ $type->value ][ 'allow_multi_statements' ] ?? false;

      if ( ! in_array( $isolation_level, $isolation_levels, $strict = true ) ) {

        mud_fail( MUD_ERR_MODEL_INVALID_ISOLATION_LEVEL, [ 'isolation_level' => $isolation_level ] );

      }

      switch ( $type ) {
        case MudConnectionTypeLite::RAW:
          break;
        case MudConnectionTypeLite::TRN:
          break;
        case MudConnectionTypeLite::EMU:
          break;
        case MudConnectionTypeLite::AUX:
          break;
        case MudConnectionTypeLite::DBA:
          $user = $this->db_user_dba;
          $pass = $this->db_pass_dba;
          break;
        default:
          mud_fail( MUD_ERR_MODEL_UNSUPPORTED_CONNECTION_TYPE, [ 'type' => $type->value ] );
      }

      $charset = MUD_DATABASE_DEFAULT_CHARSET;
      $collate = MUD_DATABASE_DEFAULT_COLLATION;

      $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=$charset;collate=$collate";

      $statement_class = class_exists( 'AppStatementLite' ) ? AppStatementLite::class : MudStatementLite::class;

      $opt = $options + [
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
        PDO::ATTR_STATEMENT_CLASS           => [ $statement_class ]
      ];

      if ( $this->db_cert ) {

        $opt[ PDO::MYSQL_ATTR_SSL_CA ] = $this->db_cert;
        $opt[ PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT ] = true;

      }

      $pdo = $pdo_class::Create( $dsn, $user, $pass, $opt );

      $connection = $connection_class::Create( $this, $pdo );

      $connection->exec( 'set time_zone = ' . $connection->quote( MUD_DATABASE_DEFAULT_TIME_ZONE ) );

      $connection->exec( "set sql_mode='traditional'" );

      $connection->exec( "set session transaction isolation level $isolation_level" );

      $connection->exec( "set names $charset collate $collate" );

      // 2024-09-13 jj5 - TODO: log the connection_id for this connection...

      if ( defined( 'DEBUG' ) && DEBUG ) {

        mud_validate_connection_lite( $pdo, $isolation_level );

      }

      $this->connection_map[ $type->value ] = $connection;

    }

    return $this->connection_map[ $type->value ];

  }
}
