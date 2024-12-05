<?php

class MudModuleUrl extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-28 jj5 - public methods...
  //

  public function get_full_request_url() {

    $protocol =
      ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) || $_SERVER[ 'SERVER_PORT' ] == 443 ) ?
      "https://" :
      "http://";

    $host = $_SERVER[ 'HTTP_HOST' ];

    $requestUri = $_SERVER[ 'REQUEST_URI' ];

    return $protocol . $host . $requestUri;

  }
}
