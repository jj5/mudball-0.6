<?php

trait mud_mudballdb_2021_08_30_090715_log {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-17 jj5 - t_log_std_email
  //

  protected function define_t_log_std_email() {

    def_tab( 't_log_std_email' );

    def_key( 'a_std_email_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_col( 'a_std_email_to', DBT_ASCII_CI );
    def_col( 'a_std_email_subject', DBT_TEXT );
    def_col( 'a_std_email_message', DBT_TEXT );
    def_col( 'a_std_email_headers', DBT_TEXT );
    def_col( 'a_std_email_created_on', DBT_CREATED_ON );
    def_col( 'a_std_email_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_web_auth
  //

  protected function define_t_log_std_web_auth() {

    def_tab( 't_log_std_web_auth' );

    def_key( 'a_std_web_auth_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_auth_event_enum', 't_lookup_std_auth_event' );
    def_ref( 'a_std_user_history_id', 't_history_std_user' );
    def_ref( 'a_std_username_id', 't_particle_std_username' );
    def_ref( 'a_std_ip_address_id', 't_particle_std_ip_address' );
    def_ref( 'a_std_http_user_agent_id', 't_piece_std_http_user_agent' );
    def_col( 'a_std_web_auth_created_on', DBT_CREATED_ON );
    def_col( 'a_std_web_auth_updated_on', DBT_UPDATED_ON );

    //s_idx( [ 'a_std_user_id', 'a_std_auth_event_enum' ], MUD_IDX_INDEX );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_cache_usage
  //

  protected function define_t_log_std_cache_usage() {

    def_tab( 't_log_std_cache_usage' );

    def_key( 'a_std_cache_usage_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_cache_name_id', 't_particle_std_cache_name' );
    def_ref( 'a_std_cache_type_id', 't_particle_std_cache_type' );
    def_col( 'a_std_cache_usage_hit_count', DBT_UINT24 );
    def_col( 'a_std_cache_usage_miss_count', DBT_UINT24 );
    // 2020-03-21 jj5 - we don't log write count because it should always
    // be the same as miss count...
    //s_col( 'a_std_cache_usage_write_count', DBT_UINT24 );
    def_col( 'a_std_cache_usage_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cache_usage_updated_on', DBT_UPDATED_ON );

    // 2020-09-15 jj5 - THINK: should this be unique..?
    //
    def_idx( [ 'a_std_interaction_id', 'a_std_cache_name_id', 'a_std_cache_type_id' ], MUD_IDX_INDEX );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_database_access
  //

  protected function define_t_log_std_database_access() {

    def_tab( 't_log_std_database_access' );

    def_key( 'a_std_database_access_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_connection_type_enum', 't_lookup_std_connection_type' );
    def_ref( 'a_std_database_operation_enum', 't_lookup_std_database_operation' );
    def_ref( 'a_std_table_name_id', 't_particle_std_table_name' );
    def_col( 'a_std_database_access_created_on', DBT_CREATED_ON );
    def_col( 'a_std_database_access_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_interaction_id', 'a_std_database_operation_enum', 'a_std_connection_type_enum' ], MUD_IDX_INDEX );
    def_idx( [ 'a_std_interaction_id', 'a_std_connection_type_enum', 'a_std_database_operation_enum' ], MUD_IDX_INDEX );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_database_access_count
  //

  protected function define_t_log_std_database_access_count() {

    def_tab( 't_log_std_database_access_count' );

    def_key( 'a_std_database_access_count_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_connection_type_enum', 't_lookup_std_connection_type' );
    def_ref( 'a_std_database_operation_enum', 't_lookup_std_database_operation' );
    def_col( 'a_std_database_access_count', DBT_UINT24 );
    def_ref( 'a_std_table_name_id', 't_particle_std_table_name' );
    def_col( 'a_std_database_access_count_created_on', DBT_CREATED_ON );
    def_col( 'a_std_database_access_count_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_interaction_id', 'a_std_connection_type_enum', 'a_std_database_operation_enum' ], MUD_IDX_INDEX );
    def_idx( [ 'a_std_interaction_id', 'a_std_database_operation_enum', 'a_std_connection_type_enum' ], MUD_IDX_INDEX );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_database_operation_count
  //

  protected function define_t_log_std_database_operation_count() {

    def_tab( 't_log_std_database_operation_count' );

    def_key( 'a_std_database_operation_count_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_connection_type_enum', 't_lookup_std_connection_type' );
    def_ref( 'a_std_database_operation_enum', 't_lookup_std_database_operation' );
    def_col( 'a_std_database_operation_count', DBT_UINT24 );
    def_col( 'a_std_database_operation_count_created_on', DBT_CREATED_ON );
    def_col( 'a_std_database_operation_count_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_database_transaction_count
  //

  protected function define_t_log_std_database_transaction_count() {

    def_tab( 't_log_std_database_transaction_count' );

    def_key( 'a_std_database_transaction_count_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_connection_type_enum', 't_lookup_std_connection_type' );
    def_col( 'a_std_database_transaction_count_begin_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_real_begin_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_commit_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_real_commit_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_rollback_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_real_rollback_count', DBT_UINT24 );
    def_col( 'a_std_database_transaction_count_created_on', DBT_CREATED_ON );
    def_col( 'a_std_database_transaction_count_updated_on', DBT_UPDATED_ON );

  }

  // 2021-03-22 jj5 - NOTE: these were remodelled as 'interaction' tables, see above.
  /*
  //
  // 2020-09-15 jj5 - t_log_std_interaction_completion
  //

  s_tab( 't_log_std_interaction_completion' );

  s_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
  s_col( 'a_std_interaction_completion_duration', DBT_SINGLE );
  s_col( 'a_std_interaction_completion_validation_count', DBT_UINT24 );
  //s_col( 'a_std_interaction_completion_completed_on', DBT_CREATED_ON );
  s_col( 'a_std_interaction_completion_created_on', DBT_CREATED_ON );
  s_col( 'a_std_interaction_completion_updated_on', DBT_UPDATED_ON );


  //
  // 2020-09-15 jj5 - t_log_std_interaction_failure
  //

  s_tab( 't_log_std_interaction_failure' );

  s_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
  s_col( 'a_std_interaction_failure_pclog_file', DBT_ASCII_CI );
  s_col( 'a_std_interaction_failure_created_on', DBT_CREATED_ON );
  s_col( 'a_std_interaction_failure_updated_on', DBT_UPDATED_ON );


  //
  // 2020-09-15 jj5 - t_log_std_missing_interaction
  //

  s_tab( 't_log_std_missing_interaction' );

  s_key( 'a_std_missing_interaction_id', DBT_ID );
  s_ref( 'a_std_table_name_id', 't_particle_std_table_name' );
  s_col( 'a_std_missing_interaction_log_data_jzon', DBT_BMOB );
  s_col( 'a_std_missing_interaction_created_on', DBT_CREATED_ON );
  s_col( 'a_std_missing_interaction_updated_on', DBT_UPDATED_ON );
  */


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_missing_token
  //

  protected function define_t_log_std_missing_token() {

    def_tab( 't_log_std_missing_token' );

    def_key( 'a_std_missing_token_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_token_type_enum', 't_lookup_std_token_type' );
    // 2020-03-11 jj5 - OLD: we don't use DBT_TOKEN as the input may be malformed
    //s_col( 'a_std_missing_token', DBT_TOKEN );
    // 2020-03-11 jj5 - NEW: we will accept any ASCII up to 255 characters...
    def_col( 'a_std_missing_token', DBT_ASCII_CI );
    // 2020-03-11 jj5 - END
    def_col( 'a_std_missing_token_created_on', DBT_CREATED_ON );
    def_col( 'a_std_missing_token_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_web_submission
  //

  protected function define_t_log_std_web_submission() {

    def_tab( 't_log_std_web_submission' );

    def_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_action_id', 't_particle_std_action' );
    def_ref( 'a_std_state_id', 't_piece_std_state' );
    def_col( 'a_std_web_submission_created_on', DBT_CREATED_ON );
    def_col( 'a_std_web_submission_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_cookie
  //

  protected function define_t_log_std_cookie() {

    def_tab( 't_log_std_cookie' );

    def_key( 'a_std_cookie_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_cookie_type_enum', 't_lookup_std_cookie_type' );
    def_ref( 'a_std_cookie_name_id', 't_particle_std_cookie_name' );
    def_ref( 'a_std_cookie_value_id', 't_particle_std_cookie_value' );
    def_ref( 'a_std_expiry_id', 't_particle_std_expiry' );
    def_ref( 'a_std_cookie_path_id', 't_piece_std_url_path', 'a_std_url_path_id' );
    def_ref( 'a_std_cookie_domain_id', 't_particle_std_hostname', 'a_std_hostname_id' );

    def_ref( 'a_std_cookie_flags', 't_lookup_std_cookie_flags' );
    def_flg( 'a_std_cookie_is_secure', 't_lookup_std_cookie_flags', 'a_std_cookie_flags', FLAG_IS_COOKIE_SECURE );
    def_flg( 'a_std_cookie_is_http_only', 't_lookup_std_cookie_flags', 'a_std_cookie_flags', FLAG_IS_COOKIE_HTTP_ONLY );

    def_col( 'a_std_cookie_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cookie_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_facility_access
  //

  protected function define_t_log_std_facility_access() {

    def_tab( 't_log_std_facility_access' );

    def_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_facility_type_enum', 't_lookup_std_facility_type' );
    def_ref( 'a_std_facility_id', 't_particle_std_facility' );
    //def_ref( 'a_std_facility_mode_id', 't_particle_std_facility_mode' );
    //def_ref( 'a_std_facility_path_id', 't_particle_std_facility_path' );
    def_col( 'a_std_facility_access_created_on', DBT_CREATED_ON );
    def_col( 'a_std_facility_access_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-03-10 jj5 - t_log_std_input_error
  //

  protected function define_t_log_std_input_error() {

    def_tab( 't_log_std_input_error' );

    def_key( 'a_std_input_error_id', DBT_ID );
    def_ref( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_input_field_id', 't_particle_std_input_field' );
    def_ref( 'a_std_input_problem_id', 't_particle_std_input_problem' );
    def_col( 'a_std_input_error_created_on', DBT_CREATED_ON );
    def_col( 'a_std_input_error_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_interaction_id' ], MUD_IDX_INDEX );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-03-10 jj5 - t_log_std_web_request
  //

  protected function define_t_log_std_web_request() {

    def_tab( 't_log_std_web_request' );

    def_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_ref( 'a_std_browser_history_id', 't_history_std_browser' );
    def_ref( 'a_std_session_history_id', 't_history_std_session' );
    def_ref( 'a_std_user_history_id', 't_history_std_user' );
    def_ref( 'a_std_username_id', 't_particle_std_username' );
    def_ref( 'a_std_url_id', 't_piece_std_url' );
    def_ref( 'a_std_web_request_http_referrer_id', 't_piece_std_url', 'a_std_url_id' );
    def_rev( 'a_std_web_request_http_referrer', 't_piece_std_url', 'a_std_url' );
    def_ref( 'a_std_http_verb_enum', 't_lookup_std_http_verb' );
    def_ref( 'a_std_http_accept_id', 't_piece_std_http_accept' );
    def_ref( 'a_std_http_accept_encoding_id', 't_piece_std_http_accept_encoding' );
    def_ref( 'a_std_http_accept_language_id', 't_piece_std_http_accept_language' );
    def_ref( 'a_std_http_user_agent_id', 't_piece_std_http_user_agent' );
    def_ref( 'a_std_ip_address_id', 't_particle_std_ip_address' );
    def_col( 'a_std_web_request_created_on', DBT_CREATED_ON );
    def_col( 'a_std_web_request_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_log_std_web_response
  //

  protected function define_t_log_std_web_response() {

    def_tab( 't_log_std_web_response' );

    def_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );
    def_col( 'a_std_http_response_code', DBT_UINT16 );

    def_ref( 'a_std_web_response_flags', 't_lookup_std_web_response_flags' );
    def_flg( 'a_std_web_response_is_connection_abort', 't_lookup_std_web_response_flags', 'a_std_web_response_flags', FLAG_IS_WEB_RESPONSE_CONNECTION_ABORT );
    def_flg( 'a_std_web_response_is_connection_timeout', 't_lookup_std_web_response_flags', 'a_std_web_response_flags', FLAG_IS_WEB_RESPONSE_CONNECTION_TIMEOUT );

    def_ref( 'a_std_content_type_id', 't_particle_std_content_type' );
    def_ref( 'a_std_http_powered_by_id', 't_particle_std_http_powered_by' );
    //def_ref( 'a_std_http_headers_id', 't_piece_std_http_headers' );
    def_col( 'a_std_http_response_headers_jzon', DBT_BMOB );
    def_col( 'a_std_web_response_created_on', DBT_CREATED_ON );
    def_col( 'a_std_web_response_updated_on', DBT_UPDATED_ON );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_log_std_validation_problem
  //

  protected function define_t_log_std_validation_problem() {

    def_tab( 't_log_std_validation_problem' );

    def_rek( 'a_std_interaction_id', 't_abinitio_std_interaction' );

    def_ref( 'a_std_validation_scope_id', 't_particle_std_validation_scope' );
    def_ref( 'a_std_validation_value_id', 't_piece_std_validation_value' );
    def_ref( 'a_std_validation_issue_id', 't_particle_std_validation_issue' );

    def_col( 'a_std_validation_problem_created_on', DBT_CREATED_ON );
    def_col( 'a_std_validation_problem_updated_on', DBT_UPDATED_ON );

  }

  // 2021-03-22 jj5 - THINK: do we want specific web response tables for specific http
  // response codes? e.g. t_log_std_web_response_404, etc.

}
