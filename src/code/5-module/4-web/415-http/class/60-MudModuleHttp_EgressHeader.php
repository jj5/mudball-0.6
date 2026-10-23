<?php declare(strict_types=1);

class MudModuleHttp_EgressHeader extends MudModuleHttp_IngressValue {

  public function expires( $days_to_cache = 365 ) {

    $expires = strtotime( date( 'Y-m-d', time() ) . " + $days_to_cache day" );

    return gmdate( 'D, d M Y H:i:s', $expires ) . ' GMT';

  }

  public function cache_forever() {

    $expiry_time = strtotime( '+10 years' );
    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', $expiry_time ) . ' GMT' );
    header( 'Cache-Control: max-age=' . ( 10 * 365 * 24 * 60 * 60 ) . ', public' ); // 10 years in seconds
    header( 'Pragma: cache' );

  }

  public function set_response_code( int $code ) {

    http_response_code( $code );

  }

  public function set_header( $key, $val, $replace = true, $http_response_code = null ) {

    if ( $http_response_code !== null ) {

      $this->set_response_code( $http_response_code );

    }

    if ( mud_is_web() ) {

      header( "$key: $val", $replace, $http_response_code );

    }
  }

  public function render_png_headers( $days_to_cache = 365 ) {

    $this->set_header( 'Content-Type', 'image/png' );
    $this->set_header( 'Expires', $this->expires( $days_to_cache ) );

  }

  public function render_gif_headers( $days_to_cache = 365 ) {

    $this->set_header( 'Content-Type', 'image/gif' );
    $this->set_header( 'Expires', $this->expires( $days_to_cache ) );

  }

  public function render_css_headers( $days_to_cache = 365 ) {

    $this->set_header( 'Content-Type', 'text/css; charset=utf-8' );
    $this->set_header( 'Expires', $this->expires( $days_to_cache ) );

  }

  public function unset_redirect( array $arg_list ) {

    $args = $_GET;

    foreach ( $arg_list as $arg ) { unset( $args[ $arg ] ); }

    $this->redirect( null, $args );

  }

  public function redirect(
    $path = null,
    $query = null,
    $base = null,
    $fragment = null,
    $host = null,
    $scheme = null,
    $port = null
  ) {

    $url = $this->get_url( $path, $query, $base, $fragment, $host, $scheme, $port );

    return $this->redirect_url( $url );

  }

  public function redirect_permanent(
    $path = null,
    $query = null,
    $base = null,
    $fragment = null,
    $host = null,
    $scheme = null,
    $port = null
  ) {

    $url = $this->get_url( $path, $query, $base, $fragment, $host, $scheme, $port );

    $this->redirect_url( $url, MUD_HTTP_301_MOVED_PERMANENTLY );

  }

  public function redirect_url( $url, $code = MUD_HTTP_303_SEE_OTHER ) {

    $current_url = $this->get_current_url();

    if ( $this->get_current_verb() === 'GET' && $url === $current_url ) {

      $this->exit_500( "Infinite redirect detected for '$url'." );

    }

    // 2017-02-20 jj5 - SEE: HTTP Redirection Status Codes:
    // https://en.wikipedia.org/wiki/List_of_HTTP_status_codes#3xx_Redirection

    $this->set_header( 'Location', $url, true, $code );

    // 2026-10-24 jj5 - THINK: do we want to exit here?
    //terminate();

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

    $fragment = $fragment ?? '';

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

  function exit_404() : never {

    $this->error_404();

    throw mud_new_http_exception( 404 );

  }

  function error_404() {

    $this->error( 404, 'Not Found' );

  }

  function exit_500( $log, $message = 'Server Error.' ) : never {

    $this->error_500( $log, $message );

    throw mud_new_http_exception( 500 );

  }

  function error_500( $log, $message ) {

    error_log( $log );

    $this->error( 500, 'Internal Server Error', $message );

  }

  function exit_501( $log ) : never {

    $this->error_501( $log );

    throw mud_new_http_exception( 501 );

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

}
