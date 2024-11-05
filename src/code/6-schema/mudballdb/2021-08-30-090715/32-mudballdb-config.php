<?php

trait mud_mudballdb_2021_08_30_090715_config {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_config_std_application_status
  //

  protected function define_t_config_std_application_status() {

    def_tab( 't_config_std_application_status' );

    //def_key( 'a_std_application_status_id', DBT_ID8 );
    def_rek( 'a_std_application_status_software_code', 't_about_std_software', 'a_std_software_code' );
    def_col( 'a_std_application_status_is_online', DBT_BOOL, [ SPEC_DEFAULT => 0 ] );
    def_col( 'a_std_application_status_is_logging_cache_usage', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_application_status_is_logging_database_access', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_application_status_is_logging_database_access_count', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_application_status_is_logging_database_operation_count', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_application_status_is_logging_database_transaction_count', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    def_col( 'a_std_application_status_created_on', DBT_CREATED_ON );
    def_col( 'a_std_application_status_updated_on', DBT_UPDATED_ON );

    //def_idx( [ 'a_std_application_status_app_code' ], MUD_IDX_UNIQUE );

    def_dat( 't_config_std_application_status',
      [
        'a_std_application_status_software_code' => null,
        'a_std_application_status_is_online' => DEBUG ? 1 : 0,
      ], [
      [
        MUDBALL_CODE
      ],
    ]);

  }
}
