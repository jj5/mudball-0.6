<?php

// 2022-03-06 jj5 - THINK: this class needs review.


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-20 jj5 - class definition...
//

abstract class MudModuleWebLog extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleWebLog|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-20 jj5 - public functions...
  //

  public function log_web_request() : bool {

    //$this->log_this();

    if ( ! defined( 'HTTP_LOG' ) || ! HTTP_LOG ) { return false; }

    if ( ! bom_is_web() ) { return false; }

    static $logged = false;

    if ( $logged ) { return true; }

    if ( ! defined( 'APP_CODE' ) ) { return false; }

    $logged = true;

    bom_buffer_start();

    $server = [];

    foreach ( $_SERVER as $key => $val ) {

      // 2020-04-15 jj5 - the Subject Alt Names on our certificates are
      // verbose and not interesting so we remove them from our logs...
      //
      if ( strpos( $key, 'SSL_SERVER_SAN_' ) === 0 ) { continue; }

      $server[ $key ] = $val;

    }

    $state = [
      'SERVER'  => $server,
      'ENV'     => $_ENV      ?? null,
      'SESSION' => $_SESSION  ?? null,
      'COOKIE'  => $_COOKIE   ?? null,
      'FILES'   => $_FILES    ?? null,
      'GET'     => $_GET      ?? null,
      'POST'    => $_POST     ?? null,
    ];

    $state = bom_redact_secrets( $state );

    $json = bom_json_encode( $state );

    $hash = md5( $json );

    $log_dir = $this->get_http_log_dir( $hash );

    if ( ! is_dir( $log_dir ) ) { return false; }

    $this->write_file( "$log_dir/request.json", $json );

    $json = bom_json_encode([
      'VERB' => $_SERVER[ 'REQUEST_METHOD' ] ?? null,
      'LINK' => $_SERVER[ 'REQUEST_URI' ] ?? null,
      'INFO' => $_COOKIE,
    ]);

    $this->write_file( "$log_dir/request.info.json", $json, $compress = false );

    return true;

  }

  public function log_web_response() : bool {

    //$this->log_this();

    if ( ! defined( 'HTTP_LOG' ) || ! HTTP_LOG ) { return false; }

    if ( ! bom_is_web() ) { return false; }

    static $logged = false;

    if ( $logged ) { return true; }

    $logged = true;

    if ( headers_sent( $file, $line ) ) {

      if ( DEBUG ) {

        var_dump([
          'note' => 'headers were already sent...',
          'file' => $file,
          'line' => $line,
        ]);

        return bom_exit( BOM_EXIT_DEBUG );

      }
    }
    else {

      header(
        'X-Processing-Time: ' . ( microtime( true ) - APP_START_MICROTIME )
      );

    }

    // 2020-04-16 jj5 - here we flush our output, this is the end of our
    // response. We want the browser to get the response as soon as possible
    // while we finish logging and tidying up (below and in our shutdown
    // handlers)...
    //
    $output = bom_buffer_flush( $length, $return = true );

    // 2020-04-16 jj5 - NOTE: here we make sure the web request has been
    // logged before logging the web response. This is important for a number
    // of reasons, not the least of which is that the HTTP log directory is
    // created in the log_web_request() function...
    //
    $this->log_web_request();

    $log_dir = $this->get_http_log_dir();

    if ( ! is_dir( $log_dir ) ) { return false; }

    $protocol = $_SERVER[ 'SERVER_PROTOCOL' ] ?? 'HTTP/1.0';
    $http_code = http_response_code();
    $http_note = $this->get_http_reason_phrase( $http_code );

    $headers = [ "$protocol $http_code $http_note" ] + headers_list();

    // 2020-04-14 jj5 - we list them as-is, no sorting...
    //sort( $headers );

    $this->write_file(
      "$log_dir/response.headers.txt",
      implode( "\n", $headers ) . "\n",
      $compress = false
    );

    $content_type = $this->get_content_type( $headers );

    // 2020-04-15 jj5 - if we can't determine a valid file extension to use
    // for the output content then we won't log the output content...
    //
    $extension = $this->get_file_extension( $content_type );

    if ( $extension && $output ) {

      $this->write_file( "$log_dir/response.$extension", $output );

    }

    return true;

  }

  public function get_http_reason_phrase( int $http_status_code ) : string {

    // 2020-04-14 jj5 - SEE: RFC 2616:
    // https://www.w3.org/Protocols/rfc2616/rfc2616-sec6.html

    static $http_reason_phrase_map = [
      100 => 'Continue',
      101 => 'Switching Protocols',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      307 => 'Temporary Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Time-out',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Large',
      415 => 'Unsupported Media Type',
      416 => 'Requested range not satisfiable',
      417 => 'Expectation Failed',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Time-out',
      505 => 'HTTP Version not supported',
    ];

    return $http_reason_phrase_map[ $http_status_code ] ?? 'Unusual Response';

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-20 jj5 - protected functions...
  //

  protected function get_content_type( array $headers ) : ?string {

    // 2020-04-16 jj5 - NOTE: for our purposes here with this function we
    // just want the basic content type, without charset or other parameters,
    // those are removed.

    foreach ( $headers as $header ) {

      if ( stripos( $header, 'Content-Type:' ) !== 0 ) { continue; }

      $parts = explode( ':', $header, 2 );

      if ( count( $parts ) !== 2 ) { continue; }

      $content_type = trim( explode( ';', $parts[ 1 ] )[ 0 ] );

      return $content_type;

    }

    return null;

  }

  protected function get_file_extension( string $content_type ) : ?string {

    // 2020-04-16 jj5 - NOTE: in this function only return file extensions
    // for types of data which you want to log. If you don't want to log a
    // particular type of data then return a null extension for it.

    static $extension_map = [
      'text/html'         => 'html',
      'text/plain'        => 'txt',
      'application/json'  => 'json',
    ];

    return $extension_map[ $content_type ] ?? null;

  }

  protected function write_file(
    string $path,
    string $data,
    bool $compress = true
  ) {

    if ( ! $data ) { return; }

    $errors = error_reporting( 0 );

    try {

      for ( $try = 1; $try <= BOM_DEFAULT_TRY_COUNT; $try++ ) {

        if ( @file_put_contents( $path, $data ) ) { break; }

        usleep( BOM_DEFAULT_TRY_DELAY );

      }

      if ( ! $compress ) { return; }

      for ( $try = 1; $try <= BOM_DEFAULT_TRY_COUNT; $try++ ) {

        exec( 'pigz --best ' . escapeshellarg( $path ) );

        if ( ! file_exists( $path ) ) { break; }

        usleep( BOM_DEFAULT_TRY_DELAY );

      }
    }
    finally {

      error_reporting( $errors );

    }
  }

  protected function get_http_log_dir( ?string $hash = null ) {

    static $dir = null;

    if ( $dir === null ) {

      if ( ! defined( 'APP_CODE' ) ) { return null; }

      if ( $hash === null ) { return null; }

      $code = APP_CODE;
      $date = date( 'Y/m/d/H/i-s' );
      $time = number_format(
        microtime( $get_as_float = true ),
        $decimals = 4,
        $dec_point = '.',
        $thousands_sep = ''
      );
      $verb = $_SERVER[ 'REQUEST_METHOD' ] ?? 'UNKNOWN';

      //$dir = "/var/state/$code/http-log/$date-$time-$verb-$hash";

      $base_dir = mud_get_config( [ 'app', 'state', 'dir' ] );

      if ( ! is_dir( $base_dir ) ) {

        return null;

      }

      $dir = "$base_dir/http-log/$date-$time-$verb-$hash";

      bom_retry( function() use ( $dir ) {

        @mkdir( $dir, 0700, $recursive = true );

        return is_dir( $dir );

      });

    }

    return $dir;

  }
}
