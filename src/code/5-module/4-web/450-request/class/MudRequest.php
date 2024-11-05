<?php

class MudRequest extends MudService implements IMudRequest {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-24 jj5 - fields...
  //

  protected $verb;
  protected $is_query;
  protected $headers;
  protected $http_user_agent;
  protected $http_accept;
  protected $http_accept_language;
  protected $http_accept_encoding;
  protected $http_if_modified_since;
  protected $http_if_none_match;
  protected $scheme;
  protected $host;
  protected $port;
  protected $controller_path;
  protected $controller_url;
  protected $request_path_parts;
  protected $request_path;
  protected $request_href;
  protected $request_url;
  protected $file_name;
  protected $file_extension;
  protected $selector;
  protected $criteria;
  protected $submission;
  protected $action_code;
  protected $action_args;
  protected $files;
  protected $cookies;
  protected $state;
  protected $facility;

  /*
  protected $response;
  protected $facility;

  protected $errors = [];
  protected $context = null;
  protected $view_state = null;
  */


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudRequest|null $previous = null ) {

    parent::__construct( $previous );

    $request_reader = new_mud_request_reader();

    $request_reader->read_request(
      $verb,
      $headers,
      $http_user_agent,
      $http_accept,
      $http_accept_language,
      $http_accept_encoding,
      $http_if_modified_since,
      $http_if_none_match,
      $scheme,
      $host,
      $port,
      $controller_path,
      $request_path_parts,
      $selector,
      $criteria,
      $submission,
      $files,
      $cookies,
      $state,
      $facility
    );

    static $query_verb_list = [ 'GET', 'HEAD' ];

    $this->verb = $verb;
    $this->is_query = in_array( $verb, $query_verb_list, $strict = true );

    $this->headers = $headers;

    $this->http_user_agent = $http_user_agent;
    $this->http_accept = $http_accept;
    $this->http_accept_language = $http_accept_language;
    $this->http_accept_encoding = $http_accept_encoding;
    $this->http_if_modified_since = $http_if_modified_since;
    $this->http_if_none_match = $http_if_none_match;

    $this->scheme = $scheme;
    $this->host = $host;
    $this->port = $port;
    $this->controller_path = $controller_path;
    $this->request_path_parts = $request_path_parts;
    $this->selector = $selector;

    $this->file_name = null;
    $this->file_extension = null;

    if ( $request_path_parts ) {

      $this->file_name = $request_path_parts[ count( $request_path_parts ) - 1 ];

      $file_name_parts = explode( '.', $this->file_name );

      if ( count( $file_name_parts ) > 1 ) {

        $this->file_extension = $file_name_parts[ count( $file_name_parts ) - 1 ];

      }
    }

    $this->criteria = $criteria;
    $this->submission = $submission;

    $action = $submission[ 'action' ] ?? null;

    if ( $action ) {

      MudAction::Parse( $action, $action_code, $action_args );

    }
    else {

      $action_code = null;
      $action_args = [];

    }

    $this->action_code = $action_code;
    $this->action_args = $action_args;

    $this->files = $files;
    $this->cookies = $cookies;
    $this->state = $state;

    if ( $scheme === 'https' && $port === 443 ) {

      $port = '';

    }
    else if ( $scheme === 'http' && $port === 80 ) {

      $port = '';

    }
    else {

      $port = ":$port";

    }

    $this->controller_url = "{$scheme}://{$host}{$port}{$controller_path}";

    $this->request_path = implode( '/', $request_path_parts );

    $request_href = $this->controller_path;
    $request_url = $this->controller_url;

    if ( $this->request_path ) {

      $path = '/' . $this->request_path;

      $request_href .= $path;
      $request_url .= $path;

    }

    if ( $this->criteria ) {

      $query = '?' . http_build_query( $this->criteria );

      $request_href .= $query;
      $request_url .= $query;

    }

    $this->request_href = $request_href;
    $this->request_url = $request_url;

    $this->facility = $facility;

  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [
      'class' => get_class( $this ),
      'verb' => $this->verb,
      'headers' => $this->headers,
      'scheme' => $this->scheme,
      'host' => $this->host,
      'port' => $this->port,
      'controller_path' => $this->controller_path,
      'controller_url' => $this->controller_url,
      'request_path_parts' => $this->request_path_parts,
      'request_path' => $this->request_path,
      'request_href' => $this->request_href,
      'request_url' => $this->request_url,
      'file_name' => $this->file_name,
      'file_extension' => $this->file_extension,
      'selector' => $this->selector,
      'criteria' => $this->criteria,
      'submission' => mud_redact_secrets( $this->submission ),
      'action_code' => $this->action_code,
      'action_args' => $this->action_args,
      'files' => $this->files,
      'cookies' => $this->cookies,
      //'errors' => $this->errors,
      //'context' => $this->context,
      //'view_state' => $this->view_state,
      'state' => mud_redact_secrets( $this->state ),
    ];

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-24 jj5 - constructor...
  //
  /*
  public function __construct(
    string $verb,
    array $headers,
    ?string $http_user_agent,
    ?string $http_accept,
    ?string $http_accept_language,
    ?string $http_accept_encoding,
    ?string $http_if_modified_since,
    ?string $http_if_none_match,
    string $scheme,
    string $host,
    int $port,
    string $controller_path,
    array $request_path_parts,
    ?array $selector,
    array $criteria,
    array $submission,
    array $files,
    array $cookies,
    array $state,
    $facility,
  ) {

    static $query_verb_list = [ 'GET', 'HEAD' ];

    parent::__construct( APP_SERVICE_REQUEST );

    $this->verb = $verb;
    $this->is_query = in_array( $verb, $query_verb_list, $strict = true );

    $this->headers = $headers;

    $this->http_user_agent = $http_user_agent;
    $this->http_accept = $http_accept;
    $this->http_accept_language = $http_accept_language;
    $this->http_accept_encoding = $http_accept_encoding;
    $this->http_if_modified_since = $http_if_modified_since;
    $this->http_if_none_match = $http_if_none_match;

    $this->scheme = $scheme;
    $this->host = $host;
    $this->port = $port;
    $this->controller_path = $controller_path;
    $this->request_path_parts = $request_path_parts;
    $this->selector = $selector;

    $this->file_name = null;
    $this->file_extension = null;

    if ( $request_path_parts ) {

      $this->file_name = $request_path_parts[ count( $request_path_parts ) - 1 ];

      $file_name_parts = explode( '.', $this->file_name );

      if ( count( $file_name_parts ) > 1 ) {

        $this->file_extension = $file_name_parts[ count( $file_name_parts ) - 1 ];

      }
    }

    $this->criteria = $criteria;
    $this->submission = $submission;

    $action = $submission[ 'action' ] ?? null;

    if ( $action ) {

      MudAction::Parse( $action, $action_code, $action_args );

    }
    else {

      $action_code = null;
      $action_args = [];

    }

    $this->action_code = $action_code;
    $this->action_args = $action_args;

    $this->files = $files;
    $this->cookies = $cookies;
    $this->state = $state;

    if ( $scheme === 'https' && $port === 443 ) {

      $port = '';

    }
    else if ( $scheme === 'http' && $port === 80 ) {

      $port = '';

    }
    else {

      $port = ":$port";

    }

    $this->controller_url = "{$scheme}://{$host}{$port}{$controller_path}";

    $this->request_path = implode( '/', $request_path_parts );

    $request_href = $this->controller_path;
    $request_url = $this->controller_url;

    if ( $this->request_path ) {

      $path = '/' . $this->request_path;

      $request_href .= $path;
      $request_url .= $path;

    }

    if ( $this->criteria ) {

      $query = '?' . http_build_query( $this->criteria );

      $request_href .= $query;
      $request_url .= $query;

    }

    $this->request_href = $request_href;
    $this->request_url = $request_url;

    $this->facility = $facility;

  }
  */


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-08 jj5 - IMudRequest interface
  //

  public function get_verb() { return $this->verb; }

  public function is_query() { return $this->is_query; }
  public function is_submission() { return ! $this->is_query; }
  public function is_safe() { return $this->is_query; }

  public function get_headers() { return $this->headers; }
  public function get_http_user_agent() { return $this->http_user_agent; }
  public function get_http_accept() { return $this->http_accept; }
  public function get_http_accept_language() { return $this->http_accept_language; }
  public function get_http_accept_encoding() { return $this->http_accept_encoding; }
  public function get_http_if_modified_since() { return $this->http_if_modified_since; }
  public function get_http_if_none_match() { return $this->http_if_none_match; }
  public function get_scheme() { return $this->scheme; }
  public function get_host() { return $this->host; }
  public function get_port() { return $this->port; }
  public function get_controller_path() { return $this->controller_path; }
  public function get_controller_url() { return $this->controller_url; }
  public function get_request_path_parts() { return $this->request_path_parts; }
  public function get_request_path() { return $this->request_path; }
  public function get_request_href() { return $this->request_href; }
  public function get_request_url() { return $this->request_url; }
  public function get_file_name() { return $this->file_name; }
  public function get_file_extension() { return $this->file_extension; }

  public function get_selector() { return $this->selector; }
  //public function set_selector( $selector ) { $this->selector = $selector; return $this; }

  //public function set_criteria( array $criteria ) { $this->criteria = $criteria; return $this; }
  public function get_criteria() { return $this->criteria; }

  public function get_criterion( $key, $default = null ) { return $this->criteria[ $key ] ?? $default; }

  public function get_submission() { return $this->submission; }

  public function get_value( $key, $default = null ) { return $this->submission[ $key ] ?? $default; }

  public function get_action_code() { return $this->action_code; }
  public function get_action_args() { return $this->action_args; }
  public function get_files() { return $this->files; }

  public function get_cookies() { return $this->cookies; }

  public function get_cookie( $name, $default = null ) {

    $cookie_prefix = mud_get_config( [ 'app', 'cookie', 'prefix' ], '' );

    $cookie = "{$cookie_prefix}{$name}";

    return $this->get_cookies()[ $cookie ] ?? $default;

  }

  public function get_state() { return $this->state; }
  //public function get_response() { return $this->response; }
  //public function get_facility() { return $this->facility; }

  //public function set_context( $context ) { $this->context = $context; return $this; }
  //public function get_context() { return $this->context; }

  //public function set_view_state( $view_state ) { $this->view_state = $view_state; return $this; }
  /*
  public function get_view_state() {

    // 2022-03-20 jj5 - THINK: I need to think harder about this, is it a potential security
    // problem to include URL components?
    //
    if ( $this->view_state === null ) {

      $this->view_state = $this->submission + $this->criteria;

    }

    return $this->view_state;

  }
  */

  /*
  public function get_value( string $spec, $default = null ) {

    return $this->get_view_state()[ $this->get_key( $spec ) ] ?? $default;

  }

  public function has_errors() {

    return count( $this->errors ) !== 0;

  }

  public function has_error( string $spec, &$error = null ) {

    $error = null;

    $key = $this->get_key( $spec );

    if ( ! array_key_exists( $key, $this->errors ) ) { return false; }

    $error = $this->errors[ $key ];

    return true;

  }

  public function set_error( $spec, $problem ) {

    $key = $this->get_key( $spec );

    $error = $this->errors[ $key ] = $problem;

    return $this;

  }

  public function get_errors() { return $this->errors; }

  public function tabindex( $set = false ) {

    return mud_tab_index( $set );

  }

  public function redirect( $location ) { return $this->response->redirect( $location ); }
  */

  public function get_facility() { return $this->facility; }

}
