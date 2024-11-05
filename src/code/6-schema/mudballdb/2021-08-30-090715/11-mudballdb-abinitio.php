<?php

trait mud_mudballdb_2021_08_30_090715_abinitio {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2023-02-22 jj5 - t_abinitio_std_interaction
  //

  protected function define_t_abinitio_std_interaction() {

    def_tab( 't_abinitio_std_interaction' );

    def_key( 'a_std_interaction_id', DBT_ID );

    def_col( 'a_std_interaction_external_id', DBT_INT64 );
    def_col( 'a_std_interaction_microtime', DBT_DOUBLE );


    //def_ref( 'a_std_interaction_application_version_id', 't_about_std_application_version', 'a_std_application_version_id' );
    //def_ref( 'a_std_interaction_std_schema_revision_id', 't_about_std_schema_revision', 'a_std_schema_revision_id', [ SPEC_NULLABLE => true ] );
    //def_ref( 'a_std_interaction_app_schema_revision_id', 't_about_std_schema_revision', 'a_std_schema_revision_id', [ SPEC_NULLABLE => true ] );

    //def_ref( 'a_std_interaction_server_id', 't_about_std_server', 'a_std_server_id' );

    //def_ref( 'a_std_interaction_status_flags', 't_lookup_std_interaction_flags', 'a_std_interaction_flags', [ SPEC_DEFAULT => 0 ] );

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

    def_col( 'a_std_interaction_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_interaction_external_id' ], MUD_IDX_UNIQUE );

  }
}
