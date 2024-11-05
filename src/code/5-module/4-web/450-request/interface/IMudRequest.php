<?php

interface IMudRequest extends IMudSubmission {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudRequest interface
  //

  public function get_verb();

  public function is_query();
  public function is_submission();
  public function is_safe();

  public function get_headers();
  public function get_http_user_agent();
  public function get_http_accept();
  public function get_http_accept_language();
  public function get_http_accept_encoding();
  public function get_http_if_modified_since();
  public function get_http_if_none_match();
  public function get_scheme();
  public function get_host();
  public function get_port();
  public function get_controller_path();
  public function get_controller_url();
  public function get_request_path_parts();
  public function get_request_path();
  public function get_request_href();
  public function get_request_url();
  public function get_file_name();
  public function get_file_extension();

  public function get_selector();

  public function get_files();

  public function get_cookies();

  public function get_cookie( $name, $default = null );

  public function get_state();

  public function get_facility();

}
