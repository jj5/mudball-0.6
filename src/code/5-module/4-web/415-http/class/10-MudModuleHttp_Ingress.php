<?php

class MudModuleHttp_Ingress extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public methods...
  //

  public function has_query(string $name): bool {
    return array_key_exists($name, $_GET);
  }
  public function has_input(string $name): bool {
    return array_key_exists($name, $_POST);
  }
  public function has_server(string $name): bool {
    return array_key_exists($name, $_SERVER);
  }

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

  public function get_raw_input() {

    return file_get_contents( 'php://input' );

  }
}
