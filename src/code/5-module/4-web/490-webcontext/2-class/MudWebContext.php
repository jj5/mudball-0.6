<?php

class MudWebContext extends MudGadget implements IMudWebContext {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - protected fields...
  //

  protected $request;
  protected $response;
  protected $view_state;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - constructor...
  //

  public function __construct( $request, $response, $view_state ) {

    $this->request = $request;
    $this->response = $response;
    $this->view_state = $view_state;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - public methods...
  //

  public function get_request() { return $this->request; }
  public function get_response() { return $this->response; }
  public function get_view_state() { return $this->view_state; }
  public function tabindex( $set = false ) { return mud_tab_index( $set ); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudRequest interface
  //

  public function get_verb() { return $this->get_request()->get_verb(); }
  public function is_query() { return $this->get_request()->is_query(); }
  public function is_submission() { return $this->get_request()->is_submission(); }
  public function is_safe() { return $this->get_request()->is_safe(); }
  public function get_headers() { return $this->get_request()->get_headers(); }
  public function get_http_user_agent() { return $this->get_request()->get_http_user_agent(); }
  public function get_http_accept() { return $this->get_request()->get_http_accept(); }
  public function get_http_accept_language() { return $this->get_request()->get_http_accept_language(); }
  public function get_http_accept_encoding() { return $this->get_request()->get_http_accept_encoding(); }
  public function get_http_if_modified_since() { return $this->get_request()->get_http_if_modified_since(); }
  public function get_http_if_none_match() { return $this->get_request()->get_http_if_none_match(); }
  public function get_scheme() { return $this->get_request()->get_scheme(); }
  public function get_host() { return $this->get_request()->get_host(); }
  public function get_port() { return $this->get_request()->get_port(); }
  public function get_controller_path() { return $this->get_request()->get_controller_path(); }
  public function get_controller_url() { return $this->get_request()->get_controller_url(); }
  public function get_request_path_parts() { return $this->get_request()->get_request_path_parts(); }
  public function get_request_path() { return $this->get_request()->get_request_path(); }
  public function get_request_href() { return $this->get_request()->get_request_href(); }
  public function get_request_url() { return $this->get_request()->get_request_url(); }
  public function get_file_name() { return $this->get_request()->get_file_name(); }
  public function get_file_extension() { return $this->get_request()->get_file_extension(); }
  public function get_selector() { return $this->get_request()->get_selector(); }
  public function get_criteria() { return $this->get_request()->get_criteria(); }
  public function get_criterion( $key, $default = null ) { return $this->get_request()->get_criterion( $key, $default ); }
  public function get_submission() { return $this->get_request()->get_submission(); }
  public function get_value( $key, $default = null ) { $this->get_request()->get_value( $key, $default ); }
  public function get_action_code() { return $this->get_request()->get_action_code(); }
  public function get_action_args() { return $this->get_request()->get_action_args(); }
  public function get_files() { return $this->get_request()->get_files(); }
  public function get_cookies() { return $this->get_request()->get_cookies(); }
  public function get_cookie( $name, $default = null ) { return $this->get_request()->get_cookie( $name, $default ); }
  public function get_state() { return $this->get_request()->get_state(); }
  public function get_facility() { return $this->get_request()->get_facility(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudResponse interface...
  //

  public function set_header( $header ) { return $this->get_response()->set_header( $header ); }
  public function add_header( $header ) { return $this->get_response()->add_header( $header ); }
  public function redirect( $location = null ) { return $this->get_response()->redirect( $location ); }
  public function reply_301_moved_permanently( $location ) { return $this->get_response()->reply_301_moved_permanently( $location ); }
  public function reply_303_success( $location ) { return $this->get_response()->reply_303_success( $location ); }
  public function reply_304_not_modified() { return $this->get_response()->reply_304_not_modified(); }
  public function reply_400_bad_request() { return $this->get_response()->reply_400_bad_request(); }
  public function reply_404_not_found() { return $this->get_response()->reply_404_not_found(); }
  public function reply( int $http_status_code, $location = null ) { return $this->get_response()->reply( $http_status_code, $location ); }
  public function has_errors() { return $this->get_response()->has_errors(); }
  public function has_error( string $key, &$error = null ) { return $this->get_response()->has_error( $key, $error ); }
  public function set_error( $key, $problem ) { return $this->get_response()->set_error( $key, $problem ); }
  public function get_errors() { return $this->get_response()->get_errors(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - ArrayAccess interface...
  //

  public function offsetExists( mixed $property ): bool {

    return isset( $this->view_state[ $property ] );

  }

  public function offsetGet( mixed $property ): mixed {

    return $this->view_state[ $property ];

  }

  public function offsetSet( mixed $property, mixed $value ): void {

    $this->view_state[ $property ] = $value;

  }

  public function offsetUnset( mixed $property ): void {

    unset( $this->view_state[ $property ] );

  }
}
