<?php

class MudModuleHttp extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-10-24 jj5 - traits
  //

  use MudHttpInputNormalization;
  use MudHttpInputValue;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public methods...
  //

  public function is_http_query() {

    // 2026-10-24 jj5 - THINK: should we add OPTIONS and TRACE?
    //
    static $query_verb_list = [ 'GET', 'HEAD' ];

    return in_array( $this->get_http_verb(), $query_verb_list, $strict = true );

  }

  public function is_http_submission() {

    return ! $this->is_http_query();

  }

  public function get_http_verb() {

    return mb_strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ?? 'GET' );

  }

  public function cache_forever() {

    $expiry_time = strtotime( '+10 years' );
    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', $expiry_time ) . ' GMT' );
    header( 'Cache-Control: max-age=' . ( 10 * 365 * 24 * 60 * 60 ) . ', public' ); // 10 years in seconds
    header( 'Pragma: cache' );

  }
}
