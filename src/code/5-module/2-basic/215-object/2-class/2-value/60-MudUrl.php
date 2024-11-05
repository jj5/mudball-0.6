<?php


define( 'MUD_URL_FORMAT_ABSOLUTE', 'absolute' );
define( 'MUD_URL_FORMAT_RELATIVE', 'relative' );


class MudUrl extends MudString implements IMudUrl {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private IMudUrlScheme $scheme;

  private IMudUrlUser $user;

  private IMudUrlPass $pass;

  private IMudUrlHost $host;

  private IMudUrlPort $port;

  private IMudUrlPath $path;

  private IMudUrlQuery $query;

  private IMudUrlFragment $fragment;

  private bool $is_valid;

  private bool $is_relative;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( string|null $url = null ) {

    if ( ! $url ) {

      $url = self::get_full_url();

    }

    parent::__construct( $url );

    $parts = parse_url( $url );

    $this->scheme = mud_get_url_scheme( $parts[ 'scheme' ] ?? null );
    $this->user = mud_get_url_user( $parts[ 'user' ] ?? null );
    $this->pass = mud_get_url_pass( $parts[ 'pass' ] ?? null );
    $this->host = mud_get_url_host( $parts[ 'host' ] ?? null );
    $this->port = mud_get_url_port( $parts[ 'port' ] ?? null );
    $this->path = mud_get_url_path( $parts[ 'path' ] ?? null );
    $this->query = mud_get_url_query( $parts[ 'query' ] ?? null );
    $this->fragment = mud_get_url_fragment( $parts[ 'fragment' ] ?? null );

    $this->is_relative = $this->calculate_is_relative();

    // 2024-06-29 jj5 - it's okay to call is_relative() and format() after the above feilds have been set...

    if ( $this->is_relative() ) {

      $this->is_valid = ( $url === $this->format( MUD_URL_FORMAT_RELATIVE ) );

    }
    else {

      $this->is_valid = ( $url === $this->format( MUD_URL_FORMAT_ABSOLUTE ) );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-10-21 jj5 - public static methods...
  //

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

    return $this->is_relative;

  }

  public function is_absolute() {

    return ! $this->is_relative();

  }

  public function is_valid( mixed $options = null ) : bool {

    return $this->is_valid;

  }

  public function get_url_scheme() : IMudUrlScheme { return $this->scheme; }

  public function get_url_user() : IMudUrlUser { return $this->user; }

  public function get_url_pass() : IMudUrlPass { return $this->pass; }

  public function get_url_host() : IMudUrlHost { return $this->host; }

  public function get_url_port() : IMudUrlPort { return $this->port; }

  public function get_url_path() : IMudUrlPath { return $this->path; }

  public function get_url_query() : IMudUrlQuery { return $this->query; }

  public function get_url_fragment() : IMudUrlFragment { return $this->fragment; }

  public function format( mixed $spec = null ) : string {

    switch ( $spec ) {

      case MUD_URL_FORMAT_RELATIVE :

        return $this->format_relative();

      case MUD_URL_FORMAT_ABSOLUTE :

        return $this->format_absolute();

      default :

        if ( $this->is_relative() ) {

          return $this->format_relative();

        }

        return $this->format_absolute();

    }
  }

  public function format_relative() : string {

    return $this->path .
      ( $this->query ? '?' . $this->query : '' ) .
      ( $this->fragment ? '#' . $this->fragment : '' );

  }

  public function format_absolute() : string {

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

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - protected instance methods...
  //

  protected function calculate_is_relative() {

    if ( $this->scheme->is_valid() ) { return false; }
    if ( $this->user->is_valid() ) { return false; }
    if ( $this->pass->is_valid() ) { return false; }
    if ( $this->host->is_valid() ) { return false; }
    if ( $this->port->is_valid() ) { return false; }

    return true;

  }
}
