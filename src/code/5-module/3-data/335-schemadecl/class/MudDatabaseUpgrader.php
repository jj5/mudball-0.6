<?php

class MudDatabaseUpgrader extends MudGadget {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - protected fields...
  //

  protected $dba;

  protected $step = null;

  // 2021-03-27 jj5 - these are the upgrades we do before we have an upgrade table to log to...
  //
  protected $early_jobs = [];

  protected $check_for_upgrade_table = true;

  protected $software_id = null, $software_version_id = null, $server_id = null;

  protected $interaction_id = null, $start_time = null;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - constructor...
  //

  public function __construct( $dba ) {

    parent::__construct();

    //$this->schema_list = $schema_list;
    $this->dba = $dba;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance fields...
  //

  public function get_dba() { return $this->dba; }
  public function get_prefix() { return $this->dba->get_prefix(); }

  public function has_table( $tab_name ) {

    $prefix = $this->get_prefix();

    $table = "$prefix$tab_name";

    return $this->dba->has_table( $table );

  }

  public function begin() { return $this->get_dba()->begin(); }
  public function commit() { return $this->get_dba()->commit(); }

  /*
  public function upgrade() {

    foreach ( $this->schema_list as $schema ) {

      $schema->define();

    }

    foreach ( $this->schema_list as $schema ) {

      $latest_revision = $schema->get_revision();

      //var_dump( $latest_revision );

      for ( $revision = 10000; $revision <= $latest_revision; $revision++ ) {

        echo "applying revision $revision\n";

        $this->step = 1;

        $schema->apply( $revision, $this );

        $this->register_revision( $schema->get_name(), $revision );

      }
    }

    $this->complete_interaction();

  }
  */

  public function exec( $sql ) { return $this->get_dba()->exec( $sql ); }
  public function prepare( $sql ) { return $this->get_dba()->prepare( $sql ); }

  public function query( $sql, $params = [] ) {

    $stmt = $this->prepare( $sql );

    $stmt->execute( $params );

    return $stmt->fetchAll();

  }

  public function execute( $sql, $params = [] ) {

    $stmt = $this->prepare( $sql );

    $stmt->execute( $params );

  }

  /*
  public function exec( $schema, $revision, $sql ) {

    $schema_name = $schema->get_name();
    $step = $this->step++;

    $log = true;

    if ( $this->check_for_upgrade_table ) {

      if ( ! $this->has_upgrade_table() ) {

        $this->early_jobs[] = [
          'schema_name' => $schema_name,
          'revision' => $revision,
          'step' => $step,
          'sql' => $sql,
        ];

        $log = false;

      }
    }

    $this->log_item( "processing SQL for {$schema_name}[{$revision}][{$step}]..." );

    if ( $log ) {

      $this->initiate_upgrade(
        $schema_name,
        $revision,
        $step,
        $sql
      );

    }

    $this->dba->exec( $sql );

    if ( $log ) {

      $this->complete_upgrade(
        $schema_name,
        $revision,
        $step
      );

    }

  }

  public function prepare( $schema, $revision, $sql ) {

    $schema_name = $schema->get_name();
    $step = $this->step++;

    $log = true;

    if ( $this->check_for_upgrade_table ) {

      if ( ! $this->has_upgrade_table() ) {

        $this->early_jobs[] = [
          'schema_name' => $schema_name,
          'revision' => $revision,
          'step' => $step,
          'sql' => $sql,
        ];

        $log = false;

      }
    }

    if ( $log ) {

      $this->initiate_upgrade(
        $schema_name,
        $revision,
        $step,
        $sql
      );

    }

    return $this->dba->prepare( $sql );

  }

  public function finish( $schema, $revision, $sql ) {

    $schema_name = $schema->get_name();
    $step = $this->step;

    $this->complete_upgrade(
      $schema_name,
      $revision,
      $step
    );

  }
  */

  public function get_a_std_media_type_code( $media_type_enum ) {

    $prefix = $this->get_prefix();

    $sql = "
      select
        a_std_media_type_code
      from
        {$prefix}t_lookup_std_media_type
      where
        a_std_media_type_enum = :enum
    ";

    return $this->dba->get_string(
      $sql,
      [ ':enum' => $media_type_enum ],
      'a_std_media_type_code'
    );

  }

  public function get_interaction_id() {

    $interaction_id = mud_interaction()->get_interaction_id();

    if ( $interaction_id === null ) {

      mud_interaction()->reinit();

    }

    $interaction_id = mud_interaction()->get_interaction_id();

    return $interaction_id;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-27 jj5 - protected methods...
  //

  protected function get_software_code() {

    return defined( 'APP_CODE' ) ? APP_CODE : MUDBALL_CODE;

  }

  protected function get_software_version() {

    return defined( 'APP_CODE' ) ? APP_VERSION : MUDBALL_VERSION;

  }

  protected function get_software_id() {

    if ( $this->software_id ) { return $this->software_id; }

    //$this->dba->begin();

    $name = $this->get_software_code();

    $prefix = $this->get_prefix();

    $sql = "
      select
        a_std_software_id
      from
        {$prefix}t_about_mud_software
      where
        a_std_software_code = :name
    ";

    $params = [ ':name' => $name ];

    $stmt = $this->dba->prepare( $sql );

    $stmt->execute( $params );

    $row = $stmt->fetch();

    if ( $row ) {

      //$this->dba->commit();

      $this->software_id = $row[ 'a_std_software_id' ];

      return $this->software_id;

    }

    $sql = "
      insert into {$prefix}t_about_mud_software (
        a_std_software_code
      )
      values (
        :name
      )
    ";

    $software_id = $this->dba->run_insert_id( $sql, $params );

    //$this->dba->commit();

    $this->software_id = $software_id;

    return $this->software_id;

  }

  protected function get_software_version_id() {

    if ( $this->software_version_id ) { return $this->software_version_id; }

    //$this->dba->begin();

    $software_version = $this->get_software_version();

    $prefix = $this->get_prefix();

    $sql = "
      select
        a_std_software_version_id
      from
        {$prefix}t_about_mud_software_version
      where
        a_std_software_version_software_id = :software_id
      and
        a_std_software_version_version_number = :software_version
    ";

    $params = [
      ':software_id' => $this->get_software_id(),
      ':software_version' => $software_version,
    ];

    $stmt = $this->dba->prepare( $sql );

    $stmt->execute( $params );

    $row = $stmt->fetch();

    if ( $row ) {

      //$this->dba->commit();

      $this->software_version_id = $row[ 'a_std_software_version_id' ];

      return $this->software_version_id;

    }

    $sql = "
      insert into {$prefix}t_about_mud_software_version (
        a_std_software_version_software_id,
        a_std_software_version_version_number
      )
      values (
      :software_id,
      :software_version
      )
    ";

    $software_version_id = $this->dba->run_insert_id( $sql, $params );

    //$this->dba->commit();

    $this->software_version_id = $software_version_id;

    return $this->software_version_id;

  }

  protected function get_server_id() {

    if ( $this->server_id ) { return $this->server_id; }

    //$this->dba->begin();

    $hostname = gethostname();

    $prefix = $this->get_prefix();

    $sql = "
      select
        a_std_server_id
      from
        {$prefix}t_about_mud_server
      where
        a_std_server_hostname = :hostname
    ";

    $params = [ ':hostname' => $hostname ];

    $stmt = $this->dba->prepare( $sql );

    $stmt->execute( $params );

    $row = $stmt->fetch();

    if ( $row ) {

      //$this->dba->commit();

      $this->server_id = $row[ 'a_std_server_id' ];

      return $this->server_id;

    }

    $sql = "
      insert into {$prefix}t_about_mud_server (
        a_std_server_hostname
      )
      values (
        :hostname
      )
    ";

    $server_id = $this->dba->run_insert_id( $sql, $params );

    //$this->dba->commit();

    $this->server_id = $server_id;

    return $this->server_id;

  }

  protected function complete_interaction() {

    return;

    $interaction_id = $this->get_interaction_id();

    $prefix = $this->get_prefix();

    $duration = round( microtime( $as_float = true ) - $this->start_time, 3 );

    $sql = "
      insert into {$prefix}t_detail_mud_interaction_status_done (
        a_std_interaction_status_done_id,
        a_std_interaction_status_done_duration,
        a_std_interaction_status_done_completed_on_utc
      )
      values (
        :interaction_id,
        :duration,
        :completed_on_utc
      )
    ";

    $params = [
      ':interaction_id' => $interaction_id,
      ':duration' => $duration,
      ':completed_on_utc' => gmdate( MUD_PDO_DATE_FORMAT ),
    ];

    $this->dba->run_insert( $sql, $params );

    $sql = "
      delete from
        {$prefix}t_detail_mud_interaction_status_live
      where
         a_std_interaction_status_live_id = :interaction_id
    ";

    $this->dba->run_delete( $sql, [ ':interaction_id' => $interaction_id ] );

    $sql = "
      update
        {$prefix}t_detail_mud_interaction
      set
        a_std_interaction_status_flags        = :status,
        a_std_interaction_duration            = :duration,
        a_std_interaction_completed_on_utc    = :completed_on_utc
      where
         a_std_interaction_id = :interaction_id
    ";

    $this->dba->run_update(
      $sql,
      [
        ':interaction_id' => $interaction_id,
        ':status' => MudProcessStatus::DONE,
        ':duration' => $duration,
        ':completed_on_utc' => gmdate( MUD_SQL_DATE_FORMAT ),
      ]
    );

  }

  protected function initiate_upgrade( $schema_name, int $revision, int $step, $sql ) {

    if ( $this->check_for_upgrade_table ) {

      if ( ! $this->has_upgrade_table() ) { return; }

      $this->check_for_upgrade_table = false;

      foreach ( $this->early_jobs as $job ) {

        $this->initiate_upgrade(
          $job[ 'schema_name' ],
          $job[ 'revision' ],
          $job[ 'step' ],
          $job[ 'sql' ]
        );

        $this->complete_upgrade(
          $job[ 'schema_name' ],
          $job[ 'revision' ],
          $job[ 'step' ]
        );

      }
    }

    $prefix = $this->get_prefix();

    $insert_sql = "
      insert into {$prefix}t_about_mud_schema_upgrade (
        a_std_schema_upgrade_schema_name,
        a_std_schema_upgrade_revision,
        a_std_schema_upgrade_step,
        a_std_schema_upgrade_initiated_by,
        a_std_schema_upgrade_initiated_from,
        a_std_schema_upgrade_initiated_on,
        a_std_schema_upgrade_initiated_tz,
        a_std_schema_upgrade_sql
      )
      values(
        :a_std_schema_upgrade_schema_name,
        :a_std_schema_upgrade_revision,
        :a_std_schema_upgrade_step,
        :a_std_schema_upgrade_initiated_by,
        :a_std_schema_upgrade_initiated_from,
        :a_std_schema_upgrade_initiated_on,
        :a_std_schema_upgrade_initiated_tz,
        :a_std_schema_upgrade_sql
      )
    ";

    $this->dba->run_insert(
      $insert_sql,
      [
        ':a_std_schema_upgrade_schema_name' => $schema_name,
        ':a_std_schema_upgrade_revision' => $revision,
        ':a_std_schema_upgrade_step' => $step,
        ':a_std_schema_upgrade_initiated_by' => get_current_user(),
        ':a_std_schema_upgrade_initiated_from' => gethostname(),
        ':a_std_schema_upgrade_initiated_on' => date( MUD_SQL_DATE_FORMAT ),
        ':a_std_schema_upgrade_initiated_tz' => date_default_timezone_get(),
        ':a_std_schema_upgrade_sql' => $sql,
      ]
    );

  }

  protected function complete_upgrade( $schema_name, int $revision, int $step ) {

    if ( $this->check_for_upgrade_table ) {

      if ( ! $this->has_upgrade_table() ) { return; }

    }

    $prefix = $this->get_prefix();

    $sql = "
      update
        {$prefix}t_about_mud_schema_upgrade
      set
        a_std_schema_upgrade_completed_on = :a_std_schema_upgrade_completed_on,
        a_std_schema_upgrade_completed_tz = :a_std_schema_upgrade_completed_tz
      where
        a_std_schema_upgrade_schema_name = :a_std_schema_upgrade_schema_name
      and
        a_std_schema_upgrade_revision = :a_std_schema_upgrade_revision
      and
        a_std_schema_upgrade_step = :a_std_schema_upgrade_step
    ";

    $this->dba->run_update(
      $sql,
      [
        ':a_std_schema_upgrade_completed_on' => date( MUD_SQL_DATE_FORMAT ),
        ':a_std_schema_upgrade_completed_tz' => date_default_timezone_get(),
        ':a_std_schema_upgrade_schema_name' => $schema_name,
        ':a_std_schema_upgrade_revision' => $revision,
        ':a_std_schema_upgrade_step' => $step,
      ]
    );

  }

  protected function register_revision( $schema_name, int $revision ) {

    $prefix = $this->get_prefix();

    $insert_sql = "
      insert into {$prefix}t_about_mud_schema_revision (
        a_std_schema_revision_schema_name,
        a_std_schema_revision
      )
      values(
        :schema_name,
        :revision
      )
    ";

    $this->dba->run_insert(
      $insert_sql,
      [
        ':schema_name' => $schema_name,
        ':revision' => $revision,
      ]
    );

  }

  protected function has_upgrade_table() {

    return $this->dba->has_table( $this->get_prefix() . 't_about_mud_schema_upgrade' );

  }
}
