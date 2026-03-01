<?php

trait mud_mudballdb_2021_08_30_090715_detail {


  // 2021-03-22 jj5 - NOTE: the interaction life-cycle goes like this:
  //* insert mud_interaction
  //* insert mud_interaction_status_live
  //* insert mud_interaction_status_fail (if failure)
  //* insert mud_interaction_status_done
  //* delete mud_interaction_status_live


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_detail_std_interaction_info
  //

  protected function define_t_detail_std_interaction_info() {

    def_tab( 't_detail_std_interaction_info' );

    def_key( 'a_std_interaction_info_id', DBT_ID );

    //def_ref( 'a_std_interaction_application_version_id', 't_about_std_application_version', 'a_std_application_version_id' );
    //def_ref( 'a_std_interaction_std_schema_revision_id', 't_about_std_schema_revision', 'a_std_schema_revision_id', [ SPEC_NULLABLE => true ] );
    //def_ref( 'a_std_interaction_app_schema_revision_id', 't_about_std_schema_revision', 'a_std_schema_revision_id', [ SPEC_NULLABLE => true ] );

    def_ref( 'a_std_interaction_info_server_id', 't_about_std_server', 'a_std_server_id' );

    def_ref( 'a_std_interaction_info_status_flags', 't_lookup_std_interaction_flags', 'a_std_interaction_flags', [ SPEC_DEFAULT => 0 ] );

    // 2021-03-30 jj5 - NEW:
    //
    //def_ref( 'a_std_interaction_process_status_enum', 't_lookup_std_process_status', 'a_std_process_status_enum', [ SPEC_DEFAULT => MudProcessStatus::LIVE ] );
    //
    // 2021-03-30 jj5 - OLD:
    //
    //s_ref( 'a_std_interaction_flags', 't_lookup_std_process_flags', 'a_std_process_flags', [ SPEC_DEFAULT => 1 ] );
    //s_flg( 'a_std_interaction_is_live', 't_lookup_std_process_flags', 'a_std_process_flags', FLAG_IS_PROCESS_LIVE );
    //s_flg( 'a_std_interaction_is_done', 't_lookup_std_process_flags', 'a_std_process_flags', FLAG_IS_PROCESS_DONE );
    //s_flg( 'a_std_interaction_is_fail', 't_lookup_std_process_flags', 'a_std_process_flags', FLAG_IS_PROCESS_FAIL );
    //
    // 2021-03-29 jj5 - OLD:
    //
    //s_col( 'a_is_interaction_status_live', DBT_BOOL, [ SPEC_DEFAULT => 1 ] );
    //s_col( 'a_is_interaction_status_fail', DBT_BOOL, [ SPEC_NULLABLE => true ] );
    //s_col( 'a_is_interaction_status_done', DBT_BOOL, [ SPEC_NULLABLE => true ] );

    def_col( 'a_std_interaction_info_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_info_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-28 jj5 - t_detail_std_interaction_schema
  //

  protected function define_t_detail_std_interaction_schema() {

    def_tab( 't_detail_std_interaction_schema' );

    def_key( 'a_std_interaction_schema_id', DBT_ID );

    def_ref( 'a_std_interaction_schema_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );

    def_ref( 'a_std_interaction_schema_schema_revision_id', 't_about_std_schema_revision', 'a_std_schema_revision_id' );

    def_col( 'a_std_interaction_schema_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_schema_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-28 jj5 - t_detail_std_interaction_software
  //

  protected function define_t_detail_std_interaction_software() {

    def_tab( 't_detail_std_interaction_software' );

    def_key( 'a_std_interaction_software_id', DBT_ID );

    def_ref( 'a_std_interaction_software_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );

    def_ref( 'a_std_interaction_software_software_version_id', 't_about_std_software_version', 'a_std_software_version_id' );

    def_col( 'a_std_interaction_software_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_software_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-28 jj5 - t_detail_std_interaction_connection
  //

  protected function define_t_detail_std_interaction_connection() {

    def_tab( 't_detail_std_interaction_connection' );

    def_key( 'a_std_interaction_connection_id', DBT_ID );

    def_ref( 'a_std_interaction_connection_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );

    def_ref( 'a_std_interaction_connection_connection_type_enum', 't_lookup_std_connection_type', 'a_std_connection_type_enum' );
    def_col( 'a_std_interaction_connection_connection_id', DBT_INT64 );

    def_col( 'a_std_interaction_connection_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_connection_updated_on', DBT_UPDATED_ON );

  }


  protected function define_t_detail_std_interaction_data() {

    def_tab( 't_detail_std_interaction_data' );

    def_rek( 'a_std_interaction_data_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );

    def_col( 'a_std_interaction_data_json', DBT_TEXT );
    def_col( 'a_std_interaction_data_stack', DBT_TEXT );

    def_col( 'a_std_interaction_data_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_data_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_detail_std_interaction_status_live
  //

  protected function define_t_detail_std_interaction_status_live() {

    def_tab( 't_detail_std_interaction_status_live' );

    def_rek( 'a_std_interaction_status_live_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_interaction_status_live_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_status_live_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_detail_std_interaction_status_done
  //

  protected function define_t_detail_std_interaction_status_done() {

    def_tab( 't_detail_std_interaction_status_done' );

    def_rek( 'a_std_interaction_status_done_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );

    def_col( 'a_std_interaction_status_done_duration', DBT_SINGLE );
    def_col( 'a_std_interaction_status_done_object_count', DBT_UINT32 );
    def_col( 'a_std_interaction_status_done_completed_on_utc', DBT_DATETIME_UTC );
    //s_col( 'a_std_interaction_status_done_completion_validation_count', DBT_UINT24 );

    def_col( 'a_std_interaction_status_done_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_status_done_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_detail_std_interaction_status_fail
  //

  protected function define_t_detail_std_interaction_status_fail() {

    def_tab( 't_detail_std_interaction_status_fail' );

    def_rek( 'a_std_interaction_status_fail_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_interaction_status_fail_pclog_file', DBT_ASCII_CI, [ SPEC_NULLABLE => true ] );
    def_col( 'a_std_interaction_status_fail_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_status_fail_updated_on', DBT_UPDATED_ON );

  }
}
