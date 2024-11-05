<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - class definition...
//

class MudCache extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - class constants...
  //

  // 2021-04-11 jj5 - this is the number of times we retry database transactions before we give
  // up. We can fail a lot due to contention so it's best to keep this number fairly high... in
  // between retries we can processes remedial action such as reconnecting to the database or
  // deleting the database file to start afresh...
  //
  public const CACHE_RETRY = 10000;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - private fields...
  //

  // 2021-04-11 jj5 - the $name is the name of the cache, e.g. 'dal'...
  //
  private $name;

  // 2021-04-11 jj5 - this is the serialization strategy we will use if a given container does not
  // have a specific serializer registered...
  //
  private $default_serializer;

  // 2021-04-11 jj5 - the $pdo object is our PDO connection to our SQLite database...
  //
  private $pdo = null;

  // 2021-04-11 jj5 - this is the $path to the SQLite database file...
  //
  private $path = null;

  // 2021-04-11 jj5 - the $table_map maps cache containers to table names in the SQLite database...
  //
  private $table_map = [];

  // 2021-04-11 jj5 - the $serializer_map maps cache containers to value serialization functions.
  // Note that if no serializer is found the default serializer is used...
  //
  private $serializer_map = [];

  // 2021-04-11 jj5 - the $telemetry_map maps cache containers to telemetry objects for counting
  // various types of events as they occur for logging and analysis purposes...
  //
  private $telemetry_map = [];

  // 2021-04-11 jj5 - when we're finished we process our telemetry data in the $telemetry_map
  // and store totals in $telemetry_total...
  //
  private $telemetry_total = null;

  // 2021-04-10 jj5 - NOTE: we cache a delete, insert, and select prepared statement for each
  // table we support. If something goes wrong with a prepared statement while you're using it
  // remove it from the cache so a new one can be created for future use.
  //
  // 2021-04-11 jj5 - UPDATE: actually we don't use the delete statement any more... note that
  // these maps are for PDOStatement objects and are keyed by table name. Get the table name for
  // a cache container from the $table_map (above)...
  //
  //private $stmt_delete;
  private $stmt_insert;
  private $stmt_select;

  private $start_time;
  private $duration = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - constructor...
  //

  public function __construct( $name, $default_serializer = null ) {

    parent::__construct();

    $this->name = $name;

    if ( $default_serializer === null ) {

      // 2021-04-11 jj5 - NOTE: we use PHP instead of JSON by default because JSON doesn't play
      // well with binary data, such as the binary hash keys we use all over the place...
      //
      $default_serializer = $this->get_php_serializer();

    }

    $this->default_serializer = $default_serializer;

    $this->start_time = $this->get_microtime_now();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public static methods...
  //

  public static function Delete( $cache_name ) {

    $cwd = getcwd();

    $path = self::GetCachePath( $cache_name, $dir, $file_name );

    mud_chdir( $dir );

    foreach ( glob( "$file_name*" ) as $file ) {

      assert( is_file( $file ) );

      mud_unlink( $file );

    }

    mud_chdir( $cwd );

    if ( mud_is_dir_empty( $dir ) ) {

      mud_rmdir( $dir );

    }

    assert( ! is_file( $path ) );

  }

  public static function GetCachePath( $cache_name, &$dir = null, &$file_name = null ) {

    if ( defined( 'APP_SLUG' ) ) {

      return self::GetCachePathProd( $cache_name, $dir, $file_name );

    }

    return self::GetCachePathTest( $cache_name, $dir, $file_name );

  }

  public static function ValidateFileNamePart( $part ) {

    if ( strlen( $part ) > 128 ) {

      // 2021-04-11 jj5 - 128 characters is fairly long...

      mud_fail( MUD_ERR_CACHE_INVALID_FILE_NAME_PART, [ 'part' => $part ] );

    }

    if ( strpos( $part, '..' ) !== false ) {

      // 2021-04-11 jj5 - double dot is not allowed...

      mud_fail( MUD_ERR_CACHE_INVALID_FILE_NAME_PART, [ 'part' => $part ] );

    }

    if ( ! preg_match( '/^[a-z][a-z0-9_\-\.]*$/i', $part ) ) {

      // 2021-04-11 jj5 - that should be fairly safe...

      mud_fail( MUD_ERR_CACHE_INVALID_FILE_NAME_PART, [ 'part' => $part ] );

    }
  }

  public static function CreatePDO( $path, $fetch_mode = PDO::FETCH_NUM, $opt = [] ) {

    return mud_sqlite_create_pdo( $path, $fetch_mode, $opt );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - protected static methods...
  //

  protected static function GetCachePathProd( $cache_name, &$dir = null, &$file_name = null ) {

    assert( defined( 'APP_CODE' ) );
    assert( defined( 'APP_SLUG' ) );

    $app_code = APP_CODE;
    $app_slug = APP_SLUG;

    if ( defined( 'APP_CACHE_DIR' ) ) {

      $dir  = APP_CACHE_DIR;

    }
    else {

      self::ValidateFileNamePart( $app_code );

      //$dir  = "/var/state/$app_code";

      $dir = mud_get_config( [ 'app', 'state', 'dir' ] );

    }

    if ( ! mud_is_dir( $dir ) ) {

      mud_fail( MUD_ERR_CACHE_MISSING_STATE_DIRECTORY, [ 'dir' => $dir ] );

    }

    $dir = "$dir/cache";

    if ( ! mud_is_dir( $dir ) ) {

      mud_mkdir( $dir );

    }

    if ( mud_get_username() === 'root' ) {

      mud_chown( $dir, 'www-data', 'www-data' );

    }

    self::ValidateFileNamePart( $app_slug );
    self::ValidateFileNamePart( $cache_name );

    $file_name = "cache-{$app_slug}-{$cache_name}.sqlite3";

    $file_path = "{$dir}/{$file_name}";

    mud_touch( $file_path );

    if ( mud_get_username() === 'root' ) {

      mud_chown( $file_path, 'www-data', 'www-data' );

    }

    return $file_path;

  }

  protected static function GetCachePathTest( $cache_name, &$dir = null, &$file_name = null ) {

    if ( defined( 'APP_CACHE_DIR' ) ) {

      $dir  = APP_CACHE_DIR;

    }
    else {

      // 2021-04-11 jj5 - pick one of these... or define APP_CACHE_DIR... or whatever...

      $dir = "/dev/shm";

      $dir = "/home/jj5/desktop";

    }

    if ( ! mud_is_dir( $dir ) ) {

      mud_fail( MUD_ERR_CACHE_MISSING_STATE_DIRECTORY, [ 'dir' => $dir ] );

    }

    $dir = "$dir/mudball-test";

    if ( ! mud_is_dir( $dir ) ) {

      mud_mkdir( $dir );

    }

    if ( mud_get_username() === 'root' ) {

      mud_chown( $dir, 'www-data', 'www-data' );

    }

    self::ValidateFileNamePart( $cache_name );

    $file_name = "cache-{$cache_name}.sqlite3";

    $file_path = "{$dir}/{$file_name}";

    mud_touch( $file_path );

    if ( mud_get_username() === 'root' ) {

      mud_chown( $file_path, 'www-data', 'www-data' );

    }

    return $file_path;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public interface...
  //

  public function get_path() { return $this->path; }

  public function get_default_serializer() {

    return $this->default_serializer;

  }

  public function set_default_serializer( $default_serializer ) {

    $this->default_serializer = $default_serializer;

  }

  public function register_serializer( $container, $serializer ) {

    $this->serializer_map[ $container ] = $serializer;

  }

  public function get_json_serializer() {

    static $instance = null;

    if ( $instance === null ) { $instance = new_mud_serialization_for_json(); }

    return $instance;

  }

  public function get_php_serializer() {

    static $instance = null;

    if ( $instance === null ) { $instance = new_mud_serialization_for_php(); }

    return $instance;

  }

  public function get_duration() { return $this->duration; }
  public function get_telemetry_total() { return $this->telemetry_total; }

  public function get_table_name( $container ) {

    // 2021-04-10 jj5 - this way:

    $result = $this->table_map[ $container ] ?? null;

    if ( $result === null ) {

      $result = $this->table_map[ $container ] = 't_' . mud_hash( $container );

    }

    return $result;

    // 2021-04-10 jj5 - is faster than this way:

    if ( ! array_key_exists( $container, $this->table_map ) ) {

      $this->table_map[ $container ] = 't_' . mud_hash( $container );

    }

    return $this->table_map[ $container ];

  }

  public function get_cache_key( $id ) {

    //$key = json_encode( $id, MUD_JSON_COMPACT );
    $key = serialize( $id );

    if ( ! is_string( $key ) ) { mud_fail( MUD_ERR_CACHE_INVALID_ID, [ 'id' => $id ] ); }

    // 2021-04-11 jj5 - NOTE: okay, so. It would be nice to use MD5 because it's small and
    // fast, but it's not secure. If we used MD5 it is conceivable some smarty pants will
    // craft an $id value that indicates data for some other legitimate ID and then reads
    // that other value... better to take the performance hit (it's about 10%) and stay
    // secure...
    //
    $cache_key = hash( 'sha512/224', $key, true );
    //$cache_key = hash( 'sha256', $key, true );
    //$cache_key = mud_hash( $key, true );

    return $cache_key;

  }

  // 2021-04-11 jj5 - the read() method will search for an existing object in the cache. Note
  // that this function generates the $cache_key which the caller will need to keep if they are
  // to write() a missing entry into the cache after a cache miss...
  //
  // 2021-04-11 jj5 - so basically the way this works is that for a particular $container we use
  // the $id to try and find a $value. We convert the $id into a $cache_key and then look for that
  // $cache_key for that $container in the database. If we find something we read it into the
  // $value output variable and return true; otherwise we return false. Note that $id can be, and
  // often will be, a complex type such as an map with a key => value pair.
  //
  // 2021-04-11 jj5 - NOTE: so there is an encoding strategy supported for values in $value but
  // the $id is always converted to JSON then hashed. You can pick the serialization strategy
  // for $value (JSON or PHP) but not for $id.
  //
  public function read( $container, $id, &$cache_key, &$value ) {

    $cache_key = $this->get_cache_key( $id );

    $this->get_telemetry( $container )->read_init();

    for ( $try = 1; $try <= self::CACHE_RETRY; $try++ ) {

      $pdo = $this->get_pdo();

      //assert( ! $pdo->inTransaction() );

      try {

        $row = $this->select_item( $container, $cache_key );

        if ( $row === false ) {

          $value = null;

          $this->get_telemetry( $container )->increment_miss_count();

          return false;

        }

        $value = $this->decode_value( $container, $row[ 0 ] );

        $this->get_telemetry( $container )->increment_hit_count();

        //$duration = microtime( true ) - $start_time;

        //$this->get_telemetry( $container )->transaction_time += $duration;

        return true;

      }
      catch ( Exception $ex ) {

        $this->handle_exception( $ex, $pdo, $container, $try );

      }
    }

    mud_fail( MUD_ERR_CACHE_RETRY_LIMIT_EXCEEDED, [ 'func' => __FUNCTION__, 'try' => $try ] );

  }

  public function write( $container, $cache_key, $value ) {

    $this->get_telemetry( $container )->write_init();

    //$start_time = microtime( true );

    for ( $try = 1; $try <= self::CACHE_RETRY; $try++ ) {

      $pdo = $this->get_pdo();

      //assert( ! $pdo->inTransaction() );

      $pdo->beginTransaction();

      try {

        $table = $this->get_table_name( $container );

        /*
        $params = [ ':key' => $cache_key ];

        try {

          $this->get_stmt_delete( $table )->execute( $params );

        }
        catch ( Exception $ex ) {

          unset( $this->stmt_delete[ $table ] );

          throw $ex;

        }
        */

        //$json = json_encode( $value, MUD_JSON_COMPACT );
        $data = $this->encode_value( $container, $value );

        $params = [ ':key' => $cache_key, ':value' => $data ];

        try {

          $this->get_stmt_insert( $table )->execute( $params );

        }
        catch ( Exception $ex ) {

          unset( $this->stmt_insert[ $table ] );

          throw $ex;

        }

        $pdo->commit();

        $this->get_telemetry( $container )->increment_write_count();

        //$duration = microtime( true ) - $start_time;

        //$this->get_telemetry( $container )->transaction_time += $duration;

        return $value;

      }
      catch ( Exception $ex ) {

        if (

          preg_match(
            '/^SQLSTATE\[23000\]: Integrity constraint violation: \d+ UNIQUE constraint failed:/',
            $ex->getMessage()
          )

        ) {

          // 2021-04-10 jj5 - we can ignore this, it just means we lost a race...

          $pdo->rollBack();

          if ( DEBUG ) {

            // 2021-04-11 jj5 - here we just check that the value we were supposed to have
            // inserted is actually the value that was inserted... there's no reason to assume
            // it would be otherwise but it never hurts to check... :)

            $row = $this->select_item( $container, $cache_key );

            //var_dump( [ 'data' => $data, 'row0' => $row[ 0 ] ] );

            assert( $data === $row[ 0 ] );

          }

          $this->get_telemetry( $container )->increment_write_race_lost_count();

          return $value;

        }
        else {

          $this->handle_exception( $ex, $pdo, $container, $try );

        }
      }
    }

    mud_fail( MUD_ERR_CACHE_RETRY_LIMIT_EXCEEDED, [ 'func' => __FUNCTION__, 'try' => $try ] );

  }

  public function complete() {

    if ( $this->duration !== null && $this->telemetry_total !== null ) { return; }

    assert( $this->duration === null );
    assert( $this->telemetry_total === null );

    // 2021-04-11 jj5 - NOTE: the "totals" only count cache data which was accessed in the
    // current interaction. So the row_count is only the total number of cache items for
    // containers which were accessed, other cache data for other unaccessed containers may well
    // exist in the cache SQLite database.

    $duration = $this->duration = $this->get_microtime_now() - $this->start_time;
    $serialization_type_enum = $this->default_serializer->get_type();

    $row_count = 0;
    $op_count = 0;
    $op_time = 0;
    $read_count = 0;
    $read_time = 0;
    $write_count = 0;
    $write_time = 0;
    $hit_count = 0;
    $miss_count = 0;
    $write_race_lost_count = 0;
    $new_table_count = 0;
    $error_count = 0;
    $contention_count = 0;
    $reconnect_count = 0;
    $reset_count = 0;

    foreach ( $this->telemetry_map as $container => $telemetry ) {

      $row_count_for_container = $this->get_row_count( $container );

      $telemetry->complete( $row_count_for_container );

      $row_count += $row_count_for_container;
      $op_count += $telemetry->get_op_count();
      $op_time += $telemetry->get_op_time();
      $read_count += $telemetry->get_read_count();
      $read_time += $telemetry->get_read_time();
      $write_count += $telemetry->get_write_count();
      $write_time += $telemetry->get_write_time();
      $hit_count += $telemetry->get_hit_count();
      $miss_count += $telemetry->get_miss_count();
      $write_race_lost_count += $telemetry->get_write_race_lost_count();
      $new_table_count += $telemetry->get_new_table_count();
      $error_count += $telemetry->get_error_count();
      $contention_count += $telemetry->get_contention_count();
      $reconnect_count += $telemetry->get_reconnect_count();
      $reset_count += $telemetry->get_reset_count();

    }

    $this->telemetry_total = new_mud_cache_telemetry_data(
      $duration,
      $row_count,
      $serialization_type_enum,
      $op_count,
      $op_time,
      $read_count,
      $read_time,
      $write_count,
      $write_time,
      $hit_count,
      $miss_count,
      $write_race_lost_count,
      $new_table_count,
      $error_count,
      $contention_count,
      $reconnect_count,
      $reset_count
    );

  }

  // 2021-04-11 jj5 - this report() method is just for debugging purposes...
  //
  public function report() {

    if ( $this->duration === null || $this->telemetry_total === null ) {

      $this->complete();

    }

    assert( $this->duration );
    assert( $this->telemetry_total );

    $container_count = count( $this->telemetry_map );

    $total_data = $this->get_telemetry_total();

    foreach ( $this->telemetry_map as $container => $telemetry ) {

      $telemetry->report();

    }

    $container_count = number_format( $container_count );

    echo "total:\n\n      containers.............: {$container_count}\n{$total_data}\n";

  }

  public function destroy() {

    $this->pdo = null;

    self::Delete( $this->name );

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - protected methods...
  //

  protected function encode_value( $container, $value ) {

    return $this->get_serializer( $container )->encode( $value );

  }

  protected function decode_value( $container, $encoded_data ) {

    return $this->get_serializer( $container )->decode( $encoded_data );

  }

  protected function select_item( $container, $cache_key ) {

    $table = $this->get_table_name( $container );

    $params = [ ':key' => $cache_key ];

    try {

      $stmt = $this->get_stmt_select( $table );

      $stmt->execute( $params );

      $row = $stmt->fetch();

      // 2021-04-10 jj5 - this doesn't seem to be necessary...
      //
      //$stmt->closeCursor();

      return $row;

    }
    catch ( Exception $ex ) {

      unset( $this->stmt_select[ $table ] );

      throw $ex;

    }
  }

  protected function handle_exception( $ex, $pdo, $container, $try ) {

    try {

      if ( $pdo->inTransaction() ) { $pdo->rollBack(); }

    }
    catch ( Throwable $ignore ) {

      mud_log_exception_ignored( $ignore );

    }

    switch ( $msg = $ex->getMessage() ) {

      case 'SQLSTATE[HY000]: General error: 5 database is locked' :

        // 2021-04-10 jj5 - this is normal and can happen. When it happens we just log the
        // contention, wait a small random amount of time, and wait to be retried...

        $this->handle_contention( $container, $try );

        break;

      case 'SQLSTATE[HY000]: General error: 8 attempt to write a readonly database' :
      case 'SQLSTATE[HY000]: General error: 10 disk I/O error' :
      case 'SQLSTATE[HY000]: General error: 14 unable to open database file' :

        // 2021-04-10 jj5 - these can happen if the SQLite database file gets deleted. If that
        // happens try to reconnect...

        $this->handle_reconnect( $container, $ex );

        break;

      case 'SQLSTATE[HY000]: General error: 11 database disk image is malformed' :
      case 'SQLSTATE[HY000]: General error: 26 file is not a database' :

        // 2021-04-10 jj5 - well that's gotta be bad... let's try starting the cache from
        // scratch...

        $this->handle_reset( $container, $ex );

        break;

      default : {

        if ( preg_match( '/^SQLSTATE\[HY000\]: General error: \d+ no such table:/', $msg ) ) {

          // 2021-04-10 jj5 - this is quite normal too. If an underlying table for a given
          // $container hasn't already been created it will raise this error so we can create it
          // here... put in the 'if not exists' because we're racing other processes to
          // create the table...

          $this->handle_create( $container );

        }
        else {

          mud_fail( MUD_ERR_CACHE_UNRECOVERABLE_PDO_ERROR, [ 'msg' => $msg ], $ex );

        }
      }
    }
  }

  protected function handle_contention( $container, $try ) {

    $this->get_telemetry( $container )->increment_contention_count();

    //usleep( random_int( 1, 10 ) );

    //if ( $try % 50 === 0 ) {

      $this->pdo = null;

    //}
  }

  protected function handle_reconnect( $container, $ex ) {

    $this->get_telemetry( $container )->increment_err_count();

    mud_log_exception_handled( $ex );

    $this->pdo = null;

  }

  protected function handle_reset( $container, $ex ) {

    $this->get_telemetry( $container )->increment_err_count();

    mud_log_exception_handled( $ex );

    $this->pdo = null;

    $path = $this->get_sqlite_file_path();

    mud_retry( function() use ( $path ) { return @unlink( $path ); } );

  }

  protected function handle_create( $container ) {

    for ( $try = 1; $try <= self::CACHE_RETRY; $try++ ) {

      $pdo = $this->get_pdo();

      try {

        $table = $this->get_table_name( $container );

        $create_table_sql = "
          create table if not exists $table (
            key BLOB UNIQUE,
            value
          )
        ";

        $pdo->exec( $create_table_sql );

        $this->get_telemetry( $container )->increment_new_table_count();

        return;

      }
      catch ( Exception $ex ) {

        $this->handle_exception( $ex, $pdo, $container, $try );

      }
    }

    mud_fail( MUD_ERR_CACHE_RETRY_LIMIT_EXCEEDED, [ 'func' => __FUNCTION__, 'try' => $try ] );

  }

  /*
  protected function get_stmt_delete( $table ) {

    $result = $this->stmt_delete[ $table ] ?? null;

    if ( $result === null ) {

      $sql = "
        delete from
          $table
        where
          key = :key
      ";

      $result = $this->stmt_delete[ $table ] = $this->get_pdo()->prepare( $sql );

    }

    return $result;

  }
  */

  protected function get_stmt_insert( $table ) {

    $result = $this->stmt_insert[ $table ] ?? null;

    if ( $result === null ) {

      $sql = "
        insert into $table (
          key,
          value
        )
        values (
          :key,
          :value
        )
      ";

      $result = $this->stmt_insert[ $table ] = $this->get_pdo()->prepare( $sql );

    }

    return $result;

  }

  protected function get_stmt_select( $table ) {

    $result = $this->stmt_select[ $table ] ?? null;

    if ( $result === null ) {

      $sql = "
        select
          value
        from
          $table
        where
          key = :key
      ";

      $result = $this->stmt_select[ $table ] = $this->get_pdo()->prepare( $sql );

    }

    return $result;

  }

  protected function get_pdo() {

    if ( $this->pdo ) { return $this->pdo; }

    // 2021-04-11 jj5 - if we're connecting or reconnecting make sure any cached prepared
    // statements don't get reused...
    //
    //$this->stmt_delete = [];
    $this->stmt_insert = [];
    $this->stmt_select = [];

    $this->path = $path = $this->get_sqlite_file_path();

    return $this->pdo = self::CreatePDO( $path );

  }

  protected function get_sqlite_file_path() {

    return self::GetCachePath( $this->name );

  }

  protected function get_telemetry( $container ) {

    $result = $this->telemetry_map[ $container ] ?? null;

    if ( $result === null ) {

      $result = $this->telemetry_map[ $container ] = new_mud_cache_telemetry(
        $this->name,
        $container,
        $this->get_serializer( $container )->get_type()
      );

    }

    return $result;

  }

  protected function get_serializer( $container ) {

    return $this->serializer_map[ $container ] ?? $this->default_serializer;

  }

  protected function get_row_count( $container ) {

    $pdo = $this->get_pdo();

    $table = $this->get_table_name( $container );

    $sql = "select count(*) as count from $table";

    $stmt = $pdo->query( $sql );

    $row = $stmt->fetch();

    $stmt->closeCursor();

    return intval( $row[ 0 ] );

  }

  protected function get_max_id( $container ) {

    $pdo = $this->get_pdo();

    $table = $this->get_table_name( $container );

    $sql = "select max(rowid) as max_id from $table";

    $stmt = $pdo->query( $sql );

    $row = $stmt->fetch();

    $stmt->closeCursor();

    return intval( $row[ 0 ] );

  }

  protected function log( $line ) {

    //mud_log_6_info( microtime() . ': ' . getmypid() . ": $line" );

  }
}
