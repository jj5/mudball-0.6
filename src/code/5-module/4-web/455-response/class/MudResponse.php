<?php

class MudResponse extends MudService implements IMudResponse {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - protected fields...
  //

  protected $errors = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudResponse interface...
  //

  public function set_header( $header ) {

    error_log( $header );

    header( $header, $replace = true );

  }

  public function add_header( $header ) {

    header( $header, $replace = false );

  }

  public function redirect( $location = null ) {

    if ( $location === null ) { $location = app_request()->get_request_url(); }

    $this->reply( 303, $location );

  }

  public function reply_301_moved_permanently( $location )  { $this->reply( 301, $location ); }

  // 2021-08-26 jj5 - NOTE: 303 is See Other, we use it to indicate success...
  //
  public function reply_303_success( $location )        { $this->reply( 303, $location ); }

  public function reply_304_not_modified()              { $this->reply( 304 ); }

  public function reply_400_bad_request()               { $this->reply( 400 ); }

  public function reply_404_not_found()                 { $this->reply( 404 ); }

  // 2021-08-26 jj5 - NOTE: our code never calls this, a 500 is what happens when our code fails.
  //
  //public function reply_500_internal_error()     { $this->reply( 500 ); }

  public function reply( int $http_status_code, $location = null ) {

    $this->send_http_response( $http_status_code, $location );

    $data = [
      'http_status_code' => $http_status_code,
      'location' => $location,
      'request' => app_request(),
      //'context' => app_request()->get_context(),
    ];

    throw new_mud_http_exception( $http_status_code, $location, $data );

  }

  public function has_errors() {

    return count( $this->errors ) !== 0;

  }

  public function has_error( string $key, &$error = null ) {

    $error = null;

    if ( ! array_key_exists( $key, $this->errors ) ) { return false; }

    $error = $this->errors[ $key ];

    return true;

  }

  public function set_error( $key, $problem ) {

    $error = $this->errors[ $key ] = $problem;

    return $this;

  }

  public function get_errors() { return $this->errors; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-05 jj5 - protected methods...
  //

  protected function send_http_response( int $http_status_code, $location = null ) {

    http_response_code( $http_status_code );

    if ( ! $location ) { return; }

    header( "Location: $location", $replace = true, $http_status_code );

  }
}
