<?php

class MudRequestReader extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-24 jj5 - public methods...
  //

  public function read() {

    self::read_request(
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

    return new_mud_request(
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

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-24 jj5 - protected static methods...
  //

  public static function read_request(
    &$verb,
    &$headers,
    &$http_user_agent,
    &$http_accept,
    &$http_accept_language,
    &$http_accept_encoding,
    &$http_if_modified_since,
    &$http_if_none_match,
    &$scheme,
    &$host,
    &$port,
    &$controller_path,
    &$request_path_parts,
    &$selector,
    &$criteria,
    &$submission,
    &$files,
    &$cookies,
    &$state,
    &$facility
  ) {

    $verb = $_SERVER[ 'REQUEST_METHOD' ];

    $http_user_agent        = $_SERVER[ 'HTTP_USER_AGENT' ]         ?? null;
    $http_accept            = $_SERVER[ 'HTTP_ACCEPT' ]             ?? null;
    $http_accept_language   = $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ]    ?? null;
    $http_accept_encoding   = $_SERVER[ 'HTTP_ACCEPT_ENCODING' ]    ?? null;
    $http_if_modified_since = $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ]  ?? null;
    $http_if_none_match     = $_SERVER[ 'HTTP_IF_NONE_MATCH' ]      ?? null;

    if ( function_exists( 'apache_request_headers' ) ) {

      $headers = apache_request_headers();

    }
    else {

      // 2021-12-08 jj5 - if we're not running on Apache we could either read the 'HTTP_*' keys
      // from the $_SERVER superglobal or maybe just add the ones we know about..?

      mud_not_supported();

    }

    $scheme = ( $_SERVER[ 'HTTPS' ] ?? null ) === 'on' ? 'https' : 'http';

    $host = $_SERVER[ 'HTTP_HOST' ] ?? 'localhost';

    $port = intval( $_SERVER[ 'SERVER_PORT' ] );

    $controller_path = $_SERVER[ 'SCRIPT_NAME' ] ?? '';

    $path_info = $_SERVER[ 'PATH_INFO' ] ?? '';

    $path_info_parts = explode( '/', $path_info );

    $request_path_parts = [];

    foreach ( $path_info_parts as $part ) {

      $part = trim( $part );

      if ( $part ) { $request_path_parts[] = $part; }

    }

    $criteria = $_GET;

    $submission = $_POST;

    $files = $_FILES;

    $cookies = $_COOKIE;

    $state = [
      'POST'    => $_POST     ?? null,
      'GET'     => $_GET      ?? null,
      'HEADERS' => $headers   ?? null,
      'FILES'   => $_FILES    ?? null,
      'COOKIE'  => $_COOKIE   ?? null,
      'ENV'     => $_ENV      ?? null,
      'SESSION' => $_SESSION  ?? null,
      'SERVER'  => $_SERVER   ?? null,
    ];

    //$facility = MudFacility::Find( $request_path_parts, $selector );
    $facility = mud_load_facility( $request_path_parts, $selector );

    if ( ! mud_is_missing( $facility ) ) {

      // 2022-03-20 jj5 - in here we read the "selector" (the part of the URL path after the
      // facility path) and copy it into the "criteria" (the URL query), but only if there's no
      // conflict with the actual criteria as sent.

      foreach ( $facility->get_selector_spec() as $index => $key ) {

        if ( isset( $criteria[ $key ] ) ) { continue; }

        $value = $selector[ $index ] ?? null;

        $criteria[ $key ] = $value;

      }
    }
  }
}
