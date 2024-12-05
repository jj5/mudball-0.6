<?php

class MudDbadmin extends MudTool {

  public function __construct() {

    parent::__construct();

    if ( defined( 'ADMIN' ) && ADMIN ) { return; }

    mud_fail( MUD_ERR_DBADMIN_ADMIN_NOT_DEFINED );

  }

  public function reset( $argv ) {

    $this->check_env();

    $this->drop( $argv );
    $this->create( $argv );
    $this->upgrade( $argv );

    if ( DEV ) {

      $this->load_dev_data( $argv );

    }
  }

  public function load_dev_data( $argv ) {

    $trn = new MudDalTrn;
    $raw = new MudDalRaw;

    //$id = $raw->new_internal_id();

    /*
    for ( $i = 0; $i < 5; $i++ ) {

      $id = $raw->new_internal_id();

      var_dump( $id );

    }
    */

    if ( defined( 'APP_DEFAULT_PASSWORD_HASH' ) ) {

      $password_hash_id = $raw->add_row_t_particle_mud_password_hash( APP_DEFAULT_PASSWORD_HASH );

    }
    else {

      $password_hash_id = 1;

    }

    $history_crud_enum = MudCrud::CREATE;
    $id = $raw->new_internal_id();
    $email_address = 'jj5@progclub.org';
    $username = 'jj5';
    $flags = 0;
    $proper_name_id = 1;
    /*
    $created_on = date( MUD_PDO_DATE_FORMAT );
    $updated_on = date( MUD_PDO_DATE_FORMAT );
    */

    $trn->begin();

    $rowversion = $trn->add_row_t_history_mud_user( null, $history_crud_enum, $id, $email_address, $username, $password_hash_id, $flags, $proper_name_id );

    $trn->add_row_t_entity_mud_user( $id, $rowversion, $email_address, $username, $password_hash_id, $flags, $proper_name_id );

    $trn->commit();

  }

  public function reset_views( $argv ) {

    $this->check_env();

    $this->drop_views();
    $this->make_views();

  }

  public function drop( $argv ) {

    $this->check_env();

    $db_name = DB_NAME;

    if ( mud_is_prod() ) {

      for ( ;; ) {

        echo "Drop production database '$db_name'? [yN]: ";

        $replace = strtolower( trim( fgets( STDIN ) ) );

        if ( ! $replace ) { $replace = 'n'; }

        if ( $replace === 'n' ) { return false; }

        if ( $replace === 'y' ) { break; }

      }
    }

    $db = new MudDatabase( MUD_CONNECTION_TYPE_DBA, [ 'db_name' => 'mysql' ] );

    $sql = "drop database if exists $db_name";

    $db->exec( $sql );

  }

  public function create( $argv ) {

    $this->check_env();

    $db = new MudDatabase( MUD_CONNECTION_TYPE_DBA, [ 'db_name' => 'mysql' ] );

    $db_name = DB_NAME;

    $sql = "create database $db_name";

    $db->exec( $sql );

  }

  public function upgrade( $argv ) {

    $this->check_env();

    $curr = mud_load_schemadecl();

    if ( ! $curr ) { mud_fail( MUD_ERR_DBADMIN_MISSING_SCHEMADECL_SPEC ); }

    $db = new MudDatabase( MUD_CONNECTION_TYPE_DBA );
    $upgrader = new MudDatabaseUpgrader( $db );

    mud_raw( new MudDalRaw );

    $prefix = $db->get_prefix();

    $upgrade_table = "{$prefix}t_about_mud_schema_upgrade";
    $has_upgrade_table = $db->has_table( $upgrade_table );

    // 2022-02-20 jj5 - the SQL log is for the schema and schema revision table creation statements
    // which get processed before we have the schema upgrade table...
    //
    $sql_log = [];

    $this->drop_views();

    $current_revision_number = $this->get_latest_revision_number( $db );

    echo "current revision: $current_revision_number\n";

    do {

      $schema = $curr->get_schema();
      $revision_number = $curr->get_revision_number();
      $revision_code = $curr->get_revision();
      $type = $curr->get_type();
      $name = $curr->get_name();

      if ( $revision_number <= $current_revision_number ) { continue; }

      echo "$revision_number: $schema: $type: $name\n";

      if ( $has_upgrade_table ) {

        $schema_id = $this->register_schema( $db, $schema );
        $schema_revision_id = $this->register_schema_revision_id( $db, $schema, $revision_number, $revision_code );

      }

      $processed = $curr->apply_sql( $upgrader, $sql );

      echo "\n";

      if ( $sql === null ) {

        //assert( $processed === false );

      }
      else if ( $has_upgrade_table ) {

        $this->log_upgrade( $db, $schema, $revision_number, $sql );

      }
      else if ( $db->has_table( $upgrade_table ) ) {

        $schema_id = $this->register_schema( $db, $schema );
        $schema_revision_id = $this->register_schema_revision_id( $db, $schema, $revision_number, $revision_code );

        if ( count( $sql_log ) ) {

          assert ( count( $sql_log ) === 3 );

          $this->log_upgrade( $db, $schema, $revision_number, $sql_log[ 0 ] );
          $this->log_upgrade( $db, $schema, $revision_number, $sql_log[ 1 ] );
          $this->log_upgrade( $db, $schema, $revision_number, $sql_log[ 2 ] );
          $this->log_upgrade( $db, $schema, $revision_number, $sql );

        }

        $sql_log = [];

        $has_upgrade_table = true;

      }
      else {

        $sql_log[] = $sql;

      }
    }
    while ( $curr = $curr->next );

  }

  public function go_offline( $argv ) {

    mud_raw()->put_row_t_config_std_application_status([
      A_STD_APPLICATION_STATUS_SOFTWARE_NAME => APP_CODE,
      A_STD_APPLICATION_STATUS_IS_ONLINE => 0,
    ]);

  }

  public function go_online( $argv ) {

    mud_raw()->put_row_t_config_std_application_status( APP_CODE, $is_online = 1 );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - protected methods...
  //

  protected function check_env() {

    if ( ! defined( 'DB_NAME' ) ) {

      return $this->error( "database is not configured.\n", MUD_TOOL_EXIT_INVALID_CONFIG );

    }
  }

  protected function drop_views() {

    $db = new MudDatabase( MUD_CONNECTION_TYPE_DBA );

    $sql = "
      select
        *
      from
        information_schema.views
      where
        table_schema = :db_name
    ";

    $stmt = $db->prepare( $sql );

    $params = [ ':db_name' => DB_NAME ];

    $stmt->execute( $params );

    $table = $stmt->fetchAll();

    $stmt->closeCursor();

    foreach ( $table as $view_info ) {

      $view_name = $view_info[ 'table_name' ];

      $db->exec( "drop view `$view_name`" );

    }
  }

  protected function make_views() {

    $curr = mud_load_schemadecl();

    if ( ! $curr ) { mud_fail( MUD_ERR_DBADMIN_MISSING_SCHEMADECL_SPEC ); }

    $db = new MudDatabase( MUD_CONNECTION_TYPE_DBA );
    $upgrader = new MudDatabaseUpgrader( $db );

    do {

      if ( ! $curr->is_view() ) { continue; }

      $processed = $curr->apply_sql( $upgrader, $sql );

    }
    while ( $curr = $curr->next );

  }

  protected function register_schema( $db, $schema_name ) {

    static $stmt_get = null, $stmt_insert = null;

    if ( $stmt_get === null ) {

      $prefix = $db->get_prefix();

      $sql = "
        select
          count( a_std_schema_name ) as count
        from
          {$prefix}t_about_mud_schema
        where
          a_std_schema_name = :schema_name
      ";

      $stmt_get = $db->prepare( $sql );

    }

    $params = [ ':schema_name' => $schema_name ];

    $stmt_get->execute( $params );

    $table = $stmt_get->fetchAll();

    $stmt_get->closeCursor();

    $count = $table[ 0 ][ 'count' ] ?? null;

    if ( $count ) { return $schema_name; }

    if ( $stmt_insert === null ) {

      $prefix = $db->get_prefix();

      $sql = "
        insert into {$prefix}t_about_mud_schema
        (
           a_std_schema_name
        )
        values
        (
          :schema_name
        )
      ";

      $stmt_insert = $db->prepare( $sql );

    }

    $params = [
      ':schema_name' => $schema_name,
    ];

    $stmt_insert->execute( $params );

    //return intval( $db->lastInsertId() );

    return $schema_name;

  }

  protected function register_schema_revision_id( $db, $schema_name, $revision_number, $revision_code ) {

    static $stmt_get = null, $stmt_insert = null;

    if ( $stmt_get === null ) {

      $prefix = $db->get_prefix();

      $sql = "
        select
          a_std_schema_revision_id
        from
          {$prefix}t_about_mud_schema_revision
        where
          a_std_schema_revision_schema_name = :schema_name
        and
          a_std_schema_revision_revision_number = :revision_number
      ";

      $stmt_get = $db->prepare( $sql );

    }

    $params = [
      ':schema_name' => $schema_name,
      ':revision_number' => $revision_number,
    ];

    $stmt_get->execute( $params );

    $table = $stmt_get->fetchAll();

    $stmt_get->closeCursor();

    $schema_revision_id = $table[ 0 ][ 'a_std_schema_revision_id' ] ?? null;

    if ( $schema_revision_id ) { return $schema_revision_id; }

    if ( $stmt_insert === null ) {

      $prefix = $db->get_prefix();

      $sql = "
        insert into {$prefix}t_about_mud_schema_revision
        (
           a_std_schema_revision_schema_name,
           a_std_schema_revision_revision_number,
           a_std_schema_revision_revision_code
        )
        values
        (
          :schema_name,
          :revision_number,
          :revision_code
        )
      ";

      $stmt_insert = $db->prepare( $sql );

    }

    $params = [
      ':schema_name' => $schema_name,
      ':revision_number' => $revision_number,
      ':revision_code' => $revision_code,
    ];

    $stmt_insert->execute( $params );

    return intval( $db->lastInsertId() );

  }

  protected function get_latest_revision_number( $db ) {

    $prefix = $db->get_prefix();

    if ( ! $db->has_table( "{$prefix}t_about_mud_schema_revision" ) ) { return 0; }

    static $stmt_get = null;

    if ( $stmt_get === null ) {

      $sql = "
        select
          max( a_std_schema_revision_revision_number ) as revision_number
        from
          {$prefix}t_about_mud_schema_revision
      ";

      $stmt_get = $db->prepare( $sql );

    }

    $params = [];

    $stmt_get->execute( $params );

    $table = $stmt_get->fetchAll();

    return $table[ 0 ][ 'revision_number' ] ?? 0;

  }

  protected function log_upgrade( $db, $schema_name, $revision_number, $sql ) {

    static $step = 1;

    static $stmt_insert = null;

    if ( $stmt_insert === null ) {

      $prefix = $db->get_prefix();

      $sql_insert = "
        insert into {$prefix}t_about_mud_schema_upgrade
        (
           a_std_schema_upgrade_schema_name,
           a_std_schema_upgrade_revision_number,
           a_std_schema_upgrade_step,
           a_std_schema_upgrade_conducted_by,
           a_std_schema_upgrade_conducted_from,
           a_std_schema_upgrade_conducted_on,
           a_std_schema_upgrade_conducted_tz,
           a_std_schema_upgrade_sql
        )
        values
        (
          :schema_name,
          :revision_number,
          :step,
          :conducted_by,
          :conducted_from,
          :conducted_on,
          :conducted_tz,
          :sql
        )
      ";

      $stmt_insert = $db->prepare( $sql_insert );

    }

    $params = [
      ':schema_name' => $schema_name,
      ':revision_number' => $revision_number,
      ':step' => $step++,
      ':conducted_by' => trim( `whoami` ),
      ':conducted_from' => trim( `hostname` ),
      ':conducted_on' => date( MUD_SQL_DATE_FORMAT ),
      ':conducted_tz' => date_default_timezone_get(),
      ':sql' => $sql,
    ];

    $stmt_insert->execute( $params );

    return intval( $db->lastInsertId() );

  }
}
