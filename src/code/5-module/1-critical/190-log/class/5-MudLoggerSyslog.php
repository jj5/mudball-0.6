<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerSyslog extends MudLoggerBase implements IMudLog {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - private fields...
  //

  private $initialized = false;

  private $copy_to_stderr;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - constructor...
  //

  public function __construct( $copy_to_stderr = true, $level = MUD_DEFAULT_LOG_LEVEL ) {

    parent::__construct( $level );

    $this->copy_to_stderr = $copy_to_stderr;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - public methods...
  //

  public function log( string $message, int $level ) {

    if ( $level > $this->level ) { return false; }

    $this->init();

    $syslog = $this->get_log_line( $message, $level, MUD_LOG_FORMAT_SYSLOG );

    syslog( $level, $syslog );

    /*
    if ( $this->copy_to_weblog ) {

      $web_log = $this->get_log_line( $message, $level, MUD_LOG_FORMAT_WEB );

      error_log( $web_log );

    }
    */

    return true;

  }

  public function shutdown() {

    try {

      if ( ! $this->initialized ) { return; }

      $this->initialized = false;

      closelog();

    }
    catch ( Throwable $ex ) {

      mud_log_exception_shutdown( $ex );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - protected methods...
  //

  protected function init() {

    if ( $this->initialized ) { return; }

    $this->initialized = true;

    $ident = mud_log_get_ident();

    // 2020-04-15 jj5 - don't delay the opening of the log connection, we
    // delay this init() function already so at this point we know we're gonna
    // need the syslog connection... also include the process ID (PID) in the
    // syslog report...
    //
    $options = LOG_NDELAY | LOG_PID;

    if ( mud_is_cli() ) {

      // 2020-04-15 jj5 - if we're a console app and we can't write to the
      // syslog then log to console...
      //
      $options |= LOG_CONS;

    }

    if ( $this->copy_to_stderr ) {

      $options |= LOG_PERROR;

    }

    // 2020-04-15 jj5 - SEE: https://www.php.net/manual/en/function.openlog.php
    //
    // 2020-04-15 jj5 - I'm not 100% sure what is best to use here. Maybe
    // one of the LOG_LOCAL* facilities would be better. LOG_USER is probably
    // okay...
    //
    $facility = LOG_USER;

    openlog( $ident, $options, $facility );

    register_shutdown_function( [ $this, 'shutdown' ] );

  }
}
