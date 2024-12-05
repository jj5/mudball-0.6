<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleIo extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - buffer private fields...
  //

  private $flushed = 0;
  private $cleared = 0;


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - output private fields...
  //

  private $stdout_sent = 0;
  private $stderr_sent = 0;


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleIo|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public buffer functions...
  //

  public function get_total_flushed_bytes() { return $this->flushed; }
  public function get_total_cleared_bytes() { return $this->cleared; }

  public function reset() : int {

    $this->clear_all();

    return $this->start();

  }

  public function start() : int {

    ob_start();

    return ob_get_level();

  }

  public function flush( &$length = null, bool $return = false ) {

    $length = ob_get_length();

    $this->flushed += $length;

    $result = null;

    if ( ob_get_level() ) {

      if ( $return ) {

        $result = ob_get_flush();

      }
      else {

        ob_end_flush();

      }
    }

    flush();

    return $result;

  }

  public function clear( &$length = null, bool $return = false ) {

    $length = ob_get_length();

    $this->cleared += $length;

    if ( $return ) { return ob_get_clean(); }

    ob_end_clean();

    return null;

  }

  public function clear_all( &$length = null, bool $return = false ) {

    $length = 0;

    if ( $return ) {

      $result = '';

      while ( ob_get_level() ) {

        $length += ob_get_length();

        $result .= ob_get_clean();

      }

      $this->cleared += $length;

      return $result;

    }

    while ( ob_get_level() ) {

      $length += ob_get_length();

      ob_end_clean();

    }

    $this->cleared += $length;

    return null;

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-18 jj5 - public input functions...
  //

  public function read_acord( $input, $default = '' ) {

    $value = $this->read_ascii( $input, null );

    if ( $value === null ) { return $default; }

    return mud_normalize_space( $value );

  }

  public function read_ucord( $input ) {


  }

  public function read_atext( $input ) {


  }

  public function read_utext( $input ) {


  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public output functions...
  //

  public function get_total_stdout_bytes() { return $this->stdout_sent; }
  public function get_total_stderr_bytes() { return $this->stderr_sent; }

  public function printline( $line, &$bytes_written = null ) : string {

    $line = strval( $line );

    return mud_stdout( "$line\n", $flush = true, $bytes_written );

  }

  public function stdout( $output, bool $flush = false, &$bytes_written = 0 ) : string {

    $output = strval( $output );
    $strlen = strlen( $output );

    $this->stdout_sent += $strlen;
    $bytes_written += $strlen;

    echo $output;

    if ( $flush ) { flush(); }

    return $output;

  }

  public function stderr( $output, bool $flush = false, &$bytes_written = 0 ) : string {

    $output = strval( $output );
    $strlen = strlen( $output );

    $this->stderr_sent += $strlen;
    $bytes_written += $strlen;

    if ( defined( 'STDERR' ) ) {

      // 2020-05-01 jj5 - OLD:
      //file_put_contents( 'php://stderr', $output );
      // 2020-05-01 jj5 - NEW:
      fwrite( STDERR, $output );
      // 2020-05-01 jj5 - END

      if ( $flush ) { fflush( STDERR ); }

    }
    else {

      error_log( $output );

    }

    return $output;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-26 jj5 - protected input functions...
  //

  public function read_ascii( $value, $default = '' ) {

    $value = $this->read_string( $value, null );

    if ( $value === null ) { return $default; }

    return iconv( 'UTF-8', 'us-ascii//TRANSLIT', $value );

  }

  public function read_string( $value, $default = '' ) {

    $value = $this->read_text( $value, null );

    if ( $value === null ) { return $default; }

    return trim( $value );

  }

  public function read_text( $value, $default = '' ) {

    if ( is_null( $value ) ) { return $default; }

    if ( is_object( $value ) ) {

      if ( method_exists( $object, '__toString' ) ) {

        $value = strval( $object );

      }
      else {

        return $default;

      }
    }

    if ( is_string( $value ) ) { return mud_strip_control_chars( $value ); }

    if ( is_bool( $value ) ) { return $value ? 'true' : 'false'; }

    if ( is_int( $value ) || is_float( $value ) ) { return strval( $value ); }

    // 2019-11-06 jj5 - THINK: format DateTime..?

    return $default;

  }

}
