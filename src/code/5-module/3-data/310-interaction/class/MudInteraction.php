<?php

class MudInteraction extends MudService {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-25 jj5 - private fields...
  //

  private $start_time = null;
  private $server_id = null;
  private $interaction_id = null;
  private $status_flags = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudInteraction|null $previous = null ) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-25 jj5 - public static methods...
  //

  public static function GetDefaultSoftwareInfo() {

    static $info = null;

    if ( $info === null ) {

      if ( defined( 'MUDBALL_CODE' ) ) {

        $info[ MUDBALL_CODE ] = [
          'software_code'     => MUDBALL_CODE,
          'software_version'  => MUDBALL_VERSION,
          'software_slug'     => MUDBALL_SLUG,
          'basic_version'     => MUDBALL_VERSION_BASIC,
          'major_version'     => MUDBALL_VERSION_MAJOR,
          'minor_version'     => MUDBALL_VERSION_MINOR,
          'patch_version'     => MUDBALL_VERSION_PATCH,
          'build'             => MUDBALL_VERSION_BUILD,
          'vcs_revision'      => MUDBALL_VERSION_VCS_REVISION,
          'vcs_date'          => MUDBALL_VERSION_VCS_DATE,
        ];

      }

      if ( defined( 'APP_CODE' ) ) {

        $info[ APP_CODE ] = [
          'software_code'     => APP_CODE,
          'software_version'  => APP_VERSION,
          'software_slug'     => APP_SLUG,
          'basic_version'     => APP_VERSION_BASIC,
          'major_version'     => APP_VERSION_MAJOR,
          'minor_version'     => APP_VERSION_MINOR,
          'patch_version'     => APP_VERSION_PATCH,
          'build'             => APP_VERSION_BUILD,
          'vcs_revision'      => APP_VERSION_VCS_REVISION,
          'vcs_date'          => APP_VERSION_VCS_DATE,
        ];

      }
    }

    return $info;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-25 jj5 - public instance methods...
  //

  public function get_software_map() {

    // 2022-02-28 jj5 - this method can be overridden to support other software, this default
    // implementation supports the Mudball library and the application using it.

    return self::GetDefaultSoftwareInfo();

  }

  public function get_start_time() {

    $this->init();

    return $this->start_time;

  }

  public function get_server_id() {

    $this->init();

    return $this->server_id;

  }

  public function get_interaction_id() {

    $this->init();

    return $this->interaction_id;

  }

  public function reinit() {

    $this->start_time = null;

    $this->init();

  }

  public function init() {

    if ( $this->start_time !== null ) { return false; }

    $this->start_time = $this->get_microtime_now();

    $init_ok = mud_raw()->wrap( function( $dal, $db, $prefix ) {

      return $this->wrapped_init_new( $dal, $db, $prefix );

    });

    if ( ! $init_ok ) {

      mud_fail( MUD_ERR_INTERACTION_INIT_FAILED );

    }

    register_shutdown_function( [ $this, 'handle_shutdown' ] );

    return true;

  }

  public function register_new_connection( $connection_type, $database ) {

    if ( ! $this->interaction_id ) { return false; }

    if ( DEBUG ) {

      if ( ! mud_raw()->has_table( 't_detail_std_interaction_connection' ) ) {

        assert( false, 'why is t_detail_std_interaction_connection missing?' );

      }
    }

    $connection_id = $this->get_connection_id( $database );

    $connection_type_enum = MudConnectionType::GetEnum( $connection_type );

    mud_raw()->add_row_t_detail_std_interaction_connection(
      $this->interaction_id,
      $connection_type_enum,
      $connection_id
    );

    return true;

  }

  public function handle_shutdown() {

    return $this->log_complete();

  }

  public function log_fail( $ex = null ) {

    if ( ! $this->is_live() ) { return false; }

    $this->require_live();

    // 2022-04-10 jj5 - TODO: log exceptionj details...
    //
    //$this->insert_fail();

    $this->close( MudProcessStatus::DONE + MudProcessStatus::FAIL );

    return true;

  }

  public function log_complete() {

    if ( ! $this->is_live() ) { return false; }

    $this->require_live();

    $this->close( MudProcessStatus::DONE );

    return true;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-24 jj5 - protected methods...
  //

  protected function wrapped_revision_check( $dal, $db, $prefix ) {

    $sql = "
      select
        max( a_std_schema_revision_revision_number ) as revision_number
      from
        {$prefix}t_about_std_schema_revision
      where
        a_std_schema_revision_schema_name = :schema_name
    ";

    $stmt = $db->prepare( $sql );

    foreach ( mud_schemata()->get_rev_map() as $schema_name => $revision_number ) {

      $stmt->execute( [ ':schema_name' => $schema_name ] );

      $table = $stmt->fetchAll();

      $loaded_revision_number = $table[ 0 ][ 'revision_number' ] ?? null;

      if ( $loaded_revision_number !== $revision_number ) { return false; }

      //$valid[ $schema_name ] = $revision_number;

    }

    return true;

  }

  protected function wrapped_init( $dal, $db, $prefix ) {

    // 2023-03-13 jj5 - TODO: fix this function and put it back in to log all the interaction
    // context.

    $hostname = gethostname();

    if ( ! method_exists( $dal, 'get_a_std_server_id_by_hostname' ) ) {

      //var_dump( $dal ); exit;

      mud_fail( 'You need an App DAL not the default Mud DAL.' );

    }

    $server_id = $dal->get_a_std_server_id_by_hostname( $hostname );

    if ( ! $server_id ) {

      $server_id = $dal->add_row_t_about_std_server( $hostname );

    }

    $interaction_id = $dal->add_row_t_abinitio_std_interaction( $server_id );

    $json = json_encode(
      mud_redact_secrets( $GLOBALS ),
      JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES| JSON_UNESCAPED_UNICODE
    );

    $stack = json_encode(
      debug_backtrace(),
      JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES| JSON_UNESCAPED_UNICODE
    );

    $dal->add_row_t_detail_std_interaction_data( $interaction_id, $json, $stack );

    $connection_id = $this->get_connection_id( $dal->get_database() );

    $dal->add_row_t_detail_std_interaction_connection(
      $interaction_id,
      MudConnectionType::RAW,
      $connection_id
    );

    $software_map = $this->get_software_map();

    foreach( $software_map as $software_info ) {

      $software_version_id = $dal->get_a_std_software_version_id_by_software_code_and_software_version(
        $software_info[ 'software_code' ],
        $software_info[ 'software_version' ]
      );

      if ( ! $software_version_id ) {

        $dal->set_row_t_about_std_software( $software_info[ 'software_code' ] );

        $software_version_id = $dal->add_row_t_about_std_software_version(
          $software_info[ 'software_code' ],
          $software_info[ 'software_version' ],
          $software_info[ 'software_slug' ],
          $software_info[ 'basic_version' ],
          $software_info[ 'major_version' ],
          $software_info[ 'minor_version' ],
          $software_info[ 'patch_version' ],
          $software_info[ 'build' ],
          $software_info[ 'vcs_revision' ],
          $software_info[ 'vcs_date' ]
        );

      }

      $dal->add_row_t_detail_std_interaction_software( $interaction_id, $software_version_id );

    }

    $schema_list = [ MUD_SCHEMA ];

    if ( defined( 'APP_SCHEMA' ) ) { $schema_list[] = APP_SCHEMA; }

    foreach ( $schema_list as $schema_name ) {

      $schema_revision_id = $this->get_schema_revision_id( $schema_name );

      if ( $schema_revision_id === null ) { continue; }

      $dal->add_row_t_detail_std_interaction_schema( $interaction_id, $schema_revision_id );

    }

    $dal->add_row_t_detail_std_interaction_status_live( $interaction_id );

    $this->server_id              = $server_id;
    $this->interaction_id         = $interaction_id;
    $this->status_flags           = MudProcessStatus::LIVE;

    return true;

  }

  // 2023-02-22 jj5 - this new version of the init function just inserts the interaction
  // record and not all the other stuff...
  //
  protected function wrapped_init_new( $raw, $db, $prefix ) {

    $microtime = $this->start_time;

    assert( $raw->is_raw() );

    $sql = "
      select
        a_std_interaction_id
      from
        {$prefix}t_abinitio_std_interaction
      where
        a_std_interaction_external_id = :external_id
    ";

    $stmt_select = $raw->prepare( $sql );

    $sql = "
      insert into {$prefix}t_abinitio_std_interaction (
        a_std_interaction_external_id,
        a_std_interaction_microtime
      )
      values (
        :external_id,
        :microtime
      )
    ";

    $stmt_insert = $raw->prepare( $sql );

    for ( $try = 1; $try < 100; $try++ ) {

      try {

        $external_id = mud_new_external_id();

        $stmt_insert->execute([
          ':external_id' => $external_id,
          ':microtime' => $microtime,
        ]);

      }
      catch ( PDOException $ex ) {

        $ignore_list = [
          'SQLSTATE[40001]: Serialization failure: 1213 Deadlock',
          'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate',
        ];

        $msg = $ex->getMessage();

        foreach ( $ignore_list as $ignore ) {

          if ( strpos( $msg, $ignore ) === 0 ) { continue 2; }

        }

        throw $ex;

      }

      $stmt_select->execute([
        ':external_id' => $external_id,
      ]);

      $result = $stmt_select->fetch();

      if ( $result ) {

        $this->interaction_id = $result[ A_STD_INTERACTION_ID ];
        $this->interaction_external_id = $external_id;

        return true;

      }
    }

    mud_fail( MUD_ERR_INTERACTION_INIT_FAILED, [ 'external_id' => $external_id, 'try' => $try ] );

  }

  protected function get_connection_id( $database ) {

    return $database->get_connection_id();

  }

  protected function get_schema_revision_id( $schema_name ) {

    return mud_raw()->get_a_std_schema_revision_id_latest_for_schema_name( $schema_name );

  }

  protected function is_live() {

    if ( $this->start_time === null ) { return false; }

    return $this->status_flags === MudProcessStatus::LIVE;

  }

  protected function require_live() {

    $this->require_status( MudProcessStatus::LIVE, 'interaction must be live.' );

  }

  protected function require_status( $status_flags, $note ) {

    mud_require(
      $this->status_flags === $status_flags,
      $note,
      [
        'status_flags' => $this->status_flags,
        'expected' => $status_flags,
      ]
    );

  }

  protected function close( $status_flags ) {

    $this->insert_done();

    $this->update_flags( $status_flags );

    $this->delete_live();

  }

  protected function insert_fail( $pclog_file ) {

    mud_raw()->add_row_t_detail_std_interaction_status_fail( $this->get_interaction_id(), $pclog_file );

  }

  protected function insert_done() {

    $duration = $this->get_microtime_now() - $this->start_time;

    assert( $duration >= 0.0 );

    mud_raw()->add_row_t_detail_std_interaction_status_done(
      $this->get_interaction_id(),
      $duration,
      MudGadget::$counter,
      gmdate( MUD_PDO_DATE_FORMAT )
    );

  }

  protected function update_flags( int $status_flags ) {

    mud_raw()->put_row_t_detail_std_interaction([
      A_STD_INTERACTION_ID => $this->get_interaction_id(),
      A_STD_INTERACTION_STATUS_FLAGS => $status_flags,
    ]);

    $this->status_flags = $status_flags;

  }

  protected function delete_live() {

    mud_raw()->del_row_t_detail_std_interaction_status_live( $this->get_interaction_id() );

  }
}
