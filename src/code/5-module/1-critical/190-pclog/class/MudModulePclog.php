<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModulePclog extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fields...
  //

  protected $date = null;
  protected $date_utc = null;

  // 2019-11-10 jj5 - default output type is textual...
  //
  protected $output_type = MUD_PCLOG_OUTPUT_TEXT;

  protected $user = null;
  protected $host = null;
  protected $rqid = null;
  protected $file = '';

  protected $final = false;

  protected $last_exception = null;
  protected $last_report = null;
  protected $last_issue = null;

  protected $exception_log_count = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public static functions...
  //

  public static function DefaultApi() {

    static $api = null;

    static $ports = [ 'http' => 80, 'https' => 443 ];

    if ( $api === null ) {

      $scheme = $_SERVER[ 'REQUEST_SCHEME' ] ?? 'https';
      $host = $_SERVER[ 'HTTP_HOST' ] ?? trim( `hostname -f` );
      $port = intval( $_SERVER[ 'SERVER_PORT' ] ?? 443 );
      $path = '/log/api';

      $port = ( $port === $ports[ $scheme ] ) ? '' : ":$port";

      $api = "{$scheme}://{$host}{$port}{$path}";

    }

    return $api;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  public function get_final() { return $this->final; }

  public function get_last_exception() { return $this->last_exception; }

  public function handle_error(
    $severity,
    $message,
    $file,
    $line,
    $context = null
  ) {

    // 2019-08-05 jj5 - if error reporting is disabled don't throw...
    //
    if ( error_reporting() === 0 ) { return; }

    throw new ErrorException( $message, 0, $severity, $file, $line );

  }

  public function handle_exception( $ex ) {

    //mud_dump( $ex->data ); exit;

    $this->log_exception( $ex, MudExceptionKind::UNHANDLED, $report, $issue );

    $this->write_report( 'exception', $report );

    $this->complete(
      'Error while processing.',
      MUD_PCLOG_FORM_EXCEPTION,
      $issue,
      MUD_EXIT_EXCEPTION,
      $ex
    );

  }

  public function handle_assertion_violation(
    $file,
    $line,
    $assertion,
    $description = null
  ) {

    $this->final = true;

    $this->log_assertion_violation(
      $file,
      $line,
      $assertion,
      $description,
      $report,
      $issue
    );

    $this->write_report( 'assertion', $report );

    $this->complete(
      'Assertion violated.',
      MUD_PCLOG_FORM_ASSERT,
      $issue,
      MUD_EXIT_ASSERT,
    );

  }

  public function handle_shutdown() {

    //mud_log_this();

    $error = error_get_last();

    if ( $error && E_ERROR === $error[ 'type' ] ?? null ) {

      // 2022-11-09 jj5 - a fatal error has occured...

      //while ( ob_get_level() ) { ob_end_clean(); }

      //var_dump( $error ); exit;


    }

    mud_log_web_response();

    // 2020-03-21 jj5 - if we've already handled a final error situation we
    // don't log a HTTP error to go with it...
    //
    if ( $this->final ) { return; }

    // 2019-11-10 jj5 - this shutdown function is only registered for
    // web applications (not console apps) so we should always be able to find
    // a HTTP response code...

    // 2019-11-10 jj5 - if we've already completed in an exception or assertion
    // handler, or if we have explicitly exited, then there is no more to do...
    //
    if ( mud_get_exit_error_level() !== null ) { return; }

    $code = http_response_code();

    if ( $code < 400 ) { return; }

    $this->log_http_error( $code );

  }

  // 2020-04-16 jj5 - this function moved to logging library in 0-log.php...
  //
  public function redact_secrets(
    $input,
    array $whitelist = [],
    array $blacklist = []
  ) {

    return mud_redact_secrets( $input, $whitelist, $blacklist );

  }

  public function set_output_type( $output_type ) {

    $this->output_type = $output_type;

  }

  public function get_output_type() {

    if ( mud_is_web() ) {

      // 2019-11-10 jj5 - we check the HTTP Accept header to determine an
      // appropriate output type...

      $accept_list = [
        MUD_PCLOG_OUTPUT_HTML,
        MUD_PCLOG_OUTPUT_JSON,
        MUD_PCLOG_OUTPUT_TEXT,
      ];

      $accept_header =
        array_map( 'trim', explode( ',', $_SERVER[ 'HTTP_ACCEPT' ] ?? '' ) );

      foreach ( $accept_header as $accept_type ) {

        if ( in_array( $accept_type, $accept_list ) ) {

          $this->set_output_type( $accept_type );

          break;

        }
      }

      // 2019-11-10 jj5 - we only handle shutdown for web apps, so we can
      // check for 4xx or 5xx errors generated by the application...
      //
      //register_shutdown_function( [ $this, 'handle_shutdown' ] );

    }

    return $this->output_type;

  }

  public function set_user( $user ) {

    $this->user = $user;

  }

  public function get_user() {

    if ( $this->user ) { return $this->user; }

    $this->user = $_SERVER[ 'PHP_AUTH_USER' ] ?? null;

    if ( $this->user ) { return $this->user; }

    if ( mud_is_cli() ) {

      $this->user = getenv( 'USER' );

    }

    if ( $this->user ) { return $this->user; }

    $this->user = get_current_user();

    return $this->user;

  }

  public function set_host( $host ) {

    $this->host = $host;

  }

  public function get_host() {

    if ( $this->host ) { return $this->host; }

    $this->host = $_SERVER[ 'HTTP_HOST' ] ?? trim( `hostname -f` );

    return $this->host;

  }

  public function get_prog() {

    return $_SERVER[ 'SCRIPT_FILENAME' ];

  }

  public function set_rqid( $rqid ) {

    $this->rqid = $rqid;

  }

  public function get_rqid() {

    return $this->rqid;

  }

  public function get_file() : string {

    return $this->file;

  }

  public function render_scripts() {

    if ( ! defined( 'MUD_PCLOG_API' ) ) { return false; }

    // 2017-06-06 jj5 - if you didn't define these before calling this function
    // then you're shit out of luck.
    //
    if ( ! defined( 'DEBUG' ) ) { define( 'DEBUG', false ); }
    if ( ! defined( 'BETA' ) ) { define( 'BETA', false ); }
    if ( ! defined( 'TEST' ) ) { define( 'TEST', false ); }
    if ( ! defined( 'DEV' ) ) { define( 'DEV', false ); }

    // 2017-06-06 jj5 - we can't hash any more, so force daily refresh...
    //$hash = mud_hash_hex( __DIR__ . '/browser.js' );
    $date = date( 'Y-m-d' );

    $app_name = $this->read_const( 'APP_NAME' );
    $app_code = $this->read_const( 'APP_CODE' );
    $app_slug = $this->read_const( 'APP_SLUG' );

    $app_name = $this->json_encode( $app_name );
    $app_code = $this->json_encode( $app_code );
    $app_slug = $this->json_encode( $app_slug );

    $debug = $this->json_encode( DEBUG );
    $test = $this->json_encode( TEST );
    $beta = $this->json_encode( BETA );
    $dev = $this->json_encode( DEV );

    $script = "
      var APP_NAME = $app_name;
      var APP_CODE = $app_code;
      var APP_SLUG = $app_slug;
      var DEBUG = $debug;
      var TEST = $test;
      var BETA = $beta;
      var DEV = $dev;";

    $nip = doc_open() ? false : true;

    if ( $nip ) { nip_init(); }

      tag_open( 'script' );
        out_html( $script );
      tag_shut( 'script' );

      tag_open(
        'script',
        [ 'src' => MUD_PCLOG_API . '/script/browser.js?v=' . $date ]
      );
      tag_shut( 'script' );

    if ( $nip ) { nip_echo(); }

    return true;

  }

  public function log_exception( Throwable $ex, MudExceptionKind $kind, &$report = null, &$issue = null ) {

    if ( DEBUG ) {

      try {

        $file = $ex->getFile();
        $line = $ex->getLine();
        $mesg = $ex->getMessage();

        mud_log_try_warn( "pclog: logging exception: $file:$line: $mesg" );

      }
      catch ( Throwable $ignore ) { ; }

    }

    $level = mud_module_log()->settings[ $kind->value ][ 'level' ];
    $final = mud_module_log()->settings[ $kind->value ][ 'final' ];

    if ( $final ) {

      assert( $this->final === false );

      if ( $this->final ) { return false; }

      $this->final = true;

    }
    else {

      if ( $this->exception_log_count >= 10 ) {

        mud_log_try_warn( 'pclog has logged too many exceptions.' );

        return false;

      }
    }

    $this->exception_log_count++;

    try {

      $report = null;
      $issue = null;
      $status = $kind->name;

      $form = MUD_PCLOG_FORM_EXCEPTION;

      $state = $this->read_exception( $ex, $status );

      $report = $this->report_exception( $ex, strtoupper( $status ) );

      $issue = $this->log(
        $form,
        'exception',
        $state,
        $report,
        $level
      );

      $this->last_exception = $ex;
      $this->last_report = $report;
      $this->last_issue = $issue;

      if ( function_exists( 'mud_interaction' ) ) {

        try {

          // 2024-10-21 jj5 - TODO: put this back in...

          //mud_interaction()->log_fail( $issue );

        }
        catch ( Throwable $ignore ) { ; }

      }

      return true;

    }
    catch ( Throwable $ignore ) {

      mud_log_try_warn( 'pclog: error logging exception: ' . $ignore->getMessage() );

      return false;

    }

    return false;

  }

  public function log_custom(
    string $form,
    string $message,
    $context = null,
    $trace = null
  ) {

    try {

      $report = null;
      $issue = null;

      if ( $trace === null ) { $trace = debug_backtrace(); }

      $context = $this->redact_secrets( $context );
      $trace = $this->redact_secrets( $trace );

      $file = $trace[ 1 ][ 'file' ];
      $line = $trace[ 1 ][ 'line' ];

      $state = [
        'file' => $file,
        'line' => $line,
        'message' => $message,
        'context' => $context,
        'trace' => $trace
      ];

      $report = $this->report_custom( $form, $message, $file, $line, $context );

      $issue = $this->log( $form, 'state', $state, $report );

      return true;

    }
    catch ( Throwable $ex ) {

      try {

        mud_log_try_warn( 'pclog: error logging custom log: ' . $ex->getMessage() );

        mud_log_exception_ignored( $ex );

      }
      catch ( Throwable $ignore ) {

        if ( mud_is_set( 'DEBUG' ) ) {

          mud_log_exception_ignored( $ignore );

        }
      }
    }

    return false;

  }

  public function report_exception( $ex, $status = 'UNHANDLED' ) {

    $status = $status ? "$status " : '';
    $date = ' ' . date( 'r' );
    $host = ' ' . gethostname();
    $type = ' ' . get_class( $ex );
    $name = ' N/A';

    $file = $this->pad_left( $ex->getFile() );
    $line = $this->pad_left( $ex->getLine() );
    $code = $this->pad_left( $ex->getCode() );
    $text = $this->pad_left( $this->indent_rest( $ex->getMessage() ) );

    $trace = $this->format_backtrace( $ex );

    $state = '';

    if ( is_a( $ex, 'MudException' ) ) {

      if ( $ex->getName() !== 'MudException' ) {

        $name = $this->pad_left( $ex->getName() );

      }

      $state = $this->format_data( $ex->getData() );

    }
    else if ( isset( $ex->data ) ) {

      $state = $this->format_data( $ex->data );

    }

    $handler = $this->format_backtrace( debug_backtrace() );

    $output = "

{$status}EXCEPTION:\n
    Date...........:$date
    Host...........:$host
    Type...........:$type
    Name...........:$name
    File...........:$file
    Line...........:$line
    Code...........:$code
    Text...........:$text

$trace
$state

HANDLED BY:

$handler
";

    $previous = $ex->getPrevious();

    if ( $previous ) {

      $output .= $this->report_exception( $previous, 'PREVIOUS' );

    }

    return $output;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - protected functions...
  //

  protected function log_assertion_violation(
    $file,
    $line,
    $assertion,
    $description = null,
    &$report = null,
    &$issue = null
  ) {

    try {

      $report = null;
      $issue = null;

      $form = MUD_PCLOG_FORM_ASSERT;

      $trace = debug_backtrace();

      $state = [
        'file' => $file,
        'line' => $line,
        'assertion' => $assertion,
        'description' => $description,
        'trace' => $trace
      ];

      $report = $this->report_assertion_violation(
        $file,
        $line,
        $assertion,
        $description
      );

      $issue = $this->log( $form, 'assertion', $state, $report );

      return true;

    }
    catch ( Throwable $ex ) {

      try {

        mud_log_try_warn( 'pclog: error logging assertion: ' . $ex->getMessage() );

        mud_log_exception_ignored( $ex );

      }
      catch ( Throwable $ignore ) {

        if ( mud_is_set( 'DEBUG' ) ) {

          mud_log_exception_ignored( $ignore );

        }
      }
    }

    return false;

  }

  protected function report_custom(
    $form,
    $message,
    $file,
    $line,
    $context = null
  ) {

    $date = ' ' . date( 'r' );
    $host = ' ' . gethostname();
    $message = $this->pad_left( $message );
    $file = $this->pad_left( $file );
    $line = $this->pad_left( $line );
    $state = $this->format_data( $context );
    $trace = $this->format_backtrace();

    $output = "

  WARNING:\n
    Date...........:$date
    Host...........:$host
    Message........:$message
    File...........:$file
    Line...........:$line

$trace
$state
";

    return $output;

  }

  protected function report_assertion_violation(
    $file,
    $line,
    $assertion,
    $description = null
  ) {

    $date = ' ' . date( 'r' );
    $host = ' ' . gethostname();
    $file = $file ? " $file" : '';
    $line = $line ? " $line" : '';
    $assertion = $assertion ? " $assertion" : '';
    $description = $description ? " $description" : '';

    $trace = $this->format_backtrace();

    $output = "

  ASSERTION FAILED:\n
    Date...........:$date
    Host...........:$host
    File...........:$file
    Line...........:$line
    Assertion......:$assertion
    Description....:$description

$trace
";

    return $output;

  }

  protected function get_date() {

    if ( $this->date === null ) { $this->date = new DateTime(); }

    return $this->date;

  }

  protected function get_date_utc() {

    if ( $this->date_utc === null ) {

      $utc = clone $this->get_date();

      $utc->setTimezone( new DateTimeZone( 'UTC' ) );

      $this->date_utc = $utc;

    }

    return $this->date_utc;

  }

  protected function get_addr() {

    $xff = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ?? null;

    if ( $xff ) {

      $xff = explode( ',', $xff );

      return trim( $xff[ 0 ] );

    }

    return $_SERVER[ 'REMOTE_ADDR' ] ?? null;

  }

  protected function get_agnt() {

    return $_SERVER[ 'HTTP_USER_AGENT' ] ?? null;

  }

  protected function get_this() {
    static $ports = [ 'http' => 80, 'https' => 443 ];
    $s = $_SERVER;
    $available =
      isset( $s[ 'REQUEST_SCHEME' ] ) &&
      ( isset( $s[ 'HTTP_HOST' ] ) || isset( $s['SERVER_NAME'] ) ) &&
      isset( $s[ 'SERVER_PORT' ] ) && ( intval( $s[ 'SERVER_PORT' ] ) > 0 ) &&
      isset( $s[ 'REQUEST_URI' ] );
    if ( ! $available ) { return null; }
    $scheme = $s[ 'REQUEST_SCHEME' ];
    $host =
      isset( $s[ 'HTTP_HOST' ] ) ? $s[ 'HTTP_HOST' ] : $s[ 'SERVER_NAME' ];
    $port = intval( $s[ 'SERVER_PORT' ] );
    $port = ( $port === $ports[ $scheme ] ) ? '' : ":$port";
    return $scheme . '://' . $host . $port . $s[ 'REQUEST_URI' ];
  }

  protected function get_from() {
    return $_SERVER[ 'HTTP_REFERER' ] ?? null;
  }

  protected function get_thru() {
    return $_SERVER[ 'HTTP_X_FORWARDED_HOST' ] ?? null;
  }

  protected function format_data( $input, $pad = null ) {

    $state = '';

    if ( $input === null ) { return $state; }

    $data = $this->redact_secrets( $input );

    if ( $pad === null ) {

      $pad = 11;

      if ( is_array( $data ) ) {

        foreach ( $data as $key => $value ) {

          $pad = max( $pad, strlen( $key ) );

        }
      }

      $pad += 2;

    }

    // 2018-05-30 jj5 - let's not be silly now...
    //
    if ( $pad > 37 ) { $pad = 37; }

    $state .= '    ' . str_pad( 'Data', $pad + 2, '.', STR_PAD_RIGHT ) . ":";

    if ( is_array( $data ) ) {

      $state .= "\n";

      foreach ( $data as $key => $value ) {

        $formatted = '';

        try {

          if ( is_string( $value ) ) {

            $formatted = $value;

          }
          else {

            $formatted = $this->json_encode( $value );

          }
        }
        catch ( Exception $inner_ex ) {

          // 2016-12-17 jj5 - hey, we tried.

          $formatted = '** ' . $ex->getMessage() . ' **';

        }

        $formatted = $this->indent_rest( $formatted, 6 );

        if ( strpos( $formatted, "\n" ) && $formatted[ 0 ] !== '{' ) {

          $lines = explode( "\n", $formatted );

          // 2019-07-16 jj5 - we just futz about here to make SQL reports
          // look halfway decent...

          if ( count( $lines ) >= 2 ) {

            preg_match( '/\s*/', $lines[ 1 ], $matches );

            $len = strlen( $matches[ 0 ] ) - 2;

            $state .= '      ' . str_pad( $key, $pad, '.', STR_PAD_RIGHT ) . ":\n";
            $state .= str_repeat( ' ', $len ) . $formatted . "\n";

          }
          else {

            $state .= '      ' . str_pad( $key, $pad, '.', STR_PAD_RIGHT ) . ":\n";
            $state .= '      ' . $formatted . "\n";

          }
        }
        else {

          $formatted = $this->pad_left( $formatted );

          $state .= '      ' . str_pad( $key, $pad, '.', STR_PAD_RIGHT ) . ':' .
            $formatted . "\n";

        }
      }
    }
    else {

      $state .= $this->pad_left( strval( $data ) );

    }

    return $state;

  }

  protected function format_backtrace( $input = null ) {

    if ( $input === null ) { $input = debug_backtrace(); }

    $result = '';

    if ( is_object( $input ) ) {

      $trace = $input->getTrace();

    }
    else {

      $trace = $input;

    }

    $trace = $this->redact_secrets( $trace );

    if ( $trace === null ) { $trace = []; }

    assert( is_array( $trace ), '$trace is array.' );

    foreach ( $trace as $index => $position ) {

      $index = str_pad( "#$index", 4 );
      $function = '';

      if ( array_key_exists( 'class', $position ) ) {

        $function = "{$position[ 'class' ]}::";

      }

      if ( array_key_exists( 'function', $position ) ) {

        $function .= "{$position[ 'function' ]}()";

      }
      else {

        $function .= "**UNKNOWN**";

      }

      $location = '';

      if ( array_key_exists( 'file', $position ) ) {

        $location .= $position[ 'file' ];

      }

      if ( array_key_exists( 'line', $position ) ) {

        $location .= ":{$position[ 'line' ]}";

      }

      if ( $location ) {

        $location = " called at [$location]";

      }

      $result .= "{$index}{$function}{$location}\n";

    }

    if ( ! $result ) { return "No trace.\n"; }

    return $result;

  }

  protected function pad_left( $value, $pad = ' ' ) {

    $string = strval( $value );

    if ( strlen( $string ) === 0 ) { return ''; }

    return $pad . $string;

  }

  protected function indent_rest( $input, $length = 4, $char = ' ' ) {

    $lines = explode( "\n", trim( $input ) );

    $result = [ $lines[ 0 ] ];
    $indent = str_repeat( $char, $length );

    for ( $i = 1; $i < count( $lines ); $i++ ) {

      $result[] = $indent . $lines[ $i ];

    }

    return implode( "\n", $result );

  }

  protected function log(
    $form,
    $state_name,
    $state,
    $report = null,
    int $level = LOG_ERR
  ) {

    $uuid = $this->gen_uuid();
    $msts = $this->gen_timestamp();

    $this->read_meta( $form, $uuid, $msts, $data );

    // 2021-04-13 jj5 - NOTE: PCLog should not call in to standard log, PCLog is just for sending
    // to our log server...
    /*
    try {

      $message = "form: $form; uuid: $uuid; msts: $msts; type: $state_name";

      mud_log_level( $message, $level );

    }
    catch ( Throwable $ex ) {

      try {

        mud_log_try_warn( 'pclog: error writing log: ' . $ex->getMessage() );

        mud_log_exception_ignored( $ex );

      }
      catch ( Throwable $ignore ) {

        if ( mud_is_set( 'DEBUG' ) ) {

          mud_log_exception_ignored( $ignore );

        }
      }
    }
    */

    try {

      if ( $report ) { $data[ 'data' ][ 'report' ] = $report; }

      $data[ 'data' ][ $state_name ] = $state;

      $this->submit( 'meta', $form, $uuid, $msts, $data );

      $this->read_data( $msts, $data );

      $this->submit( 'data', $form, $uuid, $msts, $data );

    }
    catch ( Throwable $ex ) {

      try {

        mud_log_try_warn( 'pclog: error submitting log: ' . $ex->getMessage() );

        mud_log_exception_ignored( $ex );

      }
      catch ( Throwable $ignore ) {

        if ( DEBUG ) {

          mud_log_exception_ignored( $ignore );

        }
      }
    }

    return $this->get_issue( $uuid );

  }

  protected function log_http_error( $code ) {

    $form = MUD_PCLOG_FORM_HTTP;

    $state = [
      'code' => $code,
      'headers' => headers_list()
    ];

    return $this->log( $form, 'http_error', $state );

  }

  protected function submit( $type, $form, $uuid, &$msts, $data ) {

    $this->configure_api();

    $data = $this->redact_secrets( $data );

    // 2019-11-10 jj5 - OLD:
    //$client = defined( 'APP_SLUG' ) ? APP_SLUG : 'unknown';
    // 2019-11-10 jj5 - NEW: we report the MUDBALL client version, the app
    // version is reported separately...
    $client = defined( 'MUDBALL_SLUG' ) ? MUDBALL_SLUG : 'client-unknown';
    // 2019-11-10 jj5 - END

    try {

      $json = $this->json_encode( $data );

    }
    catch ( Throwable $ex ) {

      $json = 'null';

      $json_log = 'JSON encoding error: ' . $ex->getMessage();

      mud_log_3_error( $json_log );

    }

    $url = MUD_PCLOG_API . "/submit/$type/$form/$uuid/$msts/$client";

    $this->post( $url, $json, $result, $http_status, $curl_error );

    $msts = intval( $result );

    if ( $http_status === 200 && $msts > 0 ) {

      if ( ! $this->file ) {

        $issue = explode( '-', $uuid )[ 0 ];

        $this->file = "{$msts}-{$issue}-1-meta.json";

      }

      return;

    }

    mud_log_try_warn( 'pclog submission failed: ' . $curl_error );

    return;

    var_dump([
      'url' => $url,
      'result' => $result,
      'http_status' => $http_status,
      'curl_error' => $curl_error,
      'msts' => $msts,
    ]);

    exit;

    throw new Exception( 'Pclog submission failed.' );

  }

  protected function post( $url, $json, &$result, &$http_status, &$curl_error ) {

    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 600 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 600 );
    curl_setopt( $ch, CURLOPT_ENCODING, "gzip" );

    // 2018-06-05 jj5 - follow Location redirects...
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

    // 2017-06-06 jj5 - we shouldn't disable SSL verification...
    //curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    //curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );

    $result = curl_exec( $ch );
    $http_status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $curl_error = curl_error( $ch );

    curl_close( $ch );

  }

  protected function read_exception( $ex, $status ) {

    if ( $ex === null ) { return null; }

    $type = get_class( $ex );
    $message = $ex->getMessage();
    $file = $ex->getFile();
    $line = $ex->getLine();
    $code = $ex->getCode();
    $data = null;

    if ( method_exists( $ex, 'getData' ) ) {

      $data = $this->redact_secrets( $ex->getData() );

    }

    $trace = $this->redact_secrets( $ex->getTrace() );

    return [
      'status' => $status,
      'type' => $type,
      'message' => $message,
      'file' => $file,
      'line' => $line,
      'code' => $code,
      'data' => $data,
      'trace' => $trace,
      'previous' => $this->read_exception( $ex->getPrevious(), $status ),
      'handler' => debug_backtrace(),
    ];

  }

  protected function read_meta( $form, $uuid, $msts, &$data ) {

    global $config;

    // 2019-11-10 jj5 - we initialize our 'info' with stubs for client and
    // server. These are populated by the server.
    //
    $info = [
      'client' => null,
      'server' => null,
    ];

    $net_vars = [
      'REMOTE_ADDR',
      'REMOTE_PORT',
      'REQUEST_SCHEME'
    ];

    foreach ( $net_vars as $net_var ) {

      $info[ strtolower( $net_var ) ] = getenv( $net_var );

    }

    $server_keys = array_keys( $_SERVER );

    foreach ( $server_keys as $server_key ) {

      if ( strpos( $server_key, 'HTTP_' ) !== 0 ) { continue; }

      $info[ strtolower( $server_key ) ] = $_SERVER[ $server_key ];

    }

    $data = [
      'msts' => $msts,
      'name' => $this->read_const( 'APP_NAME' ),
      'code' => $this->read_const( 'APP_CODE' ),
      'slug' => $this->read_const( 'APP_SLUG' ),
      'addr' => $this->get_addr(),
      'agnt' => $this->get_agnt(),
      'user' => $this->get_user(),
      'rqid' => $this->get_rqid(),
      'this' => $this->get_this(),
      'from' => $this->get_from(),
      'thru' => $this->get_thru(),
      'host' => $this->get_host(),
      'prog' => $this->get_file(),
      'type' => 'meta',
      'form' => $form,
      'uuid' => $uuid,
      'flag' => [
        'DEBUG' => defined( 'DEBUG' ) ? DEBUG : false,
        'TEST' => defined( 'TEST' ) ? TEST : false,
        'BETA' => defined( 'BETA' ) ? BETA : false,
        'DEV' => defined( 'DEV' ) ? DEV : false,
      ],
      'info' => $info,
      'data' => [
        'time' => [
          'msts' => null,
          'date' => null,
          'time' => null,
          'client' => $this->get_date()->format( MUD_PCLOG_DATE_FORMAT ),
          'server' => null,
          'local' => null,
          'utc' => $this->get_date_utc()->format( MUD_PCLOG_DATE_FORMAT ),
          'dnic' => null,
          'tnic' => null,
        ],
        'environment' => [
          'config' => mud_redact_secrets( $config )
        ]
      ]
    ];

  }

  protected function read_data( $msts, &$data ) {

    static $ignore_globals = [

      'GLOBALS',

      // 2017-02-22 jj5 - NOTE: we don't log raw post data because it might
      //  contain secrets.
      'HTTP_RAW_POST_DATA',

      // 2017-02-22 jj5 - NOTE: we don't log $argv because it might contain
      //  secrets.
      'argv',

      // 2017-06-06 jj5 - we handle these ones specifically... who doesn't
      // like doing work?
      '_GET', '_POST', '_REQUEST', '_COOKIE', '_FILES',
      '_ENV', '_SERVER', '_SESSION',

      // 2019-11-11 jj5 - $config is reported separately...
      //
      'config',

    ];

    // 2019-11-11 jj5 - ideally there will be nothing in the global scope,
    // if there is that's something to review.

    $globals = [];

    foreach ( $GLOBALS as $key => $val ) {

      if ( in_array( $key, $ignore_globals ) ) { continue; }

      $globals[ $key ] = $val;

    }

    $data[ 'type' ] = 'data';
    $data[ 'msts' ] = $msts;

    $env = &$data[ 'data' ][ 'environment' ];

    $env[ 'get'     ] = mud_redact_secrets( isset( $_GET ) ? $_GET : null );
    $env[ 'post'    ] = mud_redact_secrets( isset( $_POST ) ? $_POST : null );
    $env[ 'request' ] = mud_redact_secrets( isset( $_REQUEST ) ? $_REQUEST : null );
    $env[ 'cookie'  ] = mud_redact_secrets( isset( $_COOKIE ) ? $_COOKIE : null );
    $env[ 'env'     ] = mud_redact_secrets( isset( $_ENV ) ? $_ENV : null );
    $env[ 'files'   ] = mud_redact_secrets( isset( $_FILES ) ? $_FILES : null );
    $env[ 'session' ] = mud_redact_secrets( isset( $_SESSION ) ? $_SESSION : null );
    $env[ 'server'  ] = mud_redact_secrets( isset( $_SERVER ) ? $_SERVER : null );
    $env[ 'globals' ] = mud_redact_secrets( $globals );

  }

  protected function gen_uuid() {

    $bytes = random_bytes( 16 );

    // 2017-02-22 jj5 - SEE: UUID generation, see StackOverflow:
    // http://stackoverflow.com/questions/2040240/

    return sprintf(

      '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits for "time_low"
      random_int( 0, 0xffff ), random_int( 0, 0xffff ),

      // 16 bits for "time_mid"
      random_int( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      random_int( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      random_int( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      random_int( 0, 0xffff ), random_int( 0, 0xffff ), random_int( 0, 0xffff )

    );

  }

  protected function gen_timestamp() {

    return intval( round( microtime( true ) * 1000 ) );

  }

  protected function read_const( $const, $default = 'unknown' ) {

    if ( defined( $const ) ) { return constant( $const ); }

    return $default;

  }

  protected function complete( $message, $form, $issue, $exit, $ex = null ) {

    // 2020-04-19 jj5 - NOTE: this function gets called for unhandled
    // exceptions, which shouldn't ordinarily happen. Usually some other
    // part of the framework will handle exceptions and will know better
    // what to do about showing them to the user. Check out MudApp and its
    // derivatives....

    // 2019-11-10 jj5 - if we're in DEV mode we have already written the
    // report so no more to do...
    //
    if ( defined( 'DEV' ) && DEV ) {

      if ( $exit ) { exit( $exit ); }

      return false;

    }

    mud_buffer_reset();

    if ( $issue ) {

      $note = "This incident has been logged. Issue #$issue.";

    }
    else {

      $note = "Please inform the system administrator.";

    }

    $message = trim( $message );

    $dot = preg_match( '|\.$|', $message ) ? '' : '.';

    $report = "{$message}{$dot} {$note}";

    if ( mud_is_web() ) {

      $http_response_code = $this->get_http_repsonse_code( $ex );

      http_response_code( $http_response_code );

      switch ( $this->output_type ) {

        case MUD_PCLOG_OUTPUT_JSON :

          header( 'Content-Type: application/json', $replace = true );

          $this->render_json_error( $report, $code, $issue, $form, $ex );

          break;

        default :

          if ( function_exists( 'render_500' ) ) {

            render_500( $message, $form, $issue, $exit, $ex );

          }
          else {

            header( 'Content-Type: text/plain', $replace = true );

            echo "{$report}\n";

          }
      }
    }
    else {

      mud_stderr( $report . "\n" );

    }

    exit( $exit );

  }

  protected function get_http_repsonse_code( $ex ) {

    if ( $ex === null ) { return 500; }

    if ( isset( $ex->data ) ) {

      return $ex->data[ 'http_response_code' ] ?? 500;

    }

    return 500;

  }

  protected function render_json_error(
    $report,
    $http_code,
    $issue,
    $form,
    ?Throwable $ex
  ) {

    $code = null;

    if ( $ex !== null ) { $code = $ex->getCode(); }

    $response = [
      'error' => [
        'issue' => $issue,
        'form' => $form,
        'code' => $code,
        'message' => $report,
      ],
    ];

    echo json_encode(
      $response,
      JSON_PRETTY_PRINT |
      JSON_UNESCAPED_SLASHES |
      JSON_UNESCAPED_UNICODE |
      JSON_PARTIAL_OUTPUT_ON_ERROR
    );

  }

  protected function get_issue( $uuid ) {

    return explode( '-', $uuid, 2 )[ 0 ];

  }

  protected function write_report( $type, $report ) {

    if ( defined( 'DEV' ) && DEV ) {

      mud_buffer_reset();

      if ( ! headers_sent() ) {

        header( 'Content-Type: text/plain; charset=UTF-8', $replace = true );

      }

      echo trim( $report ) . "\n";

    }
  }

  protected function json_encode( $data, $options = 0 ) {

    $data = mud_redact_secrets( $data );

    return json_encode(
      $data,
      JSON_PRETTY_PRINT |
      JSON_UNESCAPED_SLASHES |
      JSON_UNESCAPED_UNICODE |
      JSON_PARTIAL_OUTPUT_ON_ERROR |
      $options
    );

  }

  protected function configure_api() {

    if ( defined( 'MUD_PCLOG_API' ) ) { return MUD_PCLOG_API; }

    // 2020-03-20 jj5 - NOTE: we read this config setting directly as the
    // MudConfig object might not be loaded yet...

    global $config;

    if ( isset( $config[ 'mud' ][ 'pclog' ][ 'api' ] ) ) {

      $api = $config[ 'mud' ][ 'pclog' ][ 'api' ];

    }
    else {

      $api = self::DefaultApi();

    }

    define( 'MUD_PCLOG_API', $api );

    return MUD_PCLOG_API;

  }
}
