<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerFile extends MudLoggerBase implements IMudLog {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - private fields...
  //

  private $path;

  private $handle = false;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - constructor...
  //

  public function __construct( string $path, int $level = MUD_DEFAULT_LOG_LEVEL ) {

    parent::__construct( $level );

    if ( $path === null ) {

      $code = defined( 'APP_CODE' ) ? APP_CODE : null;

      if ( $code ) {

        //$dir = "/var/state/$code";

        $dir = mud_get_config( [ 'app', 'state', 'dir' ] );

        if ( is_dir( $dir ) ) { $path = "$dir/$code.log"; }

      }
    }

    if ( $path === null ) {

      mud_abort( 'could not auto-determine log path.' );

    }

    $this->path = $path;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - public methods...
  //

  public function log( string $message, int $level ) {

    if ( $level > $this->level ) { return false; }

    $this->init();

    $std_log = $this->get_log_line( $message, $level ) . "\n";

    $errors = error_reporting();

    try {

      $success = false;

      for ( $try = 1; $try <= MUD_DEFAULT_TRY_COUNT; $try++ ) {

        if ( @fwrite( $this->handle, $std_log ) !== false ) {

          $success = true;

          break;

        }

        usleep( MUD_DEFAULT_TRY_DELAY );

      }

      if ( $success ) {

        $success = false;

        for ( $try = 1; $try <= MUD_DEFAULT_TRY_COUNT; $try++ ) {

          if ( @fflush( $this->handle ) !== false ) {

            $success = true;

            break;

          }

          usleep( MUD_DEFAULT_TRY_DELAY );

        }
      }
    }
    finally {

      error_reporting( $errors );

    }

    $error = ! $success;

    /*
    if ( $error || $this->copy_to_stderr ) {

      mud_stderr( $std_log );

    }

    if ( $error || $this->copy_to_weblog ) {

      $web_log = $this->get_log_line( $message, $level, MUD_LOG_FORMAT_WEB );

      error_log( $web_log );

    }
    */

    return true;

  }

  public function shutdown() {

    try {

      if ( ! $this->handle ) { return; }

      $handle = $this->handle;

      mud_retry( function() use ( $handle ) {

        return @fclose( $handle );

      });

      $this->handle = false;

    }
    catch ( Throwable $ex ) {

      mud_log_exception_shutdown( $ex );

    }
  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - protected methods...
  //

  protected function init() {

    if ( $this->handle ) { return; }

    $path = $this->path;

    $this->handle = mud_retry( function() use ( $path ) {

      return @fopen( $path, 'a' );

    });

    register_shutdown_function( [ $this, 'shutdown' ] );

  }
}
