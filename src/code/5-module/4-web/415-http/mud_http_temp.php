<?php


// 2017-02-20 jj5 - TODO: all HTTP status codes should be defined as constants
define( 'HTTP_MOVED_PERMANENTLY', 301 );
define( 'HTTP_FOUND', 302 );
define( 'HTTP_SEE_OTHER', 303 );
define( 'HTTP_TEMPORARY_REDIRECT', 307 );

// 2017-02-20 jj5 - these are default input validation formats...
define( 'SAFE_DEFAULT', '[A-Za-z0-9_-]*' );
define( 'SAFE_DATE', '[0-9]{4}-[0-9]{2}-[0-9]{2}' );
// 2017-02-21 jj5 - DONE: added SAFE_HOST definition
define( 'SAFE_HOST', '[a-z0-9]+[a-z0-9-]*(\.[a-z0-9-]+)*' );

class BomUtilHttp {


  private $headers = [];
  private $response_code = null;

  function request_scheme( $override = null ) {

    static $scheme = null;

    if ( $scheme === null ) { $scheme = $this->read_server( 'REQUEST_SCHEME' ); }

    if ( $override !== null ) { $scheme = $override; }

    return $scheme;

  }

  function post_log() {

    // 2018-05-30 jj5 - THINK: this function is junk, consider removal...

    //$data = implode( ", ", array_keys( $_SERVER ) );
    //error_log( "SERVER: {$data}" );

    error_log( "SCRIPT_FILENAME: {$_SERVER['SCRIPT_FILENAME']}" );

    $cookie = $this->redact( $_COOKIE );

    foreach ( array_keys( $cookie ) as $key ) {

      if ( strpos( $key, '__' ) === 0 ) { unset( $cookie[ $key ] ); }

    }

    $data = urldecode( http_build_query( $cookie ) );

    error_log( "COOKIE: {$data}" );

    $post = $this->redact( $_POST );

    // 2017-02-23 jj5 - DONE: only log POST keys to avoid logging passwords...
    $data = urldecode( http_build_query( array_keys( $post ) ) );

    error_log( "POST: {$data}" );

  }

  function redact( $input ) {

    return redact_secrets( $input );

  }








  function get_next_html( $extra ) {

    return htmlentities( $this->get_next( $extra ), ENT_QUOTES );

  }

  function get_next( $extra ) {

    $args = $_GET;

    foreach ( $extra as $key => $val ) {

      $args[ $key ] = $val;

    }

    return $this->get_link( null, $args );

  }

  function get_link(
    $path = null,
    $query = null,
    $base = null,
    $fragment = null
  ) {

    if ( $path === null ) { $path = $this->get_current_url_path(); }
    if ( $base === null ) { $base = $this->get_current_url_base(); }

    $path = "{$base}{$path}";

    if ( $query === null ) { $query = $_GET; }

    $query = $this->get_url_query( $query );

    if ( $query ) {

      $query_delim = strpos( $path, '?' ) === false ? '?' : '&';

      $query = "{$query_delim}{$query}";

    }

    if ( strlen( $fragment ) ) { $fragment = '#' . ltrim( $fragment, '#' ); }

    return "{$path}{$query}{$fragment}";

  }

  function get_url_attr(
    $path = null,
    $query = null,
    $base = null,
    $fragment = null,
    $host = null,
    $scheme = null,
    $port = null
  ) {

    $url = $this->get_url( $path, $query, $base, $fragment, $host, $scheme, $port );

    return htmlentities( $url, ENT_HTML5, 'UTF-8' );

  }

  function get_url(
    $path = null,
    $query = null,
    $base = null,
    $fragment = null,
    $host = null,
    $scheme = null,
    $port = null
  ) {

    static $ports = [ 'http' => 80, 'https' => 443 ];

    $link = $this->get_link( $path, $query, $base, $fragment );

    if (
      strpos( $link, 'http://' ) === 0 ||
      strpos( $link, 'https://' ) === 0
    ) {

      return $link;

    }

    if ( $host === null ) { $host = $this->get_current_url_host(); }

    if ( $scheme === null ) { $scheme = $this->get_current_url_scheme(); }

    $port = intval( $port );

    if ( $port === 0 ) { $port = $this->get_current_url_port(); }

    assert( array_key_exists( $scheme, $ports ) );

    $port = $port === $ports[ $scheme ] ? '' : ":$port";

    return "{$scheme}://{$host}{$port}{$link}";

  }

  function get_current_verb() {

    return $this->read_server( 'REQUEST_METHOD', 'NA' );

  }

  function get_current_url_scheme() {

    return $this->read_server( 'REQUEST_SCHEME', 'http' );

  }

  function get_current_url_host() {

    return $this->read_server( 'HTTP_HOST', 'localhost' );

  }

  function get_current_url_port() {

    return intval( $this->read_server( 'SERVER_PORT' ) );

  }

  function get_current_url_base() {

    // 2017-05-30 jj5 - DONE: remove 'index.php' from URL when possible...

    $result = $this->read_server( 'SCRIPT_NAME', '/' );

    $index_pos = strlen( $result ) - 10;

    if ( strpos( $result, '/index.php' ) === $index_pos ) {

      $result = substr( $result, 0, $index_pos + 1 );

    }

    return $result;

  }

  function get_current_url_path() {

    return $this->read_server( 'PATH_INFO' );

  }

  function get_path_info() {

    return $this->read_server( 'PATH_INFO' );

  }

  function get_current_url_query() {

    return $this->get_url_query( $_GET );

  }

  function get_current_url() {

    return $this->get_url();

  }

  function get_url_query( &$args = null ) {

    if ( $args === null ) { return ''; }

    if ( is_array( $args ) ) {

      $query = &$args;

    }
    else {

      parse_str( $args, $query );

    }

    return http_build_query( $query );

  }

  function get_req( $name ) {

    $result = $this->get_def( $name );

    if ( $result === null ) { $this->exit_500( "Invalid GET arg '$name'." ); }

    return $result;

  }

  function get_def( $name, $default = null ) {

    return $this->read_array( $name, $_GET, $default );

  }

  function get_safe( $name, $pattern = null, $default = null ) {

    $value = $this->get_def( $name, $default );

    // 2017-02-23 jj5 - THINK: validate the default value too, just to be safe?
    if ( $value === $default ) { return $value; }

    // 2017-02-20 jj5 - THINK: think about a sensible default HTTP query value
    //  format...
    if ( $pattern === null ) { $pattern = SAFE_DEFAULT; }

    // 2017-02-20 jj5 - NOTE: we force the pattern to match the full string,
    //  no exceptions.
    $pattern = "/^$pattern$/";

    if ( preg_match( $pattern, $value ) ) { return $value; }

    $this->unset_redirect( $name );

  }

  function post_req( $name ) {

    $result = $this->post_def( $name );

    if ( $result === null ) { $this->exit_500( "Invalid POST arg '$name'." ); }

    return $result;

  }

  function post_def( $name, $default = null ) {

    return $this->read_array( $name, $_POST, $default );

  }

  function read_server( $name, $default = null ) {

    return $this->read_array( $name, $_SERVER, $default );

  }

  function read_array( $name, array $array, $default = null ) {

    if ( array_key_exists( $name, $array ) ) {

      $result = $array[ $name ];

      //if ( empty( $result ) ) { return $default; }

      return $result;

    }

    return $default;

  }

  function exit_404() {

    $this->error_404();

    terminate();

  }

  function error_404() {

    $this->error( 404, 'Not Found' );

  }

  function exit_500( $log, $message = 'Server Error.' ) {

    $this->error_500( $log, $message );

    terminate();

  }

  function error_500( $log, $message ) {

    error_log( $log );

    $this->error( 500, 'Internal Server Error', $message );

  }

  function exit_501( $log ) {

    $this->error_501( $log );

    terminate();

  }

  function error_501( $log ) {

    error_log( $log );

    $this->error( 501, 'Not Implemented' );

  }

  function error( $code, $name, $message = '' ) {

    while ( ob_get_level() ) { ob_end_clean(); }

    ob_start();

    $protocol = $this->read_server( 'SERVER_PROTOCOL', 'HTTP/1.0' );

    $this->set_response_code( $code );

    $header = "$protocol $code $name";

    header( $header, true, $code );

    // 2018-05-30 jj5 - TODO: handle different web-modes here for 'html',
    // 'snip', 'json', 'png', etc.

    echo $message;

  }

  // 2018-04-25 jj5 - this function is so we don't try to do HTTP operations
  // when we're running in the CLI...
  //
  function is_live() {

    if ( defined( 'STDIN' ) ) { return false; }

    if (
      empty( $_SERVER[ 'REMOTE_ADDR' ] ) &&
      ! isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) &&
      count( $_SERVER[ 'argv' ] ) > 0
    ) {

      return false;

    }

    return true;

  }

  public function get_canonical_ip(
    $input,
    &$IPv4 = null, &$IPv4_int = null, &$IPv4_bin = null,
    &$IPv6 = null, &$IPv6_bin = null
  ) {

    $ip = strtolower( trim( $input ) );

    if ( $ip === '' || $ip === '0.0.0.0' ) {

      $IPv4 = '0.0.0.0';
      $IPv4_int = 0;
      $IPv4_bin = str_repeat( "\0", 4 );

      $IPv6 = '::ffff:0.0.0.0';
      $IPv6_bin = inet_pton( $IPv6 );

      return $ip;

    }

    if ( strpos( $ip, ':' ) !== false ) {

      // 2018-07-20 jj5 - looks like an IPv6 address...
      //
      $IPv4 = null;
      $IPv4_int = null;
      $IPv4_bin = null;

      $IPv6_bin = inet_pton( $ip );
      $IPv6 = inet_ntop( $IPv6_bin );

      return $IPv6;

    }

    // 2018-07-20 jj5 - looks like an IPv4 address...
    //
    $IPv4_int = ip2long( $ip );
    $IPv4 = long2ip( $IPv4_int );
    $IPv4_bin = inet_pton( $IPv4 );

    $IPv6_bin = inet_pton( '::ffff:' . $IPv4 );
    $IPv6 = inet_ntop( $IPv6_bin );

    return $IPv4;

  }

}

function is_get() {

  return http()->is_get();

}

function is_post() {

  return http()->is_post();

}

function is_https() {

  return http()->is_https();

}

function set_client_ip( $ip ) {

  return http()->set_client_ip( $ip );

}

function get_client_ip() {

  return http()->get_client_ip();

}

function get_user_agent() {

  return strval( http_read_server( 'HTTP_USER_AGENT' ) );

}

function is_mobile() {

  return http()->is_mobile();

}

function get_referer() { return get_referrer(); }
function get_referrer() { return http()->get_referrer(); }

function http_post_log() {

  return http()->post_log();

}

function http_redact( $input ) {

  return http()->redact( $input );

}

function set_dom_cookie( $key, $value ) {

  return http()->set_dom_cookie( $key, $value );

}

function set_session_cookie( $key, $value, $http_only = true ) {

  return http()->set_session_cookie( $key, $value, $http_only );

}

function set_browser_cookie( $key, $value, $days = 365, $http_only = true ) {

  return http()->set_browser_cookie( $key, $value, $days, $http_only );

}

function get_cookie( $key, $default = null ) {

  return http()->get_cookie( $key, $default );

}

function delete_all_cookies() {

  return http()->delete_all_cookies();

}

function delete_cookie( $key ) {

  return http()->delete_cookie( $key );

}

function http_expires( $days_to_cache = 365 ) {

  return http()->expires( $days_to_cache );

}

function render_png_headers( $days_to_cache = 365 ) {

  return http()->render_png_headers( $days_to_cache );

}

function render_gif_headers( $days_to_cache = 365 ) {

  return http()->render_gif_headers( $days_to_cache );

}

function render_css_headers( $days_to_cache = 365 ) {

  return http()->render_css_headers( $days_to_cache );

}

function unset_redirect( $arg ) {

  //call_user_func_array( [ http(), 'unset_redirect' ], func_get_args() );

  $arg_count = func_num_args();

  assert( $arg_count === 1 );

  return http()->unset_redirect( $arg );

}

function redirect(
  $path = null,
  $query = null,
  $base = null,
  $fragment = null,
  $host = null,
  $scheme = null,
  $port = null
) {

  return http()->redirect(
    $path,
    $query,
    $base,
    $fragment,
    $host,
    $scheme,
    $port
  );

}

function redirect_permanent(
  $path = null,
  $query = null,
  $base = null,
  $fragment = null,
  $host = null,
  $scheme = null,
  $port = null
) {

  return http()->redirect_permanent(
    $path,
    $query,
    $base,
    $fragment,
    $host,
    $scheme,
    $port
  );

}

function redirect_url( $url, $code = HTTP_SEE_OTHER ) {

  return http()->redirect_url( $url, $code );

}

function get_next_html( $extra ) {

  return http()->get_next_html( $extra );

}

function get_next( $extra ) {

  return http()->get_next( $extra );

}

function get_link(
  $path = null,
  $query = null,
  $base = null,
  $fragment = null
) {

  return http()->get_link( $path, $query, $base, $fragment );

}

function get_url_attr(
  $path = null,
  $query = null,
  $base = null,
  $fragment = null,
  $host = null,
  $scheme = null,
  $port = null
) {

  return http()->get_url_attr(
    $path,
    $query,
    $base,
    $fragment,
    $host,
    $scheme,
    $port
  );

}

function get_url(
  $path = null,
  $query = null,
  $base = null,
  $fragment = null,
  $host = null,
  $scheme = null,
  $port = null
) {

  return http()->get_url(
    $path,
    $query,
    $base,
    $fragment,
    $host,
    $scheme,
    $port
  );

}

function get_current_http_verb() {

  return http()->get_current_verb();

}

function get_current_url_scheme() {

  return http()->get_current_url_scheme();

}

function get_current_url_host() {

  return http()->get_current_url_host();

}

function get_current_url_port() {

  return http()->get_current_url_port();

}

function get_current_url_base() {

  return http()->get_current_url_base();

}

function get_current_url_path() {

  return http()->get_current_url_path();

}

function get_path_info() {

  return http()->get_path_info();

}

function get_current_url_query() {

  return http()->get_current_url_query();

}

function get_current_url() {

  return http()->get_current_url();

}

function get_url_query( $args = null ) {

  return http()->get_url_query( $args );

}

function http_get_req( $name ) {

  return http()->get_req( $name );

}

function http_get_def( $name, $default = null ) {

  return http()->get_def( $name, $default );

}

function http_get_safe( $name, $pattern = null, $default = null ) {

  return http()->get_safe( $name, $pattern, $default );

}

function http_post_req( $name ) {

  return http()->post_req( $name );

}

function http_post_def( $name, $default = null ) {

  return http()->post_def( $name, $default );

}

function http_read_server( $name, $default = null ) {

  return http()->read_server( $name, $default );

}

function http_read_array( $name, array $array, $default = null ) {

  return http()->read_array( $name, $array, $default );

}

function exit_404() {

  return http()->exit_404();

}

function error_404() {

  return http()->error_404();

}

function exit_500( $log, $message = 'Server Error.' ) {

  return http()->exit_500( $log, $message );

}

function error_500( $log, $message ) {

  return http()->error_500( $log, $message );

}

function exit_501( $log ) {

  return http()->exit_501( $log );

}

function error_501( $log ) {

  return http()->error_501( $log );

}

function http_error( $code, $name, $message = '' ) {

  return http()->error( $code, $name, $message );

}

function http_is_live() {

  return http()->is_live();

}

function get_canonical_ip(
  $input,
  &$IPv4 = null, &$IPv4_int = null, &$IPv4_bin = null,
  &$IPv6 = null, &$IPv6_bin = null
) {

  return http()->get_canonical_ip(
    $input,
    $IPv4, $IPv4_int, $IPv4_bin,
    $IPv6, $IPv6_bin
  );

}
