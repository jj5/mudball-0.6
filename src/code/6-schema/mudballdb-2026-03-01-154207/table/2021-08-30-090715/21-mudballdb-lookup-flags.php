<?php

trait mud_mudballdb_2021_08_30_090715_lookup_flags {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-24 jj5 - t_lookup_std_crud_flags
  //

  protected function define_t_lookup_std_crud_flags() {

    def_tab( 't_lookup_std_crud_flags' );

    def_key( 'a_std_crud_flags', DBT_UINT8 );
    def_key( 'a_std_crud_flags_is_create', DBT_BOOL );
    def_key( 'a_std_crud_flags_is_retrieve', DBT_BOOL );
    def_key( 'a_std_crud_flags_is_update', DBT_BOOL );
    def_key( 'a_std_crud_flags_is_delete', DBT_BOOL );
    def_key( 'a_std_crud_flags_is_undelete', DBT_BOOL );
    def_key( 'a_std_crud_flags_is_shred', DBT_BOOL );
    def_col( 'a_std_crud_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_crud_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_crud_flags',
      [
        'a_std_crud_flags' => null,
        'a_std_crud_flags_is_create' => null,
        'a_std_crud_flags_is_retrieve' => null,
        'a_std_crud_flags_is_update' => null,
        'a_std_crud_flags_is_delete' => null,
        'a_std_crud_flags_is_undelete' => null,
        'a_std_crud_flags_is_shred' => null,
      ],
      mud_gen_flags([
        FLAG_IS_CRUD_CREATE,
        FLAG_IS_CRUD_RETRIEVE,
        FLAG_IS_CRUD_UPDATE,
        FLAG_IS_CRUD_DELETE,
        FLAG_IS_CRUD_UNDELETE,
        FLAG_IS_CRUD_SHRED,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - t_lookup_std_interaction_flags
  //

  protected function define_t_lookup_std_interaction_flags() {

    def_tab( 't_lookup_std_interaction_flags' );

    def_key( 'a_std_interaction_flags', DBT_UINT8 );
    def_col( 'a_std_interaction_flags_is_done', DBT_BOOL );
    def_col( 'a_std_interaction_flags_is_fail', DBT_BOOL );
    def_col( 'a_std_interaction_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_interaction_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_interaction_flags',
      [
        'a_std_interaction_flags' => null,
        'a_std_interaction_flags_is_done' => null,
        'a_std_interaction_flags_is_fail' => null,
      ],
      mud_gen_flags([
        FLAG_IS_INTERACTION_DONE,
        FLAG_IS_INTERACTION_FAIL,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_browser_flags
  //

  protected function define_t_lookup_std_browser_flags() {

    def_tab( 't_lookup_std_browser_flags' );

    def_key( 'a_std_browser_flags', DBT_UINT8 );
    def_col( 'a_std_browser_flags_is_verified', DBT_BOOL );
    def_col( 'a_std_browser_flags_is_spammer', DBT_BOOL );
    def_col( 'a_std_browser_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_browser_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_browser_flags',
      [
        'a_std_browser_flags' => null,
        'a_std_browser_flags_is_verified' => null,
        'a_std_browser_flags_is_spammer' => null,
      ],
      mud_gen_flags([
        FLAG_IS_BROWSER_VERIFIED,
        FLAG_IS_BROWSER_SPAMMER,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_cookie_flags
  //

  protected function define_t_lookup_std_cookie_flags() {

    def_tab( 't_lookup_std_cookie_flags' );

    def_key( 'a_std_cookie_flags', DBT_UINT8 );
    def_col( 'a_std_cookie_flags_is_secure', DBT_BOOL );
    def_col( 'a_std_cookie_flags_is_http_only', DBT_BOOL );
    def_col( 'a_std_cookie_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cookie_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_cookie_flags',
      [
        'a_std_cookie_flags' => null,
        'a_std_cookie_flags_is_secure' => null,
        'a_std_cookie_flags_is_http_only' => null,
      ],
      mud_gen_flags([
        FLAG_IS_COOKIE_SECURE,
        FLAG_IS_COOKIE_HTTP_ONLY,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_prefspec_flags
  //

  protected function define_t_lookup_std_prefspec_flags() {

    def_tab( 't_lookup_std_prefspec_flags' );

    def_key( 'a_std_prefspec_flags', DBT_UINT8 );
    def_col( 'a_std_prefspec_flags_is_null_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_is_bool_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_is_int_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_is_float_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_is_string_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_is_other_allowed', DBT_BOOL );
    def_col( 'a_std_prefspec_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_prefspec_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_prefspec_flags',
      [
        'a_std_prefspec_flags' => null,
        'a_std_prefspec_flags_is_null_allowed' => null,
        'a_std_prefspec_flags_is_bool_allowed' => null,
        'a_std_prefspec_flags_is_int_allowed' => null,
        'a_std_prefspec_flags_is_float_allowed' => null,
        'a_std_prefspec_flags_is_string_allowed' => null,
        'a_std_prefspec_flags_is_other_allowed' => null,
      ],
      mud_gen_flags([
        FLAG_IS_PREF_NULL_ALLOWED,
        FLAG_IS_PREF_BOOL_ALLOWED,
        FLAG_IS_PREF_INT_ALLOWED,
        FLAG_IS_PREF_FLOAT_ALLOWED,
        FLAG_IS_PREF_STRING_ALLOWED,
        FLAG_IS_PREF_OTHER_ALLOWED,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_lookup_std_server_flags
  //

  protected function define_t_lookup_std_server_flags() {

    def_tab( 't_lookup_std_server_flags' );

    def_key( 'a_std_server_flags', DBT_UINT8 );
    def_col( 'a_std_server_flags_is_web_server', DBT_BOOL );
    def_col( 'a_std_server_flags_is_database_server', DBT_BOOL );
    def_col( 'a_std_server_flags_is_file_server', DBT_BOOL );
    def_col( 'a_std_server_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_server_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_server_flags',
      [
        'a_std_server_flags' => null,
        'a_std_server_flags_is_web_server' => null,
        'a_std_server_flags_is_database_server' => null,
        'a_std_server_flags_is_file_server' => null,
      ],
      mud_gen_flags([
        FLAG_IS_WEB_SERVER,
        FLAG_IS_DATABASE_SERVER,
        FLAG_IS_FILE_SERVER,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_session_flags
  //

  protected function define_t_lookup_std_session_flags() {

    def_tab( 't_lookup_std_session_flags' );

    def_key( 'a_std_session_flags', DBT_UINT8 );
    def_col( 'a_std_session_flags_is_verified', DBT_BOOL );
    def_col( 'a_std_session_flags_is_spammer', DBT_BOOL );
    def_col( 'a_std_session_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_session_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_session_flags',
      [
        'a_std_session_flags' => null,
        'a_std_session_flags_is_verified' => null,
        'a_std_session_flags_is_spammer' => null,
      ],
      mud_gen_flags([
        FLAG_IS_SESSION_VERIFIED,
        FLAG_IS_SESSION_SPAMMER,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_user_flags
  //

  protected function define_t_lookup_std_user_flags() {

    def_tab( 't_lookup_std_user_flags' );

    def_key( 'a_std_user_flags', DBT_UINT8 );
    def_col( 'a_std_user_flags_is_active', DBT_BOOL );
    def_col( 'a_std_user_flags_is_email_verified', DBT_BOOL );
    def_col( 'a_std_user_flags_is_username_verified', DBT_BOOL );
    def_col( 'a_std_user_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_user_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_user_flags',
      [
        'a_std_user_flags' => null,
        'a_std_user_flags_is_active' => null,
        'a_std_user_flags_is_email_verified' => null,
        'a_std_user_flags_is_username_verified' => null,
      ],
      mud_gen_flags([
        FLAG_IS_USER_ACTIVE,
        FLAG_IS_USER_EMAIL_VERIFIED,
        FLAG_IS_USER_USERNAME_VERIFIED,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - t_lookup_std_record_flags
  //

  protected function define_t_lookup_std_record_flags() {

    def_tab( 't_lookup_std_record_flags' );

    def_key( 'a_std_record_flags', DBT_UINT8 );
    def_col( 'a_std_record_flags_is_new', DBT_BOOL );
    def_col( 'a_std_record_flags_is_deleted', DBT_BOOL );
    def_col( 'a_std_record_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_record_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_record_flags',
      [
        'a_std_record_flags' => null,
        'a_std_record_flags_is_new' => null,
        'a_std_record_flags_is_deleted' => null,
      ],
      mud_gen_flags([
        FLAG_IS_RECORD_NEW,
        FLAG_IS_RECORD_DELETED,
      ])
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_lookup_std_web_response_flags
  //

  protected function define_t_lookup_std_web_response_flags() {

    def_tab( 't_lookup_std_web_response_flags' );

    def_key( 'a_std_web_response_flags', DBT_UINT8 );
    def_col( 'a_std_web_response_flags_is_connection_abort', DBT_BOOL );
    def_col( 'a_std_web_response_flags_is_connection_timeout', DBT_BOOL );
    def_col( 'a_std_web_response_flags_created_on', DBT_CREATED_ON );
    def_col( 'a_std_web_response_flags_updated_on', DBT_UPDATED_ON );

    def_dat( 't_lookup_std_web_response_flags',
      [
        'a_std_web_response_flags' => null,
        'a_std_web_response_flags_is_connection_abort' => null,
        'a_std_web_response_flags_is_connection_timeout' => null,
      ],
      mud_gen_flags([
        FLAG_IS_WEB_RESPONSE_CONNECTION_ABORT,
        FLAG_IS_WEB_RESPONSE_CONNECTION_TIMEOUT,
      ])
    );

  }
}
