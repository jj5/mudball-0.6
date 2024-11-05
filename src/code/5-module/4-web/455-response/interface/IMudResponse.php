<?php

interface IMudResponse {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudResponse interface...
  //

  public function set_header( $header );
  public function add_header( $header );
  public function redirect( $location = null );
  public function reply_301_moved_permanently( $location );
  public function reply_303_success( $location );
  public function reply_304_not_modified();
  public function reply_400_bad_request();
  public function reply_404_not_found();
  public function reply( int $http_status_code, $location = null );
  public function has_errors();
  public function has_error( string $key, &$error = null );
  public function set_error( $key, $problem );
  public function get_errors();

}
