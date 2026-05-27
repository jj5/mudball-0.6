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
  protected IMudElementAccessor $element_accessor;

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

    $this->set_element_accessor_strategy( MudElementAccessorStrategy::DIRECT );

  }

  public function set_element_accessor_strategy( MudElementAccessorStrategy $strategy ) : void {

    switch ( $strategy ) {
      case MudElementAccessorStrategy::DIRECT:
        $this->element_accessor = new MudElementAccessorDirect( $this );
        break;
      case MudElementAccessorStrategy::CACHED:
        $this->element_accessor = new MudElementAccessorCached( $this );
        break;
      default:
        mud_fail( MUD_ERR_MODEL_UNSUPPORTED_ELEMENT_ACCESSOR_STRATEGY, [ 'strategy' => $strategy->value ] );
    }
  }

  public function is_connected( MudConnectionTypeLite $type ) : bool {
    return isset( $this->connection_map[ $type->value ] );
  }

  public function get_raw() : MudConnectionLite_RAW {
    return $this->get_connection( MudConnectionTypeLite::RAW );
  }

  public function get_trn() : MudConnectionLite_TRN {
    return $this->get_connection( MudConnectionTypeLite::TRN );
  }

  public function get_emu() : MudConnectionLite_EMU {
    return $this->get_connection( MudConnectionTypeLite::EMU );
  }

  public function get_aux() : MudConnectionLite_AUX {
    return $this->get_connection( MudConnectionTypeLite::AUX );
  }

  public function get_dba() : MudConnectionLite_DBA {
    return $this->get_connection( MudConnectionTypeLite::DBA );
  }

  public function get_connection( MudConnectionTypeLite $type ) : MudConnectionLite {

    $options = [];

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

      switch ( $type ) {
        case MudConnectionTypeLite::RAW:
          if ( $this->is_connected( MudConnectionTypeLite::DBA ) ) {
            $connection->set_a_std_interaction_rid( $this->get_dba()->get_a_std_interaction_rid() );
          }
          else {
            $connection->exec( "call sp_std_new_interaction()" );
          }
          break;
        case MudConnectionTypeLite::TRN:
          break;
        case MudConnectionTypeLite::EMU:
          break;
        case MudConnectionTypeLite::AUX:
          break;
        case MudConnectionTypeLite::DBA:
          break;
        default:
          mud_fail( MUD_ERR_MODEL_UNSUPPORTED_CONNECTION_TYPE, [ 'type' => $type->value ] );
      }

      $this->connection_map[ $type->value ] = $connection;

    }

    return $this->connection_map[ $type->value ];

  }

  public function upgrade() {

    $revision_list = [];

    foreach ( $this->schema_list as $schema ) {

      $revision_list = array_merge( $revision_list, $schema->get_revision_list() );

    }

    usort( $revision_list, function ( MudRevisionLite $a, MudRevisionLite $b ) {

      if ( $a->get_timestamp() < $b->get_timestamp() ) { return -1; }
      if ( $a->get_timestamp() > $b->get_timestamp() ) { return 1; }
      return 0;

    } );

    var_dump( $revision_list );

    foreach ( $revision_list as $revision ) {

      $path = $revision->get_path();

      echo "applying revision: " . $path . "\n";

      switch ( $revision->get_type() ) {
        case 'sql':
          $sql = file_get_contents( $path );
          if ( $sql === false ) {
            mud_fail( MUD_ERR_MODEL_REVISION_FILE_MISSING, [ 'name' => $path ] );
          }
          $this->get_dba()->exec( $sql );
          break;
        case 'php' :
          require $path;
          break;
        default:
          echo "skipping unsupported revision type: " . $revision->get_type() . "\n";
      }

      $sql = "
        insert ignore into t_particle_std_schema_name (
          a_std_schema_name
        )
        values (
          " . $this->get_dba()->quote( $revision->get_schema()->get_name() ) . "
        )";

      $this->get_dba()->exec( $sql );

      $sql = "
        select
          a_std_schema_name_aid
        from
          t_particle_std_schema_name
        where
          a_std_schema_name = " . $this->get_dba()->quote( $revision->get_schema()->get_name() );

      $a_std_schema_name_rid = $this->get_dba()->query( $sql )[ 0 ][ 'a_std_schema_name_aid' ];

      $sql = "
        insert into t_journal_std_migration (
          a_std_migration_schema_name_rid,
          a_std_migration_revision
        )
        values (
          " . $this->get_dba()->quote( $a_std_schema_name_rid ) . ",
          " . $this->get_dba()->quote( $revision->get_datestring( 'Y-m-d H:i:s' ) ) . "
        )";

      $this->get_dba()->exec( $sql );

      var_dump( MUDBALL_CODE );

      $rid = $this->get_particle_rid(
        't_particle_std_software_code',
        'a_std_software_code_aid',
        'a_std_software_code',
        MUDBALL_CODE,
      );

    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-05-27 jj5 - IMudElementAccessor passthrough methods... these just call the element accessor, which can be swapped
  // out for different strategies (e.g. direct vs cached).
  //

  public function get_particle( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return $this->element_accessor->get_particle( $table, $aid_column, $value_column, $rid );

  }

  public function get_particle_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    return $this->element_accessor->get_particle_rid( $table, $aid_column, $value_column, $value );

  }

  public function get_piece( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return $this->element_accessor->get_piece( $table, $aid_column, $value_column, $rid );

  }

  public function get_piece_rid( string $table, string $aid_column, string $hash_column, string $hash ) : int {

    return $this->element_accessor->get_piece_rid( $table, $aid_column, $hash_column, $hash );

  }

  public function get_pot( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return $this->element_accessor->get_pot( $table, $aid_column, $value_column, $rid );

  }

  public function get_pot_rid( string $table, string $aid_column, string $value_column, string $value ) : int {

    return $this->element_accessor->get_pot_rid( $table, $aid_column, $value_column, $value );

  }

  public function get_province( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return $this->element_accessor->get_province( $table, $aid_column, $value_column, $rid );

  }

  public function get_province_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    return $this->element_accessor->get_province_rid( $table, $aid_column, $value_column, $value );

  }

  public function get_product( string $table, string $aid_column, array $value_column_list, int $rid ) : array {

    return $this->element_accessor->get_product( $table, $aid_column, $value_column_list, $rid );

  }

  public function get_product_rid( string $table, string $aid_column, array $column_value_map ) : int {

    return $this->element_accessor->get_product_rid( $table, $aid_column, $column_value_map );

  }
}
