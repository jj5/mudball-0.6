<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//
//

class MudDatabase extends MudGadget {

  use MudDatabaseTraits;


  //
  // 2019-08-04 jj5 - fields...
  //

  // 2019-08-04 jj5 - the $connection_type is the name for the database
  // settings which have been applied, usually it is one of 'trn', 'raw', 'emu', 'aux', or 'dba';
  // each of which have special semantics applied on connection.
  //
  private $connection_type;

  // 2019-08-04 jj5 - the $transaction_count is the depth of our
  // transactions. It starts at zero, which indicates no transaction, then
  // goes to one, whereupon a transaction is actually started, it can then
  // be further manipulated, and when it reaches zero again the transaction
  // is committed, if it wasn't rolled back in the interim... this value
  // is expected to never go below zero.
  //
  private $transaction_count;

  // 2019-08-04 jj5 - we grab some info about the client and server versions
  // here for the logs, this data is not relied upon...
  //
  private $connection_info;

  // 2019-08-04 jj5 - the $settings are all the settings we need to
  // establish a connection to our database...
  //
  private $settings;

  // 2019-08-04 jj5 - this is the PHP PDO object, which we create as late
  // as possible and can recreate in reconnect() if necessary...
  //
  private $pdo;

  //private $view_map = [];
  //private $table_map = [];

  //private $stmt_cache = [];

  // 2020-03-17 jj5 - the $logger is for logging certain database operations,
  // it is usually just the Data Access Layer instance...
  //
  private $logger;

  private $begin_count = 0;
  private $real_begin_count = 0;
  private $commit_count = 0;
  private $real_commit_count = 0;
  private $rollback_count = 0;
  private $real_rollback_count = 0;

  private $access_map = [];
  private $operation_map = [];
  //public $access_log = [];

  private $stmt_cache = [];

  private $connection_id_stmt = null;

  private $lock_timeout = 1;


  //
  // 2019-08-04 jj5 - constructors...
  //

  public function __construct( string $connection_type, $args = [] ) {

    if ( $connection_type === MUD_CONNECTION_TYPE_DBA ) {

      if ( defined( 'ADMIN' ) && ADMIN ) {

        // 2022-02-28 jj5 - okay

      }
      else {

        mud_fail( MUD_ERR_DATABASE_ADMIN_NOT_DEFINED );

      }
    }

    parent::__construct();

    $args = $args + mud_get_config( [ 'app', 'database', $connection_type ], [] );

    $settings = self::GetSettings( $connection_type, $args );

    $this->connection_type = $connection_type;
    $this->transaction_count = 0;
    $this->connection_info = [];
    $this->settings = $settings;
    $this->pdo = null;

    $this->logger = mud_null_object();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - static methods...
  //

  public static function GetSettings( string $connection_type, array $args ) : MudSettings {

    return MudSettings::Create( $args, self::GetDefaultSettings( $connection_type ) );

  }

  public static function GetDefaultSettings( string $connection_type ) {

    if ( $connection_type === MUD_CONNECTION_TYPE_DBA ) {

      $db_user = MudConstant::Declare( 'DB_USER_DBA' );
      $db_pass = MudConstant::Declare( 'DB_PASS_DBA' );

    }
    else {

      $db_user = MudConstant::Declare( 'DB_USER' );
      $db_pass = MudConstant::Declare( 'DB_PASS' );

    }

    return [
      'db_name'           => MudConstant::Declare( 'DB_NAME' ),
      'db_host'           => MudConstant::Declare( 'DB_HOST' ),
      'db_user'           => $db_user,
      'db_pass'           => $db_pass,
      'charset'           => 'utf8mb4',
      'autocommit'        => true,
      'emulate_prepares'  => false,
      'ssl_key'           => MudConstant::Declare( 'DB_SSL_KEY' ),
      'ssl_ca'            => MudConstant::Declare( 'DB_SSL_CA' ),
      'ssl_cipher'        => MudConstant::Declare( 'DB_SSL_CIPHER' ),
      'prefix'            => MudConstant::Declare( 'DB_PREFIX' ),
      'isolation'         => 'REPEATABLE READ',
      'time_zone'         => MudConstant::Declare( 'APP_TIME_ZONE', date_default_timezone_get() ),
    ];

  }


  //
  // 2020-03-23 jj5 - public methods...
  //

  public function get_connection_id() {

    if ( ! $this->connection_id_stmt ) {

      $this->connection_id_stmt = $this->prepare( 'SELECT CONNECTION_ID() as connection_id' );

    }

    $this->connection_id_stmt->execute();

    $table = $this->connection_id_stmt->fetchAll();

    $this->connection_id_stmt->closeCursor();

    return $table[ 0 ][ 'connection_id' ];

  }

  public function get_logs() {

    $logs = [
      'access_map' => $this->access_map,
      'operation_map' => $this->operation_map,
      'counts' => [
        'begin_count' => $this->begin_count,
        'real_begin_count' => $this->real_begin_count,
        'commit_count' => $this->commit_count,
        'real_commit_count' => $this->real_commit_count,
        'rollback_count' => $this->rollback_count,
        'real_rollback_count' => $this->real_rollback_count,
      ],
    ];

    $this->access_map = [];
    $this->operation_map = [];

    $this->begin_count = 0;
    $this->real_begin_count = 0;
    $this->commit_count = 0;
    $this->real_commit_count = 0;
    $this->rollback_count = 0;
    $this->real_rollback_count = 0;

    return $logs;

  }

  /*
  public function get_counts(
    &$begin,
    &$real_begin,
    &$commit,
    &$real_commit,
    &$rollback,
    &$real_rollback
  ) {

    $begin = $this->begin_count;
    $real_begin = $this->real_begin_count;
    $commit = $this->commit_count;
    $real_commit = $this->real_commit_count;
    $rollback = $this->rollback_count;
    $real_rollback = $this->real_rollback_count;

    return
      0 !==
        $begin +
        $real_begin +
        $commit +
        $real_commit +
        $rollback +
        $real_rollback;

  }
  */

  public function set_logger( $logger ) {

    $this->logger = $logger;

  }

  public function get_prefix() {

    return $this->settings->prefix;

  }

  public function get_transaction_count() {

    return $this->transaction_count;

  }

  public function quote( $raw ) : string {

    return $this->get_pdo()->quote( strval( $raw ) );

  }

  public function entick( $name ) : string {

    return mud_entick( $name );

  }

  public function is_in_transaction() {

    return $this->get_pdo()->inTransaction();

  }

  public function begin() {

    $this->trace( 'begin trans...' );

    // 2019-08-05 jj5 - make sure we get the PDO object before incrementing
    // the transaction count...
    //
    $pdo = $this->get_pdo();

    $this->transaction_count++;

    $this->begin_count++;

    if ( $this->transaction_count === 1 ) {

      if ( $pdo->beginTransaction() ) {

        $this->real_begin_count++;

        $this->trace( 'begun.' );

        return true;

      }
    }
    else {

      // 2020-03-19 jj5 - we support nested transactions now...
      //
      // 2021-04-14 jj5 - oh no we don't!
      //
      //return false;

      // 2019-12-30 jj5 - THINK: we very well may want to have nested
      // transactions. If that seems like it might be necessary or useful
      // we will change this logic here. For now there are no instances
      // which require them so we keep things simple for now.

      $this->fail( MUD_ERR_DATABASE_TRANSACTION_IS_ALREADY_OPEN );

    }

    $this->fail( MUD_ERR_DATABASE_TRANSACTION_FAILED_TO_BEGIN );

  }

  public function commit() {

    $this->trace( 'commit trans...' );

    // 2019-08-05 jj5 - make sure we get the PDO object before operating on
    // the transaction count...
    //
    $pdo = $this->get_pdo();

    if ( $this->transaction_count === 0 ) {

      if ( DEBUG ) {

        $this->fail( MUD_ERR_DATABASE_TRANSACTION_IS_NOT_OPEN );

      }

      return false;

    }

    $this->transaction_count--;

    $this->commit_count++;

    if ( $this->transaction_count === 0 ) {

      if ( $pdo->commit() ) {

        $this->real_commit_count++;

        $this->trace( 'committed.' );

        return true;

      }
    }
    else {

      return false;

    }

    $this->fail( MUD_ERR_DATABASE_TRANSACTION_FAILED_TO_COMMIT );

  }

  public function rollback() {

    $this->trace( 'rollback trans...' );

    // 2019-08-05 jj5 - make sure we get the PDO object before operating on
    // the transaction count...
    //
    $pdo = $this->get_pdo();

    if ( $this->transaction_count === 0 ) { return false; }

    $this->transaction_count = 0;

    $this->rollback_count++;

    if ( $pdo->rollBack() ) {

      $this->real_rollback_count++;

      $this->trace( 'rolled back.' );

      $this->increment_lock_timeout();

      // 2019-08-23 jj5 - NOTE: commit() returns true and rollback() returns
      // false so we can return on one line and indicate failure or not...

      return false;

    }

    $this->fail( MUD_ERR_DATABASE_TRANSACTION_FAILED_TO_ROLLBACK );

  }

  public function random_delay() {

    // 2022-04-10 jj5 - call this to delay a random amount of time before retrying a
    // transaction... the idea is to prevent a whole bunch of connections retrying at the same
    // time...

    $usleep = random_int( 1000, 1000 * $this->get_lock_timeout() );

    $formatted = number_format( $usleep / 1000.0, 2 );

    mud_log_6_info( "sleeping for $formatted milliseconds..." );

    usleep( $usleep );

  }

  public function increment_lock_timeout() {

    $new_timeout = $this->lock_timeout * 2;

    // 2022-04-10 jj5 - 256 seconds is a bit over 4 minutes... we won't wait longer than that.
    //
    if ( $new_timeout > 256 ) { return false; }

    return $this->set_lock_timeout( $new_timeout );

  }

  public function get_lock_timeout() {

    return $this->lock_timeout;

  }

  public function set_lock_timeout( $timeout ) {

    // 2022-04-10 jj5 - SEE: https://mariadb.com/kb/en/innodb-system-variables/#innodb_lock_wait_timeout

    // 2022-04-10 jj5 - valid values are between 1 and 256...
    //
    $timeout = max( 1, min( 256, intval( $timeout ) ) );

    $formatted = number_format( $timeout );
    $unit = $timeout === 1 ? 'second' : 'seconds';
    $type = $this->connection_type;

    mud_log_6_info( "setting lock timeout to $formatted $unit for '$type'..." );

    $this->exec( "SET SESSION innodb_lock_wait_timeout = $timeout" );

    $this->lock_timeout = $timeout;

    return $this;

  }

  public function reconnect() {

    $this->trace( 'reconnecting...' );

    // 2019-08-04 jj5 - THINK: I'm not super sure that complete() is the right
    // thing to do here, or if this is even necessary, but I figure we might
    // as well do the thing that's less likely to result in unwanted data
    // loss, so we commit all open transactions prior to reconnecting to the
    // server... if we can.

    try {

      $this->complete();

    }
    catch ( Exception $ex ) {;}

    $this->transaction_count = 0;
    $this->pdo = null;

    // 2019-08-05 jj5 - we don't do this anymore, as it's only informational
    // it's okay if it goes out of date, and something may be more helpful
    // than nothing...
    //
    //$this->connection_info = [];

    $this->connect();

    $this->trace( 'reconnected.' );

  }

  public function complete() {

    $this->trace( 'complete trans...' );

    // 2019-08-04 jj5 - OLD: we used to take less care of accidentally ending
    // up in an infinite loop...
    //while ( $this->trans ) { $this->commit(); }

    // 2019-08-04 jj5 - in theory we only need to attempt the $this->commit()
    // $this->trans times, for $this->trans >= 0, but we give ourselves
    // plenty of room and retry $this->trans * 2 times, which in theory
    // should be unnecessary, but this limit is just to catch a runaway
    // infinite loop in the case that $this->commit() fails to decrement
    // $this->trans or decrements it to less than zero...

    $retries = $this->transaction_count * 2;

    for ( $tries = 0; $tries < $retries; $tries++ ) {

      if ( $this->transaction_count ) {

        $this->commit();

      }
      else {

        break;

      }
    }

    if ( $this->transaction_count ) {

      // 2019-08-04 jj5 - TODO: this shouldn't happen, but if it does we
      // should probably log it or make some noise or something...

      $this->warn(
        'Invalid transaction count after complete().',
        [ 'transaction_count' => $this->transaction_count ]
      );

    }

    // 2019-08-05 jj5 - disconnect, we will automatically reconnect if
    // necessary...
    //
    $this->pdo = null;

    //$this->stmt_cache = [];

    // 2019-08-05 jj5 - we don't do this anymore, as it's only informational
    // it's okay if it goes out of date, and something may be more helpful
    // than nothing...
    //
    //$this->connection_info = [];

    $this->trace( 'completed.' );

  }

  public function has_table( $table_name ) : bool {

    //return array_key_exists( $table_name, $this->get_tables() );

    $sql = "
      select
        count(*) as count
      from
        information_schema.tables
      where
        table_schema = :table_schema
      and
        table_name = :table_name
    ";

    return $this->get_bool(
      $sql,
      [
        ':table_schema' => $this->settings->db_name,
        ':table_name' => $table_name,
      ],
      'count'
    );

  }

  public function has_column( $table_name, $column_name ) : bool {

    $sql = "
      select
        count(*) as count
      from
        information_schema.columns
      where
        table_schema = :table_schema
      and
        table_name = :table_name
      and
        column_name = :column_name
    ";

    return $this->get_bool(
      $sql,
      [
        ':table_schema' => $this->settings->db_name,
        ':table_name' => $table_name,
        ':column_name' => $column_name,
      ],
      'count'
    );

  }

  public function get_column_info( $table_name, $column_name ) {

    $sql = "
      select
        *
      from
        information_schema.columns
      where
        table_schema = :table_schema
      and
        table_name = :table_name
      and
        column_name = :column_name
    ";

    return $this->get_row(
      $sql,
      [
        ':table_schema' => $this->settings->db_name,
        ':table_name' => $table_name,
        ':column_name' => $column_name,
      ]
    );

  }

  public function has_index( $table_name, $index_name ) : bool {

    $sql = "
      select
        count(*) as count
      from
        information_schema.statistics
      where
        table_schema = :table_schema
      and
        table_name = :table_name
      and
        index_name = :index_name
    ";

    return $this->get_bool(
      $sql,
      [
        ':table_schema' => $this->settings->db_name,
        ':table_name' => $table_name,
        ':index_name' => $index_name,
      ],
      'count'
    );

  }

  public function get_index_info( $table_name, $index_name ) {

    $sql = "
      select
        table_schema,
        table_name,
        index_name,
        max( non_unique ) as non_unique,
        max( cardinality ) as cardinality,
        group_concat( distinct index_type ) as index_type
      from
        information_schema.statistics
      where
        table_schema = :table_schema
      and
        table_name = :table_name
      and
        index_name = :index_name
    ";

    return $this->get_row(
      $sql,
      [
        ':table_schema' => $this->settings->db_name,
        ':table_name' => $table_name,
        ':index_name' => $index_name,
      ]
    );

  }

  public function check_drop() {

    if ( strpos( $this->settings->db_name, 'tmp_' ) === 0 ) { return; }

    bom_fail( 'can only drop temporary databases.' );

  }

  public function drop_all() {

    $this->check_drop();

    $this->drop_foreign_keys();

    $this->drop_views();

    $this->drop_procedures();

    $this->drop_functions();

    $this->drop_tables();

  }

  public function drop_foreign_keys() {

    $this->check_drop();

    $foreign_keys = $this->get_foreign_keys();

    foreach ( $foreign_keys as $foreign_key ) {

      $table_name = $foreign_key[ 'table_name' ];
      $foreign_key_name = $foreign_key[ 'constraint_name' ];

      //echo "$table_name.$foreign_key_name\n";

      $this->drop_foreign_key( $table_name, $foreign_key_name );

    }
  }

  public function drop_foreign_key( $table_name, $foreign_key_name ) {

    $this->check_drop();

    $sql =
      'alter table ' . mud_entick( $table_name ) .
      ' drop foreign key ' . mud_entick( $foreign_key_name );

    $this->run_drop( $sql );

  }

  public function get_foreign_keys() {

    $sql = "
      select
        *
      from
        information_schema.table_constraints
      where
        constraint_schema = :schema
      and
        constraint_type = 'FOREIGN KEY'
    ";

    return $this->get_table(
      $sql,
      [
        ':schema' => $this->settings->db_name,
      ]
    );

  }

  public function drop_views() {

    $this->check_drop();

    $views = $this->get_views();

    foreach ( $views as $view ) {

      $view_name = $view[ 'table_name' ];

      $this->drop_view( $view_name );

    }
  }

  public function drop_view( $view_name ) {

    $this->check_drop();

    $sql = 'drop view ' . mud_entick( $view_name );

    $this->run_drop( $sql );

  }

  public function get_views() {

    $sql = "
      select
        *
      from
        information_schema.views
      where
        table_schema = :schema
    ";

    $table = $this->get_table(
      $sql,
      [
        ':schema' => $this->settings->db_name,
      ]
    );

    $result = [];

    foreach ( $table as $row ) {

      $result[ $row[ 'table_name' ] ] = $row;

    }

    return $result;

  }

  public function drop_procedures() {

    $this->check_drop();

    $procedures = $this->get_procedures();

    foreach ( $procedures as $procedure ) {

      $procedure_name = $procedure[ 'routine_name' ];

      $this->drop_procedure( $procedure_name );

    }
  }

  public function drop_procedure( $procedure_name ) {

    $this->check_drop();

    $sql = 'drop procedure ' . mud_entick( $procedure_name );

    $this->run_drop( $sql );

  }

  public function get_procedures() {

    $sql = "
      select
        *
      from
        information_schema.routines
      where
        routine_schema = :schema
      and
        routine_type = 'PROCEDURE'
    ";

    $table = $this->get_table(
      $sql,
      [
        ':schema' => $this->settings->db_name,
      ]
    );

    $result = [];

    foreach ( $table as $row ) {

      $result[ $row[ 'routine_name' ] ] = $row;

    }

    return $result;

  }

  public function drop_functions() {

    $this->check_drop();

    // 2021-03-26 jj5 - TODO: drop functions...

  }

  public function drop_tables() {

    $this->check_drop();

    $tables = $this->get_tables();

    foreach ( $tables as $table ) {

      $table_name = $table[ 'table_name' ];

      //echo "$table_name\n";

      $this->drop_table( $table_name );

    }
  }

  public function drop_table( $table_name ) {

    $this->check_drop();

    $sql = 'drop table ' . mud_entick( $table_name );

    $this->run_drop( $sql );

  }

  public function get_tables() {

    $sql = "
      select
        *
      from
        information_schema.tables
      where
        table_schema = :schema
    ";

    $table = $this->get_table(
      $sql,
      [
        ':schema' => $this->settings->db_name,
      ]
    );

    $result = [];

    foreach ( $table as $row ) {

      $result[ $row[ 'table_name' ] ] = $row;

    }

    return $result;

  }

  public function get_az( string $sql ) : array {

    $map = [];

    for ( $ord = 65; $ord < 91; $ord++ ) {

      $map[ chr( $ord ) ] = 0;

    }

    $table = $this->get_table( $sql );

    foreach ( $table as $row ) {

      list ( $letter, $count ) = array_values( $row );

      $map[ $letter ] = $count;

    }

    return $map;

  }

  public function get_table(
    string $sql,
    array $params = [],
    $default = []
  ) {

    try {

      $stmt = $this->query( $sql, $params );

      $table = $stmt->fetchAll( PDO::FETCH_ASSOC );

      $stmt->closeCursor();

      if ( is_array( $table ) && count( $table ) ) {

        return $this->parse_table( $table );

      }

      return $default;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_row(
    string $sql,
    array $params = [],
    $default = []
  ) {

    try {

      $stmt = $this->query( $sql, $params );

      $row = $stmt->fetch( PDO::FETCH_ASSOC );

      $stmt->closeCursor();

      if ( is_array( $row ) ) {

        return $this->parse_row( $row );

      }

      return $default;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_list(
    string $sql,
    array $params = [],
    $field = 0,
    $default = []
  ) {

    assert( ! is_string( $field ), 'we need named keys for parsing please update caller' );

    try {

      $stmt = $this->query( $sql, $params );

      $table = $stmt->fetchAll( PDO::FETCH_BOTH );

      $stmt->closeCursor();

      if ( is_array( $table ) && count( $table ) ) {

        $result = [];

        foreach ( $table as $index => $row ) {

          // 2019-08-05 jj5 - THINK: do we really need the null coalesce
          // operator here? Maybe it would be faster without it..?

          // 2019-08-05 jj5 - OLD: fuck it, let's see...
          //$result[] = $row[ $field ] ?? null;
          // 2019-08-05 jj5 - NEW:
          //$result[] = $row[ $field ];
          // 2019-08-05 jj5 - END

          $result[] = $this->parse_field( $row, $field );

        }

        return $result;

      }

      return $default;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function has_row(
    string $sql,
    array $params = [],
    $field = 0
  ) {

    try {

      $count = $this->get_count( $sql, $params, $field );

      if ( $count === 0 ) { return false; }

      if ( $count === 1 ) { return true; }

      $this->fail(
        MUD_ERR_DATABASE_COUNT_IS_INVALID,
        [
          'count' => $count,
          'sql' => $sql,
          'field' => $field,
        ]
      );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_bool(
    string $sql,
    array $params = [],
    $field = 0,
    $default = false
  )
    : bool {

    try {

      return boolval( $this->get_field( $sql, $params, $field, $default ) );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_count(
    string $sql,
    array $params = [],
    string $field = 'count',
    $default = 0
  )
    : int {

    try {

      return $this->get_int( $sql, $params, $field, $default );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_int(
    string $sql,
    array $params = [],
    string $field = '',
    $default = 0
  )
    : int {

    try {

      return intval( $this->get_field( $sql, $params, $field, $default ) );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_string(
    string $sql,
    array $params = [],
    string $field = '',
    $default = ''
  )
    : string {

    try {

      return strval( $this->get_field( $sql, $params, $field, $default ) );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_field(
    string $sql,
    array $params = [],
    string $field = '',
    $default = null
  ) {

    try {

      $stmt = $this->query( $sql, $params );

      $row = $stmt->fetch( PDO::FETCH_ASSOC );

      $stmt->closeCursor();

      if ( ! is_array( $row ) ) { return $default; }

      return $this->parse_field( $row, $field, $default );


      //return $row[ $field ] ?? $default;

      /*
      if ( is_array( $row ) && array_key_exists( $field, $row ) ) {

        return $row[ $field ];

      }

      return $default;
      */

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function get_attr(
    string $sql,
    array $params = [],
    $field = 0,
    $default = null
  ) {

    try {

      $stmt = $this->query( $sql, $params );

      $row = $stmt->fetch( PDO::FETCH_BOTH );

      $stmt->closeCursor();

      if ( ! is_array( $row ) ) { return $default; }

      return $row[ $field ] ?? $default;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function run_create( $sql ) {

    return $this->exec( $sql );

  }

  public function run_alter( $sql ) {

    return $this->exec( $sql );

  }

  public function run_drop( $sql ) {

    return $this->exec( $sql );

  }

  public function run_insert( $sql, $params = [] ) {

    $stmt = $this->query( $sql, $params );

    $count = $stmt->rowCount();

    $stmt->closeCursor();

    return $count;

  }

  public function run_insert_id( $sql, $params = [] ) {

    $stmt = $this->query( $sql, $params );

    $result = intval( $this->get_pdo()->lastInsertId() );

    $stmt->closeCursor();

    return $result;

  }

  public function run_upsert( $sql, $params = [] ) {

    $stmt = $this->query( $sql, $params );

    $count = $stmt->rowCount();

    $stmt->closeCursor();

    return $count;

  }

  public function run_update( $sql, $params = [] ) {

    $stmt = $this->query( $sql, $params );

    $count = $stmt->rowCount();

    $stmt->closeCursor();

    return $count;

  }

  public function run_delete( $sql, $params = [] ) {

    $stmt = $this->query( $sql, $params );

    $count = $stmt->rowCount();

    $stmt->closeCursor();

    return $count;

  }

  public function query( string $sql, array $params = [] ) {

    try {

      $stmt = $this->prepare( $sql );

      $stmt->execute( $this->fix_params( $params ) );

      return $stmt;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql, $params );

    }
  }

  public function exec( $sql ) {

    $this->log_sql( $sql );

    try {

      return $this->get_pdo()->exec( $sql );

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql );

    }
  }

  public function prepare( $sql, $use_cache = true ) {

    $this->log_sql( $sql );

    try {

      if ( ! $use_cache ) { return $this->get_pdo()->prepare( $sql ); }


      // 2021-04-06 jj5 - NOTE: I'm still thinking about this. I'm not sure if it's worth
      // caching prepared statements or not. In cooperation with the MudDatabaseStatement class
      // I can probably do some instrumentation to determine if caching is useful or not...

      //return $this->get_pdo()->prepare( $sql );


      $hash = mud_hash_bin( $sql );

      $stmt = $this->stmt_cache[ $hash ] ?? null;

      if ( ! $use_cache || ! $stmt ) {

        $stmt = $this->get_pdo()->prepare( $sql );

        $this->stmt_cache[ $hash ] = $stmt;

      }
      else {

        // 2020-02-10 jj5 - as we're going to reuse a prepared statement
        // from the cache, make sure it is not still in use.

        // 2020-02-10 jj5 - SEE: PDOStatement->closeCursor():
        // https://www.php.net/manual/en/pdostatement.closecursor.php

        // 2020-02-10 jj5 - Instead of a call to closeCursor() we do it
        // manually (below) so we can fail if it happens...
        //
        //$this->stmt_cache[ $hash ]->closeCursor();

        // 2020-02-10 jj5 - the statement should be finished with, but just check...

        $fail = false;

        do {

          if ( $stmt->fetch() ) { $fail = true; }

          while ( $stmt->fetch() );

        }
        while ( $stmt->nextRowset() );

        // 2020-02-10 jj5 - this should be redundant, but what the hell...
        //
        $stmt->closeCursor();

        if ( $fail ) {

          $this->fail( MUD_ERR_DATABASE_STATEMENT_IS_ALREADY_OPEN, [ 'sql' => $sql ] );

        }
      }

      return $stmt;

    }
    catch ( Exception $ex ) {

      $this->rethrow( $ex, $sql );

    }
  }

  public function lastInsertId() {

    return intval( $this->get_pdo()->lastInsertId() );

  }

  public function rethrow(
    $ex,
    $sql = null,
    $params = null
  ) {

    static $intercepts = [

      'SQLSTATE[42000]: Syntax error or access violation: ' .
      '1071 Specified key was too long;'
      => MUD_ERR_DATABASE_SPECIFIED_KEY_IS_TOO_LONG,

      'SQLSTATE[HY000]: General error: 1205 Lock wait timeout exceeded;'
      => MUD_ERR_DATABASE_LOCK_WAIT_TIMEOUT_EXCEEDED,

      'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry'
      => MUD_ERR_DATABASE_ENTRY_IS_DUPLICATE

    ];

    // 2019-08-04 jj5 - THINK: I'm not sure if rethrowing here is the best
    // idea...
    //
    // 2020-03-17 jj5 - It's not the best idea. Removed.
    //
    //if ( is_a( $ex, 'MudException' ) ) { throw $ex; }

    $data = [];

    if ( $sql !== null ) { $data[ 'sql' ] = $sql; }
    if ( $params !== null ) { $data[ 'params' ] = $params; }

    $message = $ex->getMessage();

    foreach ( $intercepts as $intercept => $error_code ) {

      if ( strpos( $message, $intercept ) === 0 ) {

        $this->fail( $error_code, $data, $ex );

      }
    }

    $this->fail( MUD_ERR_DATABASE_EXCEPTION, $data, $ex );

  }

  public function fail(
    $code_or_message,
    $data = null,
    $previous = null,
    &$code = null,
    &$name = null,
    &$message = null,
    &$hint = null
  ) {

    // 2022-04-10 jj5 - NOTE: we only take codes not messages here...
    //
    assert( is_int( $code_or_message ) );

    $code = $code_or_message;

    $message = "error while processing: " . mud_get_error_text( $code );
    $name = mud_get_error_name( $code );
    $hint = mud_get_error_name( $code );

    throw new_mud_database_exception( $message, $code, $previous, $name, $hint, $data );

  }


  //
  // 2020-03-23 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    // 2019-08-04 jj5 - try to update our connection info prior to
    // serialization...
    //
    try {

      $this->read_connection_info( $this->pdo );

    }
    catch ( Exception $ex ) {;}

    return array_merge( parent::jsonSerialize(), [
      'connection_type' => $this->connection_type,
      'transaction_count' => $this->transaction_count,
      'connection_info' => $this->connection_info,
      'settings' => $this->settings,
    ]);

  }


  //
  // 2019-08-04 jj5 - protected functions...
  //

  protected function parse_table( &$table ) {

    foreach ( $table as &$row ) {

      $this->parse_row( $row );

    }

    return $table;

  }

  protected function parse_row( &$row ) {

    foreach ( $row as $field => $value ) {

      $this->parse_field( $row, $field );

    }

    return $row;

  }

  protected function parse_field( &$row, $field, $default = null ) {

    if ( is_numeric( $field ) ) {

      assert( false, 'numeric fields are deprecated, use a column name instead.' );

      return $row[ $field ];

    }

    if ( ! array_key_exists( $field, $row ) ) { return $default; }

    $value = $row[ $field ];

    $success = false;

    // 2021-03-26 jj5 - TODO: think harder about this...
    //
    if ( function_exists( 'schema' ) ) {

      $parsed_value = schema()->parse( $field, $value, $success );

      if ( $success ) { $row[ $field ] = $parsed_value; return $parsed_value; }

    }

    return $value;

  }

  protected function assert_invariants() {

    assert( is_string( $this->connection_type ) );

    assert( is_int( $this->transaction_count ) );

    assert( $this->transaction_count >= 0 );

    assert( is_array( $this->connection_info ) );

    assert( is_a( $this->settings, 'MudSettings' ) );

    assert( $this->pdo === null || count( $this->connection_info ) );

  }

  protected function log_sql( $sql ) {

    // 2019-12-02 jj5 - it's important that this function runs, at least
    // until $this->table_map and $this->view_map are reset if need be, see
    // below.

    // 2019-12-02 jj5 - THINK: send this via the MUD logging API..?

    if ( false ) {

      //static $max_len = 73;
      static $max_len = 200;

      $log = mb_substr( preg_replace( '/\s+/', ' ', $sql ), 0, $max_len );

      mud_stderr( "\n$log\n" );

    }

    $lines = explode( "\n", $sql );
    $clean_lines = [];

    foreach ( $lines as $line ) {

      $parts = explode( ' -- ', $line, 2 );

      $clean_lines[] = $parts[ 0 ];

    }

    $sql = implode( ' ', $clean_lines );

    $sql = mud_read_acord( $sql );

    $sql = strtolower( $sql );

    $words = explode( ' ', $sql );

    $a_database_operation_enum = $this->read_operation( $words );

    if ( $a_database_operation_enum === 0 ) {

      mud_fail( MUD_ERR_DATABASE_OPERATION_UNSUPPORTED, [ '$words' => $words ] );

    }

    /*
    switch ( $a_database_operation_enum ) {

      case MudDatabaseOperation::CREATE_TABLE :
      case MudDatabaseOperation::ALTER_TABLE :
      case MudDatabaseOperation::DROP_TABLE :

        $this->table_map = [];

        break;

      case MudDatabaseOperation::CREATE_VIEW :
      case MudDatabaseOperation::DROP_VIEW :

        $this->view_map = [];

        break;

    }
    */

    if ( ! array_key_exists( $a_database_operation_enum, $this->operation_map ) ) {

      $this->operation_map[ $a_database_operation_enum ] = 0;

    }

    $this->operation_map[ $a_database_operation_enum ]++;

    $tables = $this->read_tables( $a_database_operation_enum, $words );

    foreach ( $tables as $a_table_name ) {

      if ( ! array_key_exists( $a_database_operation_enum, $this->access_map ) ) {

        $this->access_map[ $a_database_operation_enum ] = [];

      }

      if ( ! array_key_exists( $a_table_name, $this->access_map[ $a_database_operation_enum ] ) ) {

        $this->access_map[ $a_database_operation_enum ][ $a_table_name ] = 0;

      }

      $this->access_map[ $a_database_operation_enum ][ $a_table_name ]++;

      $this->logger->log_table_access(
        $this->connection_type,
        $a_database_operation_enum,
        $a_table_name
      );

    }

    //mud_stderr( "\n{$sql}\n" );

  }

  protected function read_operation( array $words ) : int {

    for ( $i = 0; $i < count( $words ); $i++ ) {

      $word = strtolower( $words[ $i ] );

      if ( $word === 'create' ) {

        return MudDatabaseOperation::GetEnum( 'create-' . strtolower( $words[ $i + 1 ] ) );

      }

      if ( $word === 'alter' ) {

          return MudDatabaseOperation::GetEnum( 'alter-' . strtolower( $words[ $i + 1 ] ) );

      }

      if ( $word === 'drop' ) {

        return MudDatabaseOperation::GetEnum( 'drop-' . strtolower( $words[ $i + 1 ] ) );

      }

      $enum = MudDatabaseOperation::GetEnum( $word );

      if ( $enum ) { return $enum; }

    }

    return null;

  }

  protected function read_tables( int $operation, array $words ) {

    $found = [];

    switch ( $operation ) {

      case MudDatabaseOperation::CREATE_DATABASE :
      case MudDatabaseOperation::CREATE_TABLE :
      case MudDatabaseOperation::CREATE_VIEW :
      case MudDatabaseOperation::CREATE_INDEX :
      case MudDatabaseOperation::CREATE_PROCEDURE :
      case MudDatabaseOperation::CREATE_FUNCTION :
      case MudDatabaseOperation::CREATE_OTHER :
      case MudDatabaseOperation::ALTER_TABLE :
      case MudDatabaseOperation::DROP_DATABASE :
      case MudDatabaseOperation::DROP_TABLE :
      case MudDatabaseOperation::DROP_VIEW :
      case MudDatabaseOperation::DROP_INDEX :
      case MudDatabaseOperation::DROP_PROCEDURE :
      case MudDatabaseOperation::DROP_FUNCTION :
      case MudDatabaseOperation::DROP_OTHER :

        $found[] = $words[ 2 ];

        break;

      case MudDatabaseOperation::INSERT :
      case MudDatabaseOperation::UPDATE :
      case MudDatabaseOperation::REPLACE :

        $found[] = $words[ 1 ] === 'into' ? $words[ 2 ] : $words[ 1 ];

        break;

      case MudDatabaseOperation::DELETE :

        $found[] = $words[ 1 ] === 'from' ? $words[ 2 ] : $words[ 1 ];

        break;

      case MudDatabaseOperation::SELECT :

        for ( $i = 0; $i < count( $words ); $i++ ) {

          switch ( $words[ $i ] ) {

            case 'from':
            case 'join':

              $found[] = $words[ ++$i ];

              break;

          }
        }

        break;

      case MudDatabaseOperation::CALL :
      case MudDatabaseOperation::SET :

        break;

      default :

        mud_not_supported( [ 'operation' => $operation ] );

    }

    $result = [];

    foreach ( $found as $table ) {

      $result[] = trim( $table, '`' );

    }

    return $result;

  }

  protected function fix_params( $params ) {

    if ( ! $params ) { return []; }

    if ( ! is_array( $params ) ) { return []; }

    // 2019-07-08 jj5 - check if mods are necessary first, if they're not
    // necessary then don't do them...

    $needs_fix = false;

    foreach ( $params as $key => $value ) {

      if ( is_bool( $value ) ) { $needs_fix = true; break; }

      if ( $key[ 0 ] !== ':' ) { $needs_fix = true; break; }

    }

    if ( ! $needs_fix ) { return $params; }

    // 2019-07-08 jj5 - if we reach here we have boolean values which need
    // to be converted to integers and/or keys which need leading semicolons.

    $result = [];

    foreach ( $params as $key => $value ) {

      if ( is_bool( $value ) ) { $value = $value ? 1 : 0; }

      if ( $key[ 0 ] !== ':' ) { $key = ':' . $key; }

      $result[ $key ] = $value;

    }

    return $result;

  }

  protected function get_pdo() {

    if ( $this->pdo === null ) { $this->connect(); }

    $reconnect = false;

    try {

      // 2019-08-04 jj5 - SEE: ATTR_SERVER_INFO example at StackOverflow:
      // https://stackoverflow.com/a/31786119
      //
      $state = $this->pdo->getAttribute( PDO::ATTR_SERVER_INFO );

      if ( $state === 'MySQL server has gone away' ) {

        mud_log_4_warning( $state );

        $reconnect = true;

      }
    }
    catch ( Exception $ex ) {

      mud_log_exception_handled( $ex );

      $reconnect = true;

    }

    if ( $reconnect ) {

      $this->trace( 'auto reconnect...' );

      $this->connect();

    }

    return $this->pdo;

  }

  protected function connect() {

    static $well_known_connection_types = [
      MUD_CONNECTION_TYPE_TRN,
      MUD_CONNECTION_TYPE_RAW,
      MUD_CONNECTION_TYPE_EMU,
      MUD_CONNECTION_TYPE_AUX,
      MUD_CONNECTION_TYPE_DBA,
    ];

    static $isolation_levels = [
      'read uncommitted',
      'read committed',
      'repeatable read',
      'serializable',
    ];

    $this->trace( 'connecting...' );

    $s = $this->settings;

    $db_name          = $s->db_name;
    $db_host          = $s->db_host;
    $db_user          = $s->db_user;
    $db_pass          = $s->db_pass;
    $ssl_key          = $s->ssl_key;
    $ssl_ca           = $s->ssl_ca;
    $ssl_cipher       = $s->ssl_cipher;
    $time_zone        = $s->time_zone;
    $prefix           = $s->prefix;

    $connection_type = $this->connection_type;

    $charset          = 'utf8mb4';
    $isolation        = 'REPEATABLE READ';
    $autocommit       = $connection_type === MUD_CONNECTION_TYPE_TRN ? 0 : 1;
    $emulate_prepares = $connection_type === MUD_CONNECTION_TYPE_EMU ? 1 : 0;

    // 2021-04-14 jj5 - if this connection isn't one of our well known connections, or if it's an
    // AUX connection, read these extra options from the settings...
    //
    if ( ! in_array( $connection_type, $well_known_connection_types, $strict = true ) ) {

      $charset          = $s->charset;
      $isolation        = $s->isolation;
      $autocommit       = $s->autocommit;
      $emulate_prepares = $s->emulate_prepares;

    }

    $isolation = strtolower( $isolation );

    if ( ! in_array( $isolation, $isolation_levels ) ) {

      mud_fail(
        MUD_ERR_DATABASE_ISOLATION_LEVEL_IS_INVALID,
        [ 'isolation' => $isolation ]
      );

    }

    $options = [

      // 2019-07-08 jj5 - standard PDO settings...
      //
      PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,

      // 2019-07-08 jj5 - this is a little bit meddlesome, but we do it to
      // fix up INFORMATION_SCHEMA artefacts which are annoyingly upper case.
      //
      PDO::ATTR_CASE                      => PDO::CASE_LOWER,

      PDO::ATTR_ORACLE_NULLS              => PDO::NULL_NATURAL,

      // 2020-09-10 jj5 - THINK: do we stringify or not..?
      //
      // 2021-03-30 jj5 - NOTE: we definitely don't stringify fetches, at least not now. If it
      // turns out we need to use emulated prepares (see below) then maybe we will stringify
      // fectches for the sake of having consistent results... but that would be annoying so
      // not doing that  yet...
      //
      PDO::ATTR_STRINGIFY_FETCHES         => false,

      PDO::ATTR_TIMEOUT                   => 20,
      PDO::ATTR_AUTOCOMMIT                => $autocommit,

      // 2021-03-30 jj5 - LAME: man this sucks. If we emulate prepares then results are
      // stringified, i.e. integers come back as strings. We don't want that, so we don't
      // emulate prepares. If that ends up causing a problem we will need to change the setting
      // and then update all of our code to expect strings in place of ints.
      //
      PDO::ATTR_EMULATE_PREPARES          => $emulate_prepares,

      PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
      PDO::ATTR_PERSISTENT                => false,

      // 2021-04-06 jj5 - OLD: this was removed for two reasons. a) it's the default setting
      // to use buffered queries anyway, and b) it doesn't get applied to the connection, you
      // apply it to the statement when you prepare it. So this is not only useless, it is also
      // wrong.
      //
      // 2019-07-08 jj5 - MySQL specific settings...
      //
      //PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => true,

      // 2021-04-06 jj5 - NOTE: at the moment we hijack the PDOStatement class with our own
      // version, but we don't export a mechanism for the caller to override this. If that
      // becomes useful or necessary we can make this setting configurable...
      //
      PDO::ATTR_STATEMENT_CLASS           => [ MudDatabaseStatement::class, [ $this ] ],

      // 2021-04-06 jj5 - SEE: MySQL specific attributes:
      // https://dev.mysql.com/doc/connectors/en/apis-php-pdo-mysql.html

      // 2021-04-06 jj5 - NOTE: I disable multi-statements in the hope of limiting the damage
      // if there is a SQL injection attack... which, of course, there should never be...
      //
      PDO::MYSQL_ATTR_MULTI_STATEMENTS    => false,

    ];

    if ( $ssl_cipher ) {

      // 2019-07-08 jj5 - MySQL SSL settings...
      //
      $options[ PDO::MYSQL_ATTR_SSL_KEY     ] = $ssl_key;
   // $options[ PDO::MYSQL_ATTR_SSL_CERT    ] = leave unspecified...
      $options[ PDO::MYSQL_ATTR_SSL_CA      ] = $ssl_ca;
      $options[ PDO::MYSQL_ATTR_SSL_CIPHER  ] = $ssl_cipher;

    }

    $dsn = 'mysql:dbname=' . $db_name . ';host=' . $db_host . ';charset=' . $charset;

    $pdo = new_php_pdo( $dsn, $db_user, $db_pass, $options );

    // 2019-08-04 jj5 - THINK: the following exec() functions slow down our
    // connection to our database so we should perhaps review them for their
    // actual usefulness/necessity...

    $connection_type_sql = $pdo->quote( $connection_type );

    $pdo->exec( 'SET @connection_type = ' . $connection_type_sql );

    $time_zone_sql = $pdo->quote( $time_zone );

    //$pdo->exec( "SET TIME_ZONE = '$time_zone'" );
    $pdo->exec( 'SET TIME_ZONE = ' . $time_zone_sql );

    // 2018-07-20 jj5 - SEE: SQL Mode:
    // https://dev.mysql.com/doc/refman/8.0/en/sql-mode.html
    //
    $pdo->exec( "SET SQL_MODE='TRADITIONAL'" );

    // 2019-07-08 jj5 - SEE: SET TRANSACTION:
    // https://mariadb.com/kb/en/library/set-transaction/
    //
    $pdo->exec( "SET SESSION TRANSACTION ISOLATION LEVEL " . $isolation );

    // 2019-07-08 jj5 - SEE: SET NAMES Syntax:
    // https://dev.mysql.com/doc/refman/5.7/en/set-names.html
    //
    // 2019-07-08 jj5 - SEE: Why is table CHARSET set to utf8mb4 and COLLATION
    // to utf8mb4_unicode_520_ci:
    // https://stackoverflow.com/a/43692337
    //
    $pdo->exec( 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_520_ci' );

    if ( $connection_type === MUD_CONNECTION_TYPE_TRN ) {

      $pdo->exec( 'SET FOREIGN_KEY_CHECKS=0' );

    }

    $this->read_connection_info( $pdo );

    $this->transaction_count = 0;
    $this->pdo = $pdo;

    if ( $this->connection_type !== MUD_CONNECTION_TYPE_RAW ) {

      mud_register_new_connection( $this->connection_type, $this );

    }

    $this->set_lock_timeout( 1 );

    // 2019-10-09 jj5 - e.g.: mysqlnd 5.0.12-dev - 20150407:
    //var_dump( $pdo->getAttribute( PDO::ATTR_CLIENT_VERSION ) ); mud_exit();

    $this->trace( 'connected.' );

  }

  protected function read_connection_info( $pdo ) {

    $this->trace( 'reading connection info...' );

    // 2019-08-04 jj5 - SEE: inspired by the PHP doco:
    // https://www.php.net/manual/en/pdo.getattribute.php
    //
    static $attributes = [

      'AUTOCOMMIT',
      'CASE',
      'CLIENT_VERSION',
      'CONNECTION_STATUS',
      'DRIVER_NAME',
      'ERRMODE',
      'ORACLE_NULLS',
      'PERSISTENT',

      // 2019-08-04 jj5 - 'PREFETCH' doesn't seem to be supported...
      //
      //'PREFETCH',

      'SERVER_INFO',
      'SERVER_VERSION',

      // 2019-08-04 jj5 - 'TIMEOUT' doesn't seem to be supported...
      //
      //'TIMEOUT',

    ];

    // 2019-08-04 jj5 - NOTE: if our $pdo connection is not available then
    // leave the $this->connection_info as it was...
    //
    if ( $pdo === null ) {

      $this->trace( 'no active connection.' );

      return;

    }

    $this->connection_info = [];

    foreach ( $attributes as $attr ) {

      try {

        $value = $pdo->getAttribute( constant( "PDO::ATTR_$attr" ) );

      }
      catch ( Exception $ex ) {

        $this->warn( 'No value for attribute.', [ 'attr' => $attr ] );

        continue;

      }

      $this->connection_info[ $attr ] = $value;

    }

    $this->trace( 'read connection info.' );

  }
}
