<?php

trait mud_mudballdb_2021_08_30_090715_particle {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-01 jj5 - t_particle_std_action
  //

  protected function define_t_particle_std_action() {

    def_tab( 't_particle_std_action' );

    def_key( 'a_std_action_id', DBT_ID );
    def_col( 'a_std_action', DBT_ASCII_BIN );
    def_dup( 'a_std_action_ci', 'a_std_action', DBT_ASCII_CI );
    def_ref( 'a_std_action_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_action_created_on', DBT_CREATED_ON );
    def_col( 'a_std_action_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_action' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_action_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_action',
      [
        'a_std_action' => null,
        'a_std_action_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      // 2022-03-20 jj5 - this will always be incomplete so don't bother...
      /*
      [ APP_ACTION_USER_LOGIN ],
      [ APP_ACTION_USER_LOGOUT ],
      [ APP_ACTION_USER_SIGNUP ],
      [ APP_ACTION_USER_PASSWORD_RESET ],
      [ APP_ACTION_ADMIN_USER_CREATE ],
      [ APP_ACTION_ADMIN_USER_UPDATE ],
      [ APP_ACTION_ADMIN_USER_DELETE ],
      [ APP_ACTION_DEV_FIELD_VALIDATE ],
      */
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_cache_name
  //

  protected function define_t_particle_std_cache_name() {

    def_tab( 't_particle_std_cache_name' );

    def_key( 'a_std_cache_name_id', DBT_ID );
    def_col( 'a_std_cache_name', DBT_ASCII_BIN );
    def_dup( 'a_std_cache_name_ci', 'a_std_cache_name', DBT_ASCII_CI );
    def_ref( 'a_std_cache_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_cache_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cache_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_cache_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cache_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_cache_name',
      [
        'a_std_cache_name' => null,
        'a_std_cache_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_cache_type
  //

  protected function define_t_particle_std_cache_type() {

    def_tab( 't_particle_std_cache_type' );

    def_key( 'a_std_cache_type_id', DBT_ID );
    def_col( 'a_std_cache_type', DBT_ASCII_BIN );
    def_dup( 'a_std_cache_type_ci', 'a_std_cache_type', DBT_ASCII_CI );
    def_ref( 'a_std_cache_type_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_cache_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cache_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_cache_type' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cache_type_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_cache_type',
      [
        'a_std_cache_type' => null,
        'a_std_cache_type_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_content_type
  //

  protected function define_t_particle_std_content_type() {

    def_tab( 't_particle_std_content_type' );

    def_key( 'a_std_content_type_id', DBT_ID );
    def_col( 'a_std_content_type', DBT_ASCII_BIN );
    def_dup( 'a_std_content_type_ci', 'a_std_content_type', DBT_ASCII_CI );
    def_ref( 'a_std_content_type_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_content_type_created_on', DBT_CREATED_ON );
    def_col( 'a_std_content_type_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_content_type' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_content_type_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_content_type',
      [
        'a_std_content_type' => null,
        'a_std_content_type_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ 'text/html; charset=UTF-8' ],
      [ 'text/html' ],
      [ 'text/plain; charset=UTF-8' ],
      [ 'text/plain' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_hostname
  //

  protected function define_t_particle_std_hostname() {

    def_tab( 't_particle_std_hostname' );

    def_key( 'a_std_hostname_id', DBT_ID );
    def_col( 'a_std_hostname', DBT_ASCII_BIN );
    def_dup( 'a_std_hostname_ci', 'a_std_hostname', DBT_ASCII_CI );
    def_ref( 'a_std_hostname_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_hostname_created_on', DBT_CREATED_ON );
    def_col( 'a_std_hostname_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_hostname' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_hostname_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_hostname',
      [
        'a_std_hostname' => null,
        'a_std_hostname_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ 'localhost' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_ip_address
  //

  protected function define_t_particle_std_ip_address() {

    def_tab( 't_particle_std_ip_address' );

    def_key( 'a_std_ip_address_id', DBT_ID );
    def_col( 'a_std_ip_address', DBT_ASCII_BIN );
    def_dup( 'a_std_ip_address_ci', 'a_std_ip_address', DBT_ASCII_CI );
    def_ref( 'a_std_ip_address_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_ip_address_created_on', DBT_CREATED_ON );
    def_col( 'a_std_ip_address_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_ip_address' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_ip_address_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_ip_address',
      [
        'a_std_ip_address' => null,
        'a_std_ip_address_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ '127.0.0.1' ],
      [ '127.0.1.1' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_password_hash
  //

  protected function define_t_particle_std_password_hash() {

    def_tab( 't_particle_std_password_hash' );

    def_key( 'a_std_password_hash_id', DBT_ID );
    def_vrt( 'a_std_password', DBT_UTF8_BIN, [ SPEC_MIN => 6 ] );
    def_vrt( 'a_std_password_confirm', DBT_UTF8_BIN, [ SPEC_MIN => 6 ] );
    def_col( 'a_std_password_hash', DBT_ASCII_BIN );
    def_ref( 'a_std_password_hash_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_password_hash_created_on', DBT_CREATED_ON );
    def_col( 'a_std_password_hash_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_password_hash' ], MUD_IDX_UNIQUE );

    def_dat( 't_particle_std_password_hash',
      [
        'a_std_password_hash' => null,
        'a_std_password_hash_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-01 jj5 - t_particle_std_slug
  //

  protected function define_t_particle_std_slug() {

    def_tab( 't_particle_std_slug' );

    def_key( 'a_std_slug_id', DBT_ID );
    def_col( 'a_std_slug', DBT_ASCII_BIN, [ SPEC_MIN => 1, SPEC_MAX => MUD_SIZE_ASCII_255, SPEC_VALID => MUD_REGEX_VALID_SLUG ] );
    def_dup( 'a_std_slug_ci', 'a_std_slug', DBT_ASCII_CI );
    def_ref( 'a_std_slug_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_slug_created_on', DBT_CREATED_ON );
    def_col( 'a_std_slug_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_slug' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_slug_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_slug',
      [
        'a_std_slug' => null,
        'a_std_slug_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_table_full_name
  //

  protected function define_t_particle_std_table_full_name() {

    // 2020-03-10 jj5 - table full name is spec name with $prefix

    def_tab( 't_particle_std_table_full_name' );

    def_key( 'a_std_table_full_name_id', DBT_ID );
    def_col( 'a_std_table_full_name', DBT_ASCII_BIN );
    def_dup( 'a_std_table_full_name_ci', 'a_std_table_full_name', DBT_ASCII_CI );
    def_ref( 'a_std_table_full_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_table_full_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_table_full_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_table_full_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_table_full_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_table_full_name',
      [
        'a_std_table_full_name' => null,
        'a_std_table_full_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      //[ 'information_schema.tables' ],
      //[ 'information_schema.views' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_table_short_name
  //

  protected function define_t_particle_std_table_short_name() {

    // 2020-03-10 jj5 - short names remove 't_{$pattern}_' prefix and don't
    // include $prefix

    def_tab( 't_particle_std_table_short_name' );

    def_key( 'a_std_table_short_name_id', DBT_ID );
    def_col( 'a_std_table_short_name', DBT_ASCII_BIN );
    def_dup( 'a_std_table_short_name_ci', 'a_std_table_short_name', DBT_ASCII_CI );
    def_ref( 'a_std_table_short_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_table_short_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_table_short_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_table_short_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_table_short_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_table_short_name',
      [
        'a_std_table_short_name' => null,
        'a_std_table_short_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_table_name
  //

  protected function define_t_particle_std_table_name() {

    // 2021-03-22 jj5 - NOTE: the std_table_name table is a 'structured value'

    def_tab( 't_particle_std_table_name' );

    def_key( 'a_std_table_name_id', DBT_ID );
    def_col( 'a_std_table_name', DBT_ASCII_BIN );
    def_dup( 'a_std_table_name_ci', 'a_std_table_name', DBT_ASCII_CI );
    def_ref( 'a_std_table_name_rectangle_type_enum', 't_lookup_std_rectangle_type', 'a_std_rectangle_type_enum' );
    def_ref( 'a_std_table_name_table_pattern_enum', 't_lookup_std_table_pattern', 'a_std_table_pattern_enum' );
    def_ref( 'a_std_table_name_table_full_name_id', 't_particle_std_table_full_name', 'a_std_table_full_name_id' );
    def_ref( 'a_std_table_name_table_short_name_id', 't_particle_std_table_short_name', 'a_std_table_short_name_id' );
    def_ref( 'a_std_table_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_table_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_table_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_table_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_table_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_table_name',
      [
        'a_std_table_name' => null,
        'a_std_table_name_rectangle_type_enum' => MudRectangleType::OTHER,
        'a_std_table_name_table_pattern_enum' => MudTablePattern::EPHEMERAL,
        'a_std_table_name_table_full_name_id' => 1,
        'a_std_table_name_table_short_name_id' => 1,
        'a_std_table_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      //[ 'information_schema.tables' ],
      //[ 'information_schema.views' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-12 jj5 - t_particle_std_timezone
  //

  protected function define_t_particle_std_timezone() {

    def_tab( 't_particle_std_timezone' );

    def_key( 'a_std_timezone_id', DBT_ID );
    def_col( 'a_std_timezone', DBT_ASCII_BIN );
    def_dup( 'a_std_timezone_ci', 'a_std_timezone', DBT_ASCII_CI );
    def_ref( 'a_std_timezone_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_timezone_created_on', DBT_CREATED_ON );
    def_col( 'a_std_timezone_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_timezone' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_timezone_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_timezone',
      [
        'a_std_timezone' => null,
        'a_std_timezone_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ 'Australia/Sydney' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_token
  //

  protected function define_t_particle_std_token() {

    def_tab( 't_particle_std_token' );

    def_key( 'a_std_token_id', DBT_ID );
    def_col( 'a_std_token', DBT_TOKEN );
    def_ref( 'a_std_token_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_token_created_on', DBT_CREATED_ON );
    def_col( 'a_std_token_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_token' ], MUD_IDX_UNIQUE );

    def_dat( 't_particle_std_token',
      [
        'a_std_token' => null,
        'a_std_token_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  // 2021-03-21 jj5 - OLD: we use a lookup table for URI Schemes now... see above.
  /*
  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-10-01 jj5 - t_particle_std_uri_scheme
  //

  s_tab( 't_particle_std_urischeme' );

  s_key( 'a_std_urischeme_id', DBT_ID );

  // 2020-10-12 jj5 - NOTE: a URL scheme should always be lower case. We use CI here to
  // ensure no duplicates. Applications should convert to lower case if necessary. If you
  // register an upper case or mixed case value you're gonna have a bad time.
  //
  s_col( 'a_std_urischeme', DBT_ASCII_CI );

  s_ref( 'a_std_urischeme_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
  s_col( 'a_std_urischeme_created_on', DBT_CREATED_ON );
  s_col( 'a_std_urischeme_updated_on', DBT_UPDATED_ON );

  s_idx( [ 'a_std_urischeme' ], MUD_IDX_UNIQUE );

  s_dat( 't_particle_std_urischeme',
    [
      'a_std_urischeme' => null,
      'a_std_urischeme_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
    ], [
    [ '' ],
    [ 'https' ],
    [ 'http' ],
  ]);
  */


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2020-09-15 jj5 - t_particle_std_username
  //

  protected function define_t_particle_std_username() {

    def_tab( 't_particle_std_username' );

    def_key( 'a_std_username_id', DBT_ID );
    def_col( 'a_std_username', DBT_ASCII_BIN, [ SPEC_MIN => 3, SPEC_MAX => 32, SPEC_VALID => MUD_REGEX_VALID_USERNAME ] );
    def_dup( 'a_std_username_ci', 'a_std_username', DBT_ASCII_CI );
    def_ref( 'a_std_username_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_username_created_on', DBT_CREATED_ON );
    def_col( 'a_std_username_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_username' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_username_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_username',
      [
        'a_std_username' => null,
        'a_std_username_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      //[ 'system' ],
      [ MUDBALL_MAINTAINER_USERNAME ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_cookie_name
  //

  protected function define_t_particle_std_cookie_name() {

    def_tab( 't_particle_std_cookie_name' );

    def_key( 'a_std_cookie_name_id', DBT_ID );
    def_col( 'a_std_cookie_name', DBT_ASCII_BIN );
    def_dup( 'a_std_cookie_name_ci', 'a_std_cookie_name', DBT_ASCII_CI );
    def_ref( 'a_std_cookie_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_cookie_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cookie_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_cookie_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cookie_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_cookie_name',
      [
        'a_std_cookie_name' => null,
        'a_std_cookie_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_cookie_value
  //

  protected function define_t_particle_std_cookie_value() {

    def_tab( 't_particle_std_cookie_value' );

    def_key( 'a_std_cookie_value_id', DBT_ID );
    def_col( 'a_std_cookie_value_urlencoded', DBT_ASCII_BIN, MUD_SIZE_ASCII_767 );
    def_dup( 'a_std_cookie_value_urlencoded_ci', 'a_std_cookie_value_urlencoded', DBT_ASCII_CI );
    def_ref( 'a_std_cookie_value_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_cookie_value_created_on', DBT_CREATED_ON );
    def_col( 'a_std_cookie_value_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_cookie_value_urlencoded' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_cookie_value_urlencoded_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_cookie_value',
      [
        'a_std_cookie_value_urlencoded' => null,
        'a_std_cookie_value_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_facility
  //

  protected function define_t_particle_std_facility() {

    // 2022-02-22 jj5 - NOTE: make the facility name the class name, should be in the form:
    // {mud,app}_facility_{what_ever}

    def_tab( 't_particle_std_facility' );

    def_key( 'a_std_facility_id', DBT_ID );
    def_col( 'a_std_facility', DBT_ASCII_BIN );
    def_dup( 'a_std_facility_ci', 'a_std_facility', DBT_ASCII_CI );
    def_ref( 'a_std_facility_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_facility_created_on', DBT_CREATED_ON );
    def_col( 'a_std_facility_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_facility' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_facility_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_facility',
      [
        'a_std_facility' => null,
        'a_std_facility_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  // 2022-02-20 jj5 - this is obsolete...
  //
  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_facility_mode
  //
  /*
  protected function define_t_particle_std_facility_mode() {

    def_tab( 't_particle_std_facility_mode' );

    def_key( 'a_std_facility_mode_id', DBT_ID );
    def_col( 'a_std_facility_mode', DBT_ASCII_BIN );
    def_dup( 'a_std_facility_mode_ci', 'a_std_facility_mode', DBT_ASCII_CI );
    def_ref( 'a_std_facility_mode_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_facility_mode_created_on', DBT_CREATED_ON );
    def_col( 'a_std_facility_mode_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_facility_mode' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_facility_mode_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_facility_mode',
      [
        'a_std_facility_mode' => null,
        'a_std_facility_mode_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ 'index' ],
      [ 'list' ],
      [ 'view' ],
      [ 'edit' ],
      [ 'add' ],
    ]);

  }
  */


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_facility_path
  //

  protected function define_t_particle_std_facility_path() {

    def_tab( 't_particle_std_facility_path' );

    def_key( 'a_std_facility_path_id', DBT_ID );
    def_col( 'a_std_facility_path', DBT_ASCII_BIN, MUD_SIZE_ASCII_767 );
    def_dup( 'a_std_facility_path_ci', 'a_std_facility_path', DBT_ASCII_CI );
    def_ref( 'a_std_facility_path_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_facility_path_created_on', DBT_CREATED_ON );
    def_col( 'a_std_facility_path_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_facility_path' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_facility_path_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_facility_path',
      [
        'a_std_facility_path' => null,
        'a_std_facility_path_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }

  /*
  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_http_response_code
  //

  // 2022-02-20 jj5 - SEE: t_lookup_std_http_verb

  // 2021-03-22 jj5 - THINK: why on Earth do we have this table? What was I thinking..? We are
  // modelling a 16-bit value with a 24-bit value, what is the point?

  // 2021-03-22 jj5 - TODO: review uses of this table and get rid of it...

  s_tab( 't_particle_std_http_response_code' );

  s_key( 'a_std_http_response_code_id', DBT_ID );
  s_col( 'a_std_http_response_code', DBT_UINT16 );
  s_ref( 'a_std_http_response_code_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
  s_col( 'a_std_http_response_code_created_on', DBT_CREATED_ON );
  s_col( 'a_std_http_response_code_updated_on', DBT_UPDATED_ON );

  s_idx( [ 'a_std_http_response_code' ], MUD_IDX_UNIQUE );

  s_dat( 't_particle_std_http_response_code',
    [
      'a_std_http_response_code' => null,
      'a_std_http_response_code_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
    ], [
    [   0 ],
    [ 200 ],
    [ 303 ],
    [ 301 ],
    [ 404 ],
    [ 500 ],
  ]);
  */


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_input_field
  //

  protected function define_t_particle_std_input_field() {

    def_tab( 't_particle_std_input_field' );

    def_key( 'a_std_input_field_id', DBT_ID );
    def_col( 'a_std_input_field', DBT_ASCII_BIN );
    def_dup( 'a_std_input_field_ci', 'a_std_input_field', DBT_ASCII_CI );
    def_ref( 'a_std_input_field_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_input_field_created_on', DBT_CREATED_ON );
    def_col( 'a_std_input_field_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_input_field' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_input_field_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_input_field',
      [
        'a_std_input_field' => null,
        'a_std_input_field_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_input_problem
  //

  protected function define_t_particle_std_input_problem() {

    def_tab( 't_particle_std_input_problem' );

    def_key( 'a_std_input_problem_id', DBT_ID );
    def_col( 'a_std_input_problem', DBT_UTF8_BIN, MUD_SIZE_UTF8_190 );
    def_dup( 'a_std_input_problem_ci', 'a_std_input_problem', DBT_UTF8_CI );
    def_ref( 'a_std_input_problem_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_input_problem_created_on', DBT_CREATED_ON );
    def_col( 'a_std_input_problem_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_input_problem' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_input_problem_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_input_problem',
      [
        'a_std_input_problem' => null,
        'a_std_input_problem_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_http_powered_by
  //

  protected function define_t_particle_std_http_powered_by() {

    def_tab( 't_particle_std_http_powered_by' );

    def_key( 'a_std_http_powered_by_id', DBT_ID );
    def_col( 'a_std_http_powered_by', DBT_ASCII_BIN );
    def_dup( 'a_std_http_powered_by_ci', 'a_std_http_powered_by', DBT_ASCII_CI );
    def_ref( 'a_std_http_powered_by_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_powered_by_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_powered_by_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_powered_by' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_http_powered_by_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_http_powered_by',
      [
        'a_std_http_powered_by' => null,
        'a_std_http_powered_by_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_prefname
  //

  protected function define_t_particle_std_prefname() {


    def_tab( 't_particle_std_prefname' );

    def_key( 'a_std_prefname_id', DBT_ID );
    def_col( 'a_std_prefname', DBT_ASCII_BIN );
    def_dup( 'a_std_prefname_ci', 'a_std_prefname', DBT_ASCII_CI );
    def_ref( 'a_std_prefname_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_prefname_created_on', DBT_CREATED_ON );
    def_col( 'a_std_prefname_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_prefname' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_prefname_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_prefname',
      [
        'a_std_prefname' => null,
        'a_std_prefname_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_file_name
  //

  protected function define_t_particle_std_file_name() {

    def_tab( 't_particle_std_file_name' );

    def_key( 'a_std_file_name_id', DBT_ID );
    def_col( 'a_std_file_name', DBT_UTF8_BIN, MUD_SIZE_UTF8_190 );
    def_dup( 'a_std_file_name_ci', 'a_std_file_name', DBT_UTF8_CI );
    def_ref( 'a_std_file_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_file_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_file_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_file_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_file_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_file_name',
      [
        'a_std_file_name' => null,
        'a_std_file_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_mailbox
  //

  protected function define_t_particle_std_mailbox() {

    def_tab( 't_particle_std_mailbox' );

    def_key( 'a_std_mailbox_id', DBT_ID );
    def_col( 'a_std_mailbox', DBT_ASCII_BIN );
    def_dup( 'a_std_mailbox_ci', 'a_std_mailbox', DBT_ASCII_CI );
    def_ref( 'a_std_mailbox_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_mailbox_created_on', DBT_CREATED_ON );
    def_col( 'a_std_mailbox_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_mailbox' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_mailbox_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_mailbox',
      [
        'a_std_mailbox' => null,
        'a_std_mailbox_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_email_address
  //

  protected function define_t_particle_std_email_address() {

    // 2021-03-22 jj5 - NOTE: email addresses are 'structured values'

    def_tab( 't_particle_std_email_address' );

    def_key( 'a_std_email_address_id', DBT_ID );
    def_col( 'a_std_email_address', DBT_ASCII_BIN, [ SPEC_VALID => MUD_REGEX_VALID_EMAIL ] );
    def_dup( 'a_std_email_address_ci', 'a_std_email_address', DBT_ASCII_CI );
    def_ref( 'a_std_email_address_mailbox_id', 't_particle_std_mailbox', 'a_std_mailbox_id' );
    def_ref( 'a_std_email_address_hostname_id', 't_particle_std_hostname', 'a_std_hostname_id' );
    def_ref( 'a_std_email_address_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_email_address_created_on', DBT_CREATED_ON );
    def_col( 'a_std_email_address_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_email_address' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_email_address_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_email_address',
      [
        'a_std_email_address' => null,
        'a_std_email_address_mailbox_id' => null,
        'a_std_email_address_hostname_id' => null,
        'a_std_email_address_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '', 1, 1 ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_proper_name
  //

  protected function define_t_particle_std_proper_name() {

    $maintainer_name = MUDBALL_MAINTAINER_NAME;

    def_tab( 't_particle_std_proper_name' );

    def_key( 'a_std_proper_name_id', DBT_ID );
    def_col( 'a_std_proper_name', DBT_UTF8_BIN, MUD_SIZE_UTF8_190 );
    def_dup( 'a_std_proper_name_ci', 'a_std_proper_name', DBT_UTF8_CI );
    def_ref( 'a_std_proper_name_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_proper_name_created_on', DBT_CREATED_ON );
    def_col( 'a_std_proper_name_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_proper_name' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_proper_name_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_proper_name',
      [
        'a_std_proper_name' => null,
        'a_std_proper_name_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
      [ $maintainer_name ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_particle_std_expiry
  //

  protected function define_t_particle_std_expiry() {


    $syd_epoch = new DateTime();
    $syd_epoch->setTimeZone( new DateTimeZone( 'Australia/Sydney' ) );
    $syd_epoch->setTimestamp( 0 );

    // 2021-03-22 jj5 - NOTE: expiries are 'structured values', sort of... :)

    def_tab( 't_particle_std_expiry' );

    def_key( 'a_std_expiry_id', DBT_ID );
    def_col( 'a_std_expiry', DBT_INT64 );
    def_col( 'a_std_expiry_utc', DBT_DATETIME_UTC );
    def_col( 'a_std_expiry_syd', DBT_DATETIME_SYD );
    def_ref( 'a_std_expiry_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_expiry_created_on', DBT_CREATED_ON );
    def_col( 'a_std_expiry_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_expiry' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_expiry_utc' ], MUD_IDX_UNIQUE );

    def_dat( 't_particle_std_expiry',
      [
        'a_std_expiry' => null,
        'a_std_expiry_utc' => null,
        'a_std_expiry_syd' => null,
        'a_std_expiry_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [
        0,
        gmdate( MUD_SQL_DATE_FORMAT, 0 ),
        $syd_epoch->format( MUD_SQL_DATE_FORMAT )
      ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_particle_std_validation_scope
  //

  protected function define_t_particle_std_validation_scope() {

    def_tab( 't_particle_std_validation_scope' );

    def_key( 'a_std_validation_scope_id', DBT_ID );
    def_col( 'a_std_validation_scope', DBT_ASCII_BIN );
    def_dup( 'a_std_validation_scope_ci', 'a_std_validation_scope', DBT_ASCII_CI );
    def_ref( 'a_std_validation_scope_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_validation_scope_created_on', DBT_CREATED_ON );
    def_col( 'a_std_validation_scope_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_validation_scope' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_validation_scope_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_validation_scope',
      [
        'a_std_validation_scope' => null,
        'a_std_validation_scope_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_particle_std_validation_issue
  //

  protected function define_t_particle_std_validation_issue() {

    def_tab( 't_particle_std_validation_issue' );

    def_key( 'a_std_validation_issue_id', DBT_ID );
    def_col( 'a_std_validation_issue', DBT_ASCII_BIN );
    def_dup( 'a_std_validation_issue_ci', 'a_std_validation_issue', DBT_ASCII_CI );
    def_ref( 'a_std_validation_issue_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_validation_issue_created_on', DBT_CREATED_ON );
    def_col( 'a_std_validation_issue_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_validation_issue' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_validation_issue_ci' ], MUD_IDX_INDEX );

    def_dat( 't_particle_std_validation_issue',
      [
        'a_std_validation_issue' => null,
        'a_std_validation_issue_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ '' ],
    ]);

  }


}
