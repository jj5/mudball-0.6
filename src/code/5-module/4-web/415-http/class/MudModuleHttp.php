<?php

class MudModuleHttp extends MudModuleWeb {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public methods...
  //

  public function is_http_query() {

    static $query_verb_list = [ 'GET', 'HEAD' ];

    return in_array( $this->get_http_verb(), $query_verb_list, $strict = true );

  }

  public function is_http_submission() {

    return ! $this->is_http_query();

  }

  public function get_http_verb() {

    return mb_strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ?? 'GET' );

  }
}
