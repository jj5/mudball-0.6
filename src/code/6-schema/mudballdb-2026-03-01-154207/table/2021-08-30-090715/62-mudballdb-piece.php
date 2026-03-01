<?php

trait mud_mudballdb_2021_08_30_090715_piece {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_asset
  //

  protected function define_t_piece_std_asset() {

    // 2021-03-22 jj5 - NOTE: an 'asset' is a file, it's stored in the file-system/CDN and named
    // with a hex-encoding of its hash, so it only has a hash, not a "value", the "value" is in
    // the file which is not stored in the database. So this table is just for mapping the hash
    // to an ID for internal use.

    def_tab( 't_piece_std_asset' );

    def_key( 'a_std_asset_id', DBT_ID );
    def_col( 'a_std_asset_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_asset_hash_hex', DBT_HASH_HEX );
    //s_col( 'a_std_asset_file_name', DBT_ASCII_BIN );
    //s_col( 'a_std_asset_file_type', DBT_ASCII_CI );
    // 2021-03-22 jj5 - TODO: we should log the file_name and file_type somewhere separately...
    //s_ref( 'a_std_asset_file_name_id', 't_particle_std_file_name', 'a_std_file_name_id' );
    //s_ref( 'a_std_asset_file_type_enum', 't_lookup_std_file_type', 'a_std_file_type_enum' );
    def_ref( 'a_std_asset_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_asset_created_on', DBT_CREATED_ON );
    def_col( 'a_std_asset_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_asset_hash_bin' ], MUD_IDX_UNIQUE );

  }


  // 2022-02-20 jj5 - this is a bad idea, http headers are pretty much always going to be
  // unique so there's no value stashing them in a piece table
  //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_http_headers
  //
  /*
  protected function define_t_piece_std_http_headers() {

    $jzon_null_jzon = mud_jzon_encode( null );
    $jzon_null_hash = mud_hash_bin( $jzon_null_jzon );

    $jzon_empty_jzon = mud_jzon_encode( [] );
    $jzon_empty_hash = mud_hash_bin( $jzon_empty_jzon );

    def_tab( 't_piece_std_http_headers' );

    def_key( 'a_std_http_headers_id', DBT_ID );
    def_col( 'a_std_http_headers_jzon', DBT_BMOB );
    def_col( 'a_std_http_headers_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_http_headers_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_http_headers_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_headers_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_headers_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_headers_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_http_headers',
      [
        'a_std_http_headers_hash_bin' => null,
        'a_std_http_headers_jzon' => null,
        'a_std_http_headers_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $jzon_null_hash,  $jzon_null_jzon ],
      [ $jzon_empty_hash,  $jzon_empty_jzon ],
    ]);

  }
  */


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_http_accept
  //

  protected function define_t_piece_std_http_accept() {

    $hash_empty = mud_hash_bin( '' );
    $hash_asta  = mud_hash_bin( '*/*' );

    def_tab( 't_piece_std_http_accept' );

    def_key( 'a_std_http_accept_id', DBT_ID );
    def_col( 'a_std_http_accept', DBT_ASCII_BIN, MUD_SIZE_ASCII_60000 );
    def_dup( 'a_std_http_accept_ci', 'a_std_http_accept', DBT_ASCII_CI );
    def_col( 'a_std_http_accept_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_http_accept_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_http_accept_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_accept_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_accept_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_accept_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_http_accept',
      [
        'a_std_http_accept_hash_bin' => null,
        'a_std_http_accept' => null,
        'a_std_http_accept_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
      [ $hash_asta,   '*/*' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_http_accept_encoding
  //

  protected function define_t_piece_std_http_accept_encoding() {

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_http_accept_encoding' );

    def_key( 'a_std_http_accept_encoding_id', DBT_ID );
    def_col( 'a_std_http_accept_encoding', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_http_accept_encoding_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_http_accept_encoding_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_http_accept_encoding_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_accept_encoding_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_accept_encoding_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_accept_encoding_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_http_accept_encoding',
      [
        'a_std_http_accept_encoding_hash_bin' => null,
        'a_std_http_accept_encoding' => null,
        'a_std_http_accept_encoding_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_http_accept_language
  //

  protected function define_t_piece_std_http_accept_language() {

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_http_accept_language' );

    def_key( 'a_std_http_accept_language_id', DBT_ID );
    def_col( 'a_std_http_accept_language', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_http_accept_language_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_http_accept_language_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_http_accept_language_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_accept_language_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_accept_language_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_accept_language_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_http_accept_language',
      [
        'a_std_http_accept_language_hash_bin' => null,
        'a_std_http_accept_language' => null,
        'a_std_http_accept_language_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_http_user_agent
  //

  protected function define_t_piece_std_http_user_agent() {

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_http_user_agent' );

    def_key( 'a_std_http_user_agent_id', DBT_ID );
    def_col( 'a_std_http_user_agent', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_http_user_agent_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_http_user_agent_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_http_user_agent_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_http_user_agent_created_on', DBT_CREATED_ON );
    def_col( 'a_std_http_user_agent_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_http_user_agent_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_http_user_agent',
      [
        'a_std_http_user_agent_hash_bin' => null,
        'a_std_http_user_agent' => null,
        'a_std_http_user_agent_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_jsonval
  //

  protected function define_t_piece_std_jsonval() {

    $hash_empty         = mud_hash_bin( '' );
    $hash_null          = mud_hash_bin( 'null' );
    $hash_false         = mud_hash_bin( 'false' );
    $hash_true          = mud_hash_bin( 'true' );
    $hash_zero          = mud_hash_bin( '0' );
    $hash_one           = mud_hash_bin( '1' );
    $hash_empty_string  = mud_hash_bin( '""' );

    def_tab( 't_piece_std_jsonval' );

    def_key( 'a_std_jsonval_id', DBT_ID );
    def_col( 'a_std_jsonval_json', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_jsonval_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_jsonval_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_jsonval_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_jsonval_created_on', DBT_CREATED_ON );
    def_col( 'a_std_jsonval_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_jsonval_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_jsonval',
      [
        'a_std_jsonval_hash_bin' => null,
        'a_std_jsonval_json' => null,
        'a_std_jsonval_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,          ''      ],
      [ $hash_null,           'null'  ],
      [ $hash_false,          'false' ],
      [ $hash_true,           'true'  ],
      [ $hash_zero,           '0'     ],
      [ $hash_one,            '1'     ],
      [ $hash_empty_string,   '""'    ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-22 jj5 - t_piece_std_jzon
  //

  protected function define_t_piece_std_jzon() {

    // 2022-05-22 jj5 - we will use null as the "empty" value...
    //
    $empty = null;

    $jzon_empty = mud_jzon_encode( $empty, $json_empty );

    $hash_empty = mud_hash_bin( $json_empty );

    def_tab( 't_piece_std_jzon' );

    def_key( 'a_std_jzon_id', DBT_ID );
    def_col( 'a_std_jzon_blob', DBT_BLOB );
    def_col( 'a_std_jzon_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_jzon_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_jzon_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_jzon_created_on', DBT_CREATED_ON );
    def_col( 'a_std_jzon_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_jzon_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_jzon',
      [
        'a_std_jzon_hash_bin' => null,
        'a_std_jzon_blob' => null,
        'a_std_jzon_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty, $jzon_empty ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_state
  //

  protected function define_t_piece_std_state() {

    $jzon_null_jzon = mud_jzon_encode( null );
    $jzon_null_hash = mud_hash_bin( $jzon_null_jzon );

    $jzon_empty_jzon = mud_jzon_encode( [] );
    $jzon_empty_hash = mud_hash_bin( $jzon_empty_jzon );

    def_tab( 't_piece_std_state' );

    def_key( 'a_std_state_id', DBT_ID );
    def_col( 'a_std_state_jzon', DBT_BMOB );
    def_col( 'a_std_state_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_state_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_state_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_state_created_on', DBT_CREATED_ON );
    def_col( 'a_std_state_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_state_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_state',
      [
        'a_std_state_hash_bin' => null,
        'a_std_state_jzon' => null,
        'a_std_state_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $jzon_null_hash,  $jzon_null_jzon ],
      [ $jzon_empty_hash,  $jzon_empty_jzon ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_url_path
  //

  protected function define_t_piece_std_url_path() {

    $hash_empty = mud_hash_bin( '' );
    $hash_slash = mud_hash_bin( '/' );

    def_tab( 't_piece_std_url_path' );

    def_key( 'a_std_url_path_id', DBT_ID );
    def_col( 'a_std_url_path', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_url_path_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_url_path_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_url_path_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_url_path_created_on', DBT_CREATED_ON );
    def_col( 'a_std_url_path_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_url_path_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_url_path',
      [
        'a_std_url_path_hash_bin' => null,
        'a_std_url_path' => null,
        'a_std_url_path_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
      [ $hash_slash,  '/' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_url_query
  //

  protected function define_t_piece_std_url_query() {

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_url_query' );

    def_key( 'a_std_url_query_id', DBT_ID );
    def_col( 'a_std_url_query', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_url_query_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_url_query_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_url_query_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_url_query_created_on', DBT_CREATED_ON );
    def_col( 'a_std_url_query_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_url_query_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_url_query',
      [
        'a_std_url_query_hash_bin' => null,
        'a_std_url_query' => null,
        'a_std_url_query_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_url_fragment
  //

  protected function define_t_piece_std_url_fragment() {

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_url_fragment' );

    def_key( 'a_std_url_fragment_id', DBT_ID );
    def_col( 'a_std_url_fragment', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_col( 'a_std_url_fragment_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_url_fragment_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_url_fragment_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_url_fragment_created_on', DBT_CREATED_ON );
    def_col( 'a_std_url_fragment_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_url_fragment_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_url_fragment',
      [
        'a_std_url_fragment_hash_bin' => null,
        'a_std_url_fragment' => null,
        'a_std_url_fragment_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty,  '' ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-22 jj5 - t_piece_std_url
  //

  protected function define_t_piece_std_url() {

    // 2021-03-22 jj5 - NOTE: std_url tables are structured values...

    $hash_empty = mud_hash_bin( '' );

    def_tab( 't_piece_std_url' );

    def_key( 'a_std_url_id', DBT_ID );
    def_col( 'a_std_url', DBT_ASCII_CI, MUD_SIZE_ASCII_60000 );
    def_ref( 'a_std_url_scheme_enum', 't_lookup_std_uri_scheme', 'a_std_uri_scheme_enum' );
    def_ref( 'a_std_url_hostname_id', 't_particle_std_hostname', 'a_std_hostname_id' );
    def_col( 'a_std_url_port', DBT_UINT16 );
    def_ref( 'a_std_url_url_path_id', 't_piece_std_url_path', 'a_std_url_path_id' );
    def_ref( 'a_std_url_url_query_id', 't_piece_std_url_query', 'a_std_url_query_id' );
    def_ref( 'a_std_url_url_fragment_id', 't_piece_std_url_fragment', 'a_std_url_fragment_id' );
    def_col( 'a_std_url_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_url_hash_hex', DBT_HASH_HEX );
    def_ref( 'a_std_url_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_url_created_on', DBT_CREATED_ON );
    def_col( 'a_std_url_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_url_hash_bin' ], MUD_IDX_UNIQUE );

    def_dat( 't_piece_std_url',
      [
        'a_std_url_hash_bin' => null,
        'a_std_url' => '',
        'a_std_url_scheme_enum' => 0,
        'a_std_url_hostname_id' => 1,
        'a_std_url_port' => 0,
        'a_std_url_url_path_id' => 1,
        'a_std_url_url_query_id' => 1,
        'a_std_url_url_fragment_id' => 1,
        'a_std_url_created_in' => function( $row, $ctx ) { return $ctx->get_interaction_id(); },
      ], [
      [ $hash_empty ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - t_piece_std_validation_value
  //

  protected function define_t_piece_std_validation_value() {

    def_tab( 't_piece_std_validation_value' );

    def_key( 'a_std_validation_value_id', DBT_ID );
    def_col( 'a_std_validation_value_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_validation_value_hash_hex', DBT_HASH_HEX );
    def_col( 'a_std_validation_value', DBT_TEXT );
    def_ref( 'a_std_validation_value_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_validation_value_created_on', DBT_CREATED_ON );
    def_col( 'a_std_validation_value_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_validation_value_hash_bin' ], MUD_IDX_UNIQUE );

  }
}
