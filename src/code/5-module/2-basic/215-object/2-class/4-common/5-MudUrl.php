<?php

// 2024-06-30 jj5 - TODO: delete this file...

define( 'MUD_URL_FORMAT_ABSOLUTE', 'absolute' );
define( 'MUD_URL_FORMAT_RELATIVE', 'relative' );


class MudUrl extends MudString {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private string|null $scheme;

  private string|null $user;

  private string|null $pass;

  private string|null $host;

  private int|null $port;

  private string|null $path;

  private string|null $query;

  private string|null $fragment;

  private bool $is_valid;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( string|null $url = null ) {

    if ( ! $url ) {

      $url = self::get_full_url();

    }

    parent::__construct( $url );

    $parts = parse_url( $url );

    $this->scheme = $parts[ 'scheme' ] ?? null;
    $this->user = $parts[ 'user' ] ?? null;
    $this->pass = $parts[ 'pass' ] ?? null;
    $this->host = $parts[ 'host' ] ?? null;
    $this->port = $parts[ 'port' ] ?? null;
    $this->path = $parts[ 'path' ] ?? null;
    $this->query = $parts[ 'query' ] ?? null;
    $this->fragment = $parts[ 'fragment' ] ?? null;

    // 2024-06-29 jj5 - it's okay to call is_relative() and format() after the above feilds have been set...

    if ( $this->is_relative() ) {

      $this->is_valid = ( $url === $this->format( 'relative' ) );

    }
    else {

      $this->is_valid = ( $url === $this->format( 'absolute' ) );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public static methods...
  //

  public static function decode( string|null $value ) : string|null {

    if ( $value === null ) { return null; }

    return urldecode( $value );

  }

  public static function get_full_url( string|null $fragment = null ) {

    // 2024-10-21 jj5 - get the protocol (HTTP or HTTPS)...
    //
    $protocol =
      ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' || $_SERVER[ 'SERVER_PORT' ] == 443 ) ?
      "https://" :
      "http://";

    // 2024-10-21 jj5 - get the host (domain name or IP address)...
    //
    $host = $_SERVER[ 'HTTP_HOST' ];

    // 2024-10-21 jj5 - get the path and query string...
    //
    $path_and_query = $_SERVER[ 'REQUEST_URI' ];

    // 2024-10-21 jj5 - combine to get the full URL...
    //
    $full_url = $protocol . $host . $path_and_query;

    if ( $fragment ) {

      if ( $fragment[ 0 ] !== '#' ) {

        $fragment = '#' . $fragment;

      }

      $full_url .= $fragment;

    }

    return $full_url;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public instance methods...
  //

  public function is_relative() {

    if ( $this->scheme ) { return false; }
    if ( $this->user ) { return false; }
    if ( $this->pass ) { return false; }
    if ( $this->host ) { return false; }
    if ( $this->port ) { return false; }

    return true;

  }

  public function is_absolute() {

    return ! $this->is_relative();

  }

  public function is_valid( mixed $options = null ) : bool {

    return $this->is_valid;

  }

  public function get_scheme() : string|null { return $this->scheme; }

  public function get_user() : string|null { return $this->user; }

  public function get_pass() : string|null { return $this->pass; }

  public function get_host() : string|null { return $this->host; }

  public function get_port() : int|null { return $this->port; }

  public function get_path() : string|null { return $this->path; }

  public function get_query() : string|null { return $this->query; }

  public function get_fragment() : string|null { return $this->fragment; }

  public function get_path_decoded() : string|null { return self::decode( $this->path ); }

  public function get_query_decoded() : string|null { return self::decode( $this->query ); }

  public function get_fragment_decoded() : string|null { return self::decode( $this->fragment ); }

  public function format( mixed $spec = null ) : string {

    switch ( $spec ) {

      case MUD_URL_FORMAT_RELATIVE :

        return $this->path .
          ( $this->query ? '?' . $this->query : '' ) .
          ( $this->fragment ? '#' . $this->fragment : '' );

      case MUD_URL_FORMAT_ABSOLUTE :

        return
          ( $this->scheme ? $this->scheme . '://' : '' ) .
          ( $this->user ? $this->user : '' ) .
          ( $this->pass ? ':' . $this->pass : '' ) .
          ( $this->user || $this->pass ? '@' : '' ) .
          ( $this->host ? $this->host : '' ) .
          ( $this->port ? ':' . $this->port : '' ) .
          $this->path .
          ( $this->query !== null ? '?' . $this->query : '' ) .
          ( $this->fragment !== null ? '#' . $this->fragment : '' );

      default :

        if ( $this->is_relative() ) {

          return $this->format( MUD_URL_FORMAT_RELATIVE );

        }

        return $this->format( MUD_URL_FORMAT_ABSOLUTE );

    }
  }
}
