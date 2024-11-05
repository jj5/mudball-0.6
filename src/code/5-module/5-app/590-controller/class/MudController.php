<?php

class MudController extends MudService implements IMudController {


  //use MudDalHousekeeping;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-14 jj5 - private fields...
  //


  private $is_online = null;

  // 2020-03-24 jj5 - these flags control logging functionality. They are
  // managed in the t_about_mud_application_status table and are read during
  // initialization (if the database is online)...
  //
  private $is_logging_cache_usage = true;
  private $is_logging_database_access = true;
  private $is_logging_database_access_count = true;
  private $is_logging_database_operation_count = true;
  private $is_logging_database_transaction_count = true;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - public interface...
  //

  public function run() {

  }

  public function is_online() {

    if ( $this->is_online === null ) { $this->init(); }

    return $this->is_online;

  }

  public function get_application_code() {

    return app_interaction()->get_application_code();

  }

  public function get_application_version_id() {

    return app_interaction()->get_application_version_id();

  }

  public function get_server_id() {

    return app_interaction()->get_server_id();

  }

  public function get_interaction_id() {

    return app_interaction()->get_interaction_id();

  }

  public function log_validation_problem( $name, $value, $problem ) {

    // 2022-03-20 jj5 - TODO: log this.

    return false;

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - protected methods...
  //

  protected function init() {

    if ( $this->is_online !== null ) { return; }

    try {

      if ( ! mud_raw()->has_table( 't_config_std_application_status' ) ) {

        $this->is_online = false;

        return;

      }

      app_interaction()->init();

      $status = mud_raw()->get_row_t_config_std_application_status( APP_CODE );

      /*
      if ( ! $status ) {

        $this->is_online = false;

        return;

      }
      */

      if ( $status ) {

        $this->is_logging_cache_usage =
          boolval( $status[ A_STD_APPLICATION_STATUS_IS_LOGGING_CACHE_USAGE ] );

        $this->is_logging_database_access =
          boolval( $status[ A_STD_APPLICATION_STATUS_IS_LOGGING_DATABASE_ACCESS ] );

        $this->is_logging_database_access_count =
          boolval( $status[ A_STD_APPLICATION_STATUS_IS_LOGGING_DATABASE_ACCESS_COUNT ] );

        $this->is_logging_database_operation_count =
          boolval( $status[ A_STD_APPLICATION_STATUS_IS_LOGGING_DATABASE_OPERATION_COUNT ] );

        $this->is_logging_database_transaction_count =
          boolval( $status[ A_STD_APPLICATION_STATUS_IS_LOGGING_DATABASE_TRANSACTION_COUNT ] );

      }

      //$is_online = boolval( $status[ A_STD_APPLICATION_STATUS_IS_ONLINE ] );
      $is_online = true;

      $this->is_online = $is_online;

      /*
      if ( $is_online ) {

        register_shutdown_function( [ $this, 'handle_shutdown' ] );

      }
      */

    }
    catch ( Throwable $ex ) {

      $this->is_online = false;

      throw new_mud_http_exception(
        $http_status_code = 500,
        $http_status_message = 'Database is offline for maintenance.',
        $location = mud_url()->to_string(),
        $data = null,
        $previous = $ex,
      );

    }
  }

  protected function get_raw() { return mud_raw(); }

  protected function check_online() {

    if ( $this->is_online() ) { return; }

    mud_fail( MUD_ERR_DAL_DATABASE_IS_OFFLINE );

  }

}
