<?php

trait mud_mudballdb_2021_08_30_090715_entity {

  // 2020-03-09 jj5 - TODO: t_entity_geo_ip_location and t_history_geo_ip_location etc


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_entity_std_user
  //

  protected function define_t_entity_std_user() {

    def_tab( 't_history_std_user' );

    def_key( 'a_std_user_history_id', DBT_ID );


    //
    // 2020-09-15 jj5 - t_entity_std_user
    //

    // 2019-10-16 jj5 - NOTE: if you need extra data for a user account
    // create a app_user_info table in the app database module

    def_tab( 't_entity_std_user' );

    //s_key( 'a_std_user_id', DBT_ID );
    def_rek( 'a_std_user_id', 't_ident_std_internal_id', 'a_std_internal_id' );

    def_ref( 'a_std_user_rowversion', 't_history_std_user', 'a_std_user_history_id' );

    //s_ref( 'a_std_user_email_address_id', 't_piece_std_email_address', 'a_std_email_address_id' );
    //s_rev( 'a_std_user_email_address', 't_piece_std_email_address', 'a_std_email_address' );
    def_ref( 'a_std_user_email_address', 't_particle_std_email_address', 'a_std_email_address_ci' );

    //s_ref( 'a_std_user_username_id', 't_particle_std_username', 'a_std_username_id' );
    //s_rev( 'a_std_user_username', 't_particle_std_username', 'a_std_username' );
    def_ref( 'a_std_user_username', 't_particle_std_username', 'a_std_username_ci' );

    def_ref( 'a_std_user_password_hash_id', 't_particle_std_password_hash', 'a_std_password_hash_id' );
    def_rev( 'a_std_user_password_hash', 't_particle_std_password_hash', 'a_std_password_hash' );

    def_ref( 'a_std_user_flags', 't_lookup_std_user_flags', 'a_std_user_flags' );
    def_flg( 'a_std_user_is_active', 't_lookup_std_user_flags', 'a_std_user_flags', FLAG_IS_USER_ACTIVE );
    def_flg( 'a_std_user_is_email_verified', 't_lookup_std_user_flags', 'a_std_user_flags', FLAG_IS_USER_EMAIL_VERIFIED );
    def_flg( 'a_std_user_is_username_verified', 't_lookup_std_user_flags', 'a_std_user_flags', FLAG_IS_USER_USERNAME_VERIFIED );

    def_ref( 'a_std_user_proper_name_id', 't_particle_std_proper_name', 'a_std_proper_name_id' );
    def_rev( 'a_std_user_proper_name', 't_particle_std_proper_name', 'a_std_proper_name' );

    //def_ref( 'a_std_user_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_user_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_user_created_on', DBT_CREATED_ON );
    def_col( 'a_std_user_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_user_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_user_email_address' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_user_username' ], MUD_IDX_UNIQUE );

    //
    // 2020-09-15 jj5 - t_history_std_user
    //

    //def_tab( 't_history_std_user' );
    //def_key( 'a_std_user_history_id', DBT_ID );

    mod_tab( 't_history_std_user' );

    def_ref( 'a_std_user_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_user_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_user_id', 't_entity_std_user' );
    def_ref( 'a_std_user_email_address', 't_entity_std_user' );
    def_ref( 'a_std_user_username', 't_entity_std_user' );
    def_ref( 'a_std_user_password_hash_id', 't_entity_std_user' );
    def_ref( 'a_std_user_flags', 't_entity_std_user' );
    def_ref( 'a_std_user_proper_name_id', 't_entity_std_user' );
    //def_ref( 'a_std_user_created_in', 't_entity_std_user' );
    //def_ref( 'a_std_user_updated_in', 't_entity_std_user' );
    def_ref( 'a_std_user_created_on', 't_entity_std_user' );
    def_ref( 'a_std_user_updated_on', 't_entity_std_user' );

    def_idx( [ 'a_std_user_id', 'a_std_user_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - t_entity_std_user_credential_reset
  //

  protected function define_t_entity_std_user_credential_reset() {

    def_tab( 't_history_std_user_credential_reset' );

    def_key( 'a_std_user_credential_reset_history_id', DBT_ID );


    //
    // 2022-03-20 jj5 - t_entity_std_user_credential_reset
    //

    def_tab( 't_entity_std_user_credential_reset' );

    def_rek( 'a_std_user_credential_reset_id', 't_ident_std_internal_id', 'a_std_internal_id' );

    def_ref( 'a_std_user_credential_reset_rowversion', 't_history_std_user_credential_reset', 'a_std_user_credential_reset_history_id' );

    def_ref( 'a_std_user_credential_reset_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_user_credential_reset_token_id', 't_particle_std_token', 'a_std_token_id' );

    def_col( 'a_std_user_credential_reset_created_on', DBT_CREATED_ON );
    def_col( 'a_std_user_credential_reset_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_user_credential_reset_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_user_credential_reset_token_id' ], MUD_IDX_UNIQUE );


    //
    // 2022-03-20 jj5 - t_history_std_user_credential_reset
    //

    mod_tab( 't_history_std_user_credential_reset' );

    def_ref( 'a_std_user_credential_reset_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_user_credential_reset_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_user_credential_reset_id', 't_entity_std_user_credential_reset' );
    def_ref( 'a_std_user_credential_reset_user_id', 't_entity_std_user_credential_reset' );
    def_ref( 'a_std_user_credential_reset_token_id', 't_entity_std_user_credential_reset' );
    def_ref( 'a_std_user_credential_reset_created_on', 't_entity_std_user_credential_reset' );
    def_ref( 'a_std_user_credential_reset_updated_on', 't_entity_std_user_credential_reset' );

    def_idx( [ 'a_std_user_credential_reset_id', 'a_std_user_credential_reset_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_entity_std_user_role
  //

  protected function define_t_entity_std_user_role() {

    def_tab( 't_history_std_user_role' );

    def_key( 'a_std_user_role_history_id', DBT_ID );

    //
    // 2020-09-15 jj5 - t_entity_std_user_role
    //

    def_tab( 't_entity_std_user_role' );

    def_rek( 'a_std_user_role_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_user_role_rowversion', 't_history_std_user_role', 'a_std_user_role_history_id' );
    def_ref( 'a_std_user_role_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_user_role_role_enum', 't_lookup_std_role', 'a_std_role_enum' );
    def_ref( 'a_std_user_role_membership_status_enum', 't_lookup_std_membership_status', 'a_std_membership_status_enum', [ SPEC_DEFAULT => MudMembershipStatus::UNSET ] );
    //def_ref( 'a_std_user_role_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_user_role_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_user_role_created_on', DBT_CREATED_ON );
    def_col( 'a_std_user_role_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_user_role_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_user_role_user_id', 'a_std_user_role_role_enum' ], MUD_IDX_UNIQUE );

    //
    // 2020-09-15 jj5 - t_history_std_user_role
    //

    mod_tab( 't_history_std_user_role' );

    //def_key( 'a_std_user_role_history_id', DBT_ID );
    def_ref( 'a_std_user_role_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_user_role_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_user_role_id', 't_entity_std_user_role' );
    def_ref( 'a_std_user_role_user_id', 't_entity_std_user_role' );
    def_ref( 'a_std_user_role_role_enum', 't_entity_std_user_role' );
    def_ref( 'a_std_user_role_membership_status_enum', 't_entity_std_user_role' );
    //def_ref( 'a_std_user_role_created_in', 't_entity_std_user_role' );
    //def_ref( 'a_std_user_role_updated_in', 't_entity_std_user_role' );
    def_ref( 'a_std_user_role_created_on', 't_entity_std_user_role' );
    def_ref( 'a_std_user_role_updated_on', 't_entity_std_user_role' );

    def_idx( [ 'a_std_user_role_id', 'a_std_user_role_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_entity_std_ticket
  //

  protected function define_t_entity_std_ticket() {

    def_tab( 't_history_std_ticket' );

    def_key( 'a_std_ticket_history_id', DBT_ID );

    //
    // 2020-09-15 jj5 - t_entity_std_ticket
    //

    def_tab( 't_entity_std_ticket' );

    def_rek( 'a_std_ticket_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_ticket_rowversion', 't_history_std_ticket', 'a_std_ticket_history_id' );
    def_ref( 'a_std_ticket_token_id', 't_particle_std_token', 'a_std_token_id' );
    def_ref( 'a_std_ticket_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_ticket_token_type_enum', 't_lookup_std_token_type', 'a_std_token_type_enum' );
    def_ref( 'a_std_ticket_token_status_enum', 't_lookup_std_token_status', 'a_std_token_status_enum' );
    def_ref( 'a_std_ticket_expiry_id', 't_particle_std_expiry', 'a_std_expiry_id' );
    def_ref( 'a_std_ticket_previous_ticket_id', 't_entity_std_ticket', 'a_std_ticket_id', [ SPEC_DEFAULT => 0 ] );
    //def_ref( 'a_std_ticket_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_ticket_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_ticket_created_on', DBT_CREATED_ON );
    def_col( 'a_std_ticket_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_ticket_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_ticket_token_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-09-15 jj5 - t_history_std_ticket
    //

    mod_tab( 't_history_std_ticket' );

    //def_key( 'a_std_ticket_history_id', DBT_ID );
    def_ref( 'a_std_ticket_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_ticket_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_ticket_id', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_token_id', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_user_id', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_token_type_enum', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_token_status_enum', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_expiry_id', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_previous_ticket_id', 't_entity_std_ticket' );
    //def_ref( 'a_std_ticket_created_in', 't_entity_std_ticket' );
    //def_ref( 'a_std_ticket_updated_in', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_created_on', 't_entity_std_ticket' );
    def_ref( 'a_std_ticket_updated_on', 't_entity_std_ticket' );

    def_idx( [ 'a_std_ticket_id', 'a_std_ticket_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_entity_std_browser
  //

  protected function define_t_entity_std_browser() {

    def_tab( 't_history_std_browser' );

    def_key( 'a_std_browser_history_id', DBT_ID );

    //
    // 2021-03-22 jj5 - t_entity_std_browser
    //

    def_tab( 't_entity_std_browser' );

    def_rek( 'a_std_browser_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_browser_rowversion', 't_history_std_browser', 'a_std_browser_history_id' );
    def_ref( 'a_std_browser_http_user_agent_id', 't_piece_std_http_user_agent', 'a_std_http_user_agent_id' );
    def_ref( 'a_std_browser_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_browser_ticket_id', 't_entity_std_ticket', 'a_std_ticket_id' );
    def_col( 'a_std_browser_seed', DBT_INT32 );
    def_ref( 'a_std_browser_flags', 't_lookup_std_browser_flags', 'a_std_browser_flags' );
    def_flg( 'a_std_browser_is_verified', 't_lookup_std_browser_flags', 'a_std_browser_flags', FLAG_IS_BROWSER_VERIFIED );
    def_flg( 'a_std_browser_is_spammer', 't_lookup_std_browser_flags', 'a_std_browser_flags', FLAG_IS_BROWSER_SPAMMER );
    def_ref( 'a_std_browser_email_address_id', 't_particle_std_email_address', 'a_std_email_address_id', [ SPEC_DEFAULT => 1 ] );
    //def_ref( 'a_std_browser_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_browser_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_browser_created_on', DBT_CREATED_ON );
    def_col( 'a_std_browser_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_browser_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_browser_ticket_id' ], MUD_IDX_UNIQUE );

    //
    // 2021-03-22 jj5 - t_history_std_browser
    //

    mod_tab( 't_history_std_browser' );

    //def_key( 'a_std_browser_history_id', DBT_ID );
    def_ref( 'a_std_browser_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_browser_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_browser_id', 't_entity_std_browser' );
    def_ref( 'a_std_browser_http_user_agent_id', 't_entity_std_browser' );
    def_ref( 'a_std_browser_user_id', 't_entity_std_browser' );
    def_ref( 'a_std_browser_ticket_id', 't_entity_std_browser' );
    def_ref( 'a_std_browser_seed', 't_entity_std_browser' );
    def_ref( 'a_std_browser_flags', 't_entity_std_browser' );
    def_ref( 'a_std_browser_email_address_id', 't_entity_std_browser' );
    //def_ref( 'a_std_browser_created_in', 't_entity_std_browser' );
    //def_ref( 'a_std_browser_updated_in', 't_entity_std_browser' );
    def_ref( 'a_std_browser_created_on', 't_entity_std_browser' );
    def_ref( 'a_std_browser_updated_on', 't_entity_std_browser' );

    def_idx( [ 'a_std_browser_id', 'a_std_browser_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_entity_std_session
  //

  protected function define_t_entity_std_session() {

    def_tab( 't_history_std_session' );

    def_key( 'a_std_session_history_id', DBT_ID );

    //
    // 2021-03-22 jj5 - t_entity_std_session
    //

    def_tab( 't_entity_std_session' );

    def_rek( 'a_std_session_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_session_rowversion', 't_history_std_session', 'a_std_session_history_id' );
    def_ref( 'a_std_session_browser_id', 't_entity_std_browser', 'a_std_browser_id' );
    def_ref( 'a_std_session_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_session_ticket_id', 't_entity_std_ticket', 'a_std_ticket_id' );
    def_ref( 'a_std_session_flags', 't_lookup_std_session_flags', 'a_std_session_flags' );
    def_flg( 'a_std_session_is_verified', 't_lookup_std_session_flags', 'a_std_session_flags', FLAG_IS_SESSION_VERIFIED );
    def_flg( 'a_std_session_is_spammer', 't_lookup_std_session_flags', 'a_std_session_flags', FLAG_IS_SESSION_SPAMMER );
    def_ref( 'a_std_session_xsrf_prev_ticket_id', 't_entity_std_ticket', 'a_std_ticket_id' );
    def_ref( 'a_std_session_xsrf_curr_ticket_id', 't_entity_std_ticket', 'a_std_ticket_id' );
    def_ref( 'a_std_session_email_address_id', 't_particle_std_email_address', 'a_std_email_address_id', [ SPEC_DEFAULT => 1 ] );
    //def_ref( 'a_std_session_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_session_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_session_created_on', DBT_CREATED_ON );
    def_col( 'a_std_session_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_session_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_session_ticket_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-09-15 jj5 - t_history_std_session
    //

    mod_tab( 't_history_std_session' );

    //def_key( 'a_std_session_history_id', DBT_ID );
    def_ref( 'a_std_session_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_session_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_session_id', 't_entity_std_session' );
    def_ref( 'a_std_session_browser_id', 't_entity_std_session' );
    def_ref( 'a_std_session_user_id', 't_entity_std_session' );
    def_ref( 'a_std_session_ticket_id', 't_entity_std_session' );
    def_ref( 'a_std_session_flags', 't_entity_std_session' );
    def_ref( 'a_std_session_xsrf_prev_ticket_id', 't_entity_std_session' );
    def_ref( 'a_std_session_xsrf_curr_ticket_id', 't_entity_std_session' );
    def_ref( 'a_std_session_email_address_id', 't_entity_std_session' );
    //def_ref( 'a_std_session_created_in', 't_entity_std_session' );
    //def_ref( 'a_std_session_updated_in', 't_entity_std_session' );
    def_ref( 'a_std_session_created_on', 't_entity_std_session' );
    def_ref( 'a_std_session_updated_on', 't_entity_std_session' );

    def_idx( [ 'a_std_session_id', 'a_std_session_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-25 jj5 - t_entity_std_prefspec
  //

  protected function define_t_entity_std_prefspec() {

    def_tab( 't_history_std_prefspec' );

    def_key( 'a_std_prefspec_history_id', DBT_ID );

    //
    // 2020-10-25 jj5 - t_entity_std_prefspec
    //

    def_tab( 't_entity_std_prefspec' );

    def_rek( 'a_std_prefspec_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_prefspec_rowversion', 't_history_std_prefspec', 'a_std_prefspec_history_id' );
    def_ref( 'a_std_prefspec_prefname_id', 't_particle_std_prefname', 'a_std_prefname_id' );
    def_ref( 'a_std_prefspec_default_jsonval_id', 't_piece_std_jsonval', 'a_std_jsonval_id' );

    def_ref( 'a_std_prefspec_flags', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags' );
    def_flg( 'a_std_prefspec_is_null_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_NULL_ALLOWED );
    def_flg( 'a_std_prefspec_is_bool_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_BOOL_ALLOWED );
    def_flg( 'a_std_prefspec_is_int_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_INT_ALLOWED );
    def_flg( 'a_std_prefspec_is_float_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_FLOAT_ALLOWED );
    def_flg( 'a_std_prefspec_is_string_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_STRING_ALLOWED );
    def_flg( 'a_std_prefspec_is_other_allowed', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags', FLAG_IS_PREF_OTHER_ALLOWED );

    //def_ref( 'a_std_prefspec_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_prefspec_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_prefspec_created_on', DBT_CREATED_ON );
    def_col( 'a_std_prefspec_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_prefspec_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_prefspec_prefname_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-10-25 jj5 - t_history_std_prefspec
    //

    mod_tab( 't_history_std_prefspec' );

    //def_key( 'a_std_prefspec_history_id', DBT_ID );
    def_ref( 'a_std_prefspec_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_prefspec_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_prefspec_id', 't_entity_std_prefspec' );
    def_ref( 'a_std_prefspec_prefname_id', 't_entity_std_prefspec' );
    def_ref( 'a_std_prefspec_default_jsonval_id', 't_entity_std_prefspec' );
    def_ref( 'a_std_prefspec_flags', 't_entity_std_prefspec' );
    //def_ref( 'a_std_prefspec_created_in', 't_entity_std_prefspec' );
    //def_ref( 'a_std_prefspec_updated_in', 't_entity_std_prefspec' );
    def_ref( 'a_std_prefspec_created_on', 't_entity_std_prefspec' );
    def_ref( 'a_std_prefspec_updated_on', 't_entity_std_prefspec' );

    def_idx( [ 'a_std_prefspec_id', 'a_std_prefspec_history_id' ], MUD_IDX_UNIQUE );

  }

  /*
  //
  // 2020-10-25 jj5 - t_lookup_std_prefspec
  //

  s_tab( 't_lookup_std_prefspec' );

  s_rek( 'a_std_prefspec_prefname_id', 't_particle_std_prefname', 'a_std_prefname_id' );
  s_ref( 'a_std_prefspec_default_jsonval', 't_piece_std_jsonval', 'a_std_jsonval_id' );

  s_ref( 'a_std_prefspec_flags', 't_lookup_std_prefspec_flags', 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_null_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_NULL_ALLOWED, 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_bool_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_BOOL_ALLOWED, 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_int_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_INT_ALLOWED, 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_float_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_FLOAT_ALLOWED, 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_string_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_STRING_ALLOWED, 'a_std_prefspec_flags' );
  s_flg( 'a_is_cfg_pref_other_allowed', 't_lookup_std_prefspec_flags', FLAG_IS_PREF_OTHER_ALLOWED, 'a_std_prefspec_flags' );

  s_col( 'a_std_prefspec_created_on', DBT_CREATED_ON );
  s_col( 'a_std_prefspec_updated_on', DBT_UPDATED_ON );
  */

  /*
  s_dat( 't_lookup_std_prefspec',
    [
      'a_std_prefspec_prefname' => null,
      'a_std_prefspec_default_jsonval' => null,
      'a_std_prefspec_flags' => null,
    ], [
    [ 'std.example.whatever', 'false', FLAG_IS_PREF_BOOL_ALLOWED ],
  ]);
  */


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-25 jj5 - t_entity_std_pref_session
  //

  protected function define_t_entity_std_pref_session() {

    def_tab( 't_history_std_pref_session' );

    def_key( 'a_std_pref_session_history_id', DBT_ID );

    //
    // 2020-10-25 jj5 - t_entity_std_pref_session
    //

    def_tab( 't_entity_std_pref_session' );

    def_rek( 'a_std_pref_session_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_pref_session_rowversion', 't_history_std_pref_session', 'a_std_pref_session_history_id' );
    def_ref( 'a_std_pref_session_session_id', 't_entity_std_session', 'a_std_session_id' );
    def_ref( 'a_std_pref_session_prefname_id', 't_particle_std_prefname', 'a_std_prefname_id' );
    def_ref( 'a_std_pref_session_jsonval_id', 't_piece_std_jsonval', 'a_std_jsonval_id' );
    //def_ref( 'a_std_pref_session_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_pref_session_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_pref_session_created_on', DBT_CREATED_ON );
    def_col( 'a_std_pref_session_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_pref_session_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_pref_session_session_id', 'a_std_pref_session_prefname_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-10-25 jj5 - t_history_std_pref_session
    //

    mod_tab( 't_history_std_pref_session' );

    //def_key( 'a_std_pref_session_history_id', DBT_ID );
    def_ref( 'a_std_pref_session_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_pref_session_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_pref_session_id', 't_entity_std_pref_session' );
    def_ref( 'a_std_pref_session_session_id', 't_entity_std_pref_session' );
    def_ref( 'a_std_pref_session_prefname_id', 't_entity_std_pref_session' );
    def_ref( 'a_std_pref_session_jsonval_id', 't_entity_std_pref_session' );
    //def_ref( 'a_std_pref_session_created_in', 't_entity_std_pref_session' );
    //def_ref( 'a_std_pref_session_updated_in', 't_entity_std_pref_session' );
    def_ref( 'a_std_pref_session_created_on', 't_entity_std_pref_session' );
    def_ref( 'a_std_pref_session_updated_on', 't_entity_std_pref_session' );

    def_idx( [ 'a_std_pref_session_id', 'a_std_pref_session_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-25 jj5 - t_entity_std_pref_user
  //

  protected function define_t_entity_std_pref_user() {

    def_tab( 't_history_std_pref_user' );

    def_key( 'a_std_pref_user_history_id', DBT_ID );

    //
    // 2020-10-25 jj5 - t_entity_std_pref_user
    //

    def_tab( 't_entity_std_pref_user' );

    def_rek( 'a_std_pref_user_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_pref_user_rowversion', 't_history_std_pref_user', 'a_std_pref_user_history_id' );
    def_ref( 'a_std_pref_user_user_id', 't_entity_std_user', 'a_std_user_id' );
    def_ref( 'a_std_pref_user_prefname_id', 't_particle_std_prefname', 'a_std_prefname_id' );
    def_ref( 'a_std_pref_user_jsonval_id', 't_piece_std_jsonval', 'a_std_jsonval_id' );
    //def_ref( 'a_std_pref_user_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_pref_user_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_pref_user_created_on', DBT_CREATED_ON );
    def_col( 'a_std_pref_user_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_pref_user_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_pref_user_user_id', 'a_std_pref_user_prefname_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-10-25 jj5 - t_history_std_pref_user
    //

    mod_tab( 't_history_std_pref_user' );

    //def_key( 'a_std_pref_user_history_id', DBT_ID );
    def_ref( 'a_std_pref_user_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_pref_user_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_pref_user_id', 't_entity_std_pref_user' );
    def_ref( 'a_std_pref_user_user_id', 't_entity_std_pref_user' );
    def_ref( 'a_std_pref_user_prefname_id', 't_entity_std_pref_user' );
    def_ref( 'a_std_pref_user_jsonval_id', 't_entity_std_pref_user' );
    //def_ref( 'a_std_pref_user_created_in', 't_entity_std_pref_user' );
    //def_ref( 'a_std_pref_user_updated_in', 't_entity_std_pref_user' );
    def_ref( 'a_std_pref_user_created_on', 't_entity_std_pref_user' );
    def_ref( 'a_std_pref_user_updated_on', 't_entity_std_pref_user' );

    def_idx( [ 'a_std_pref_user_id', 'a_std_pref_user_history_id' ], MUD_IDX_UNIQUE );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-25 jj5 - t_entity_std_pref_browser
  //

  protected function define_t_entity_std_pref_browser() {

    def_tab( 't_history_std_pref_browser' );

    def_key( 'a_std_pref_browser_history_id', DBT_ID );

    //
    // 2020-10-25 jj5 - t_entity_std_pref_browser
    //

    def_tab( 't_entity_std_pref_browser' );

    def_rek( 'a_std_pref_browser_id', 't_ident_std_internal_id', 'a_std_internal_id' );
    def_ref( 'a_std_pref_browser_rowversion', 't_history_std_pref_browser', 'a_std_pref_browser_history_id' );
    def_ref( 'a_std_pref_browser_browser_id', 't_entity_std_browser', 'a_std_browser_id' );
    def_ref( 'a_std_pref_browser_prefname_id', 't_particle_std_prefname', 'a_std_prefname_id' );
    def_ref( 'a_std_pref_browser_jsonval_id', 't_piece_std_jsonval', 'a_std_jsonval_id' );
    //def_ref( 'a_std_pref_browser_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    //def_ref( 'a_std_pref_browser_updated_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_pref_browser_created_on', DBT_CREATED_ON );
    def_col( 'a_std_pref_browser_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_pref_browser_rowversion' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_pref_browser_browser_id', 'a_std_pref_browser_prefname_id' ], MUD_IDX_UNIQUE );

    //
    // 2020-10-25 jj5 - t_history_std_pref_browser
    //

    mod_tab( 't_history_std_pref_browser' );

    //def_key( 'a_std_pref_browser_history_id', DBT_ID );
    def_ref( 'a_std_pref_browser_history_interaction_id', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_ref( 'a_std_pref_browser_history_crud_enum', 't_lookup_std_crud', 'a_std_crud_enum' );
    def_ref( 'a_std_pref_browser_id', 't_entity_std_pref_browser' );
    def_ref( 'a_std_pref_browser_browser_id', 't_entity_std_pref_browser' );
    def_ref( 'a_std_pref_browser_prefname_id', 't_entity_std_pref_browser' );
    def_ref( 'a_std_pref_browser_jsonval_id', 't_entity_std_pref_browser' );
    //def_ref( 'a_std_pref_browser_created_in', 't_entity_std_pref_browser' );
    //def_ref( 'a_std_pref_browser_updated_in', 't_entity_std_pref_browser' );
    def_ref( 'a_std_pref_browser_created_on', 't_entity_std_pref_browser' );
    def_ref( 'a_std_pref_browser_updated_on', 't_entity_std_pref_browser' );

    def_idx( [ 'a_std_pref_browser_id', 'a_std_pref_browser_history_id' ], MUD_IDX_UNIQUE );

  }
}
