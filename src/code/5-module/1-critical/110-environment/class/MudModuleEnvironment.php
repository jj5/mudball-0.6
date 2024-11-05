<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: this class provides information about the runtime environment.

class MudModuleEnvironment extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleEnvironment|null $previous = null ) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - public methods...
  //

  // 2024-02-08 jj5 - NOTE: we *do* cache the result of the following functions because it improves performance and the
  // values won't change over the course of a running program.

  // 2018-06-17 jj5 - this function detects if we are running in a command-line interface or not...
  //
  // 2017-02-23 jj5 - SEE: CLI detection: http://www.binarytides.com/php-check-running-cli/
  //
  public function is_cli() : bool {

    static $is_cli = null;

    if ( $is_cli === null ) {

      $is_cli = (bool)( php_sapi_name() === 'cli' );

    }

    return $is_cli;

  }

  public function is_web() : bool {

    static $is_web = null;

    if ( $is_web === null ) {

      $is_web = (bool)( ! $this->is_cli() );

    }

    return $is_web;

  }

  public function is_posix() : bool {

    static $is_posix = null;

    if ( $is_posix === null ) {

      $is_posix = (bool)( function_exists( 'posix_getuid' ) );

    }

    return $is_posix;

  }

  public function is_windows() : bool {

    static $is_windows = null;

    if ( $is_windows === null ) {

      $is_windows = (bool)( strtoupper( substr( PHP_OS, 0, 3 ) ) === 'WIN' );

    }

    return $is_windows;

  }

  public function get_username() : string|null {

    return posix_getpwuid( posix_geteuid() )[ 'name' ] ?? null;

  }
}
