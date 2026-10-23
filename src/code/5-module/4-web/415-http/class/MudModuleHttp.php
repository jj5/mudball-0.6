<?php

class MudModuleHttp extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-10-24 jj5 - traits
  //

  use MudHttpInputNormalization;
  use MudHttpInputValue;
  use MudHttpInputCookie;
  use MudHttpOutputCache;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public methods...
  //

  public function is_secure() {

    return ( $_SERVER[ 'HTTPS' ] ?? 'off' ) === 'on';

  }

  public function is_query() {

    // 2026-10-24 jj5 - THINK: should we add OPTIONS and TRACE?
    //
    static $query_verb_list = [ 'GET', 'HEAD' ];

    return in_array( $this->get_verb(), $query_verb_list, $strict = true );

  }

  public function is_submission() {

    return ! $this->is_query();

  }

  public function get_verb() {

    return mb_strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ?? 'GET' );

  }
}
