<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleLog extends MudModuleWebLog {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-28 jj5 - traits...
  //

  use MudMixin;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - public fields...
  //

  public $settings = [
    MudExceptionSort::PREVIOUS  => [ 'level' => MUD_LOG_LEVEL_6_INFO,     'final' => false, 'max' =>  0 ],
    MudExceptionSort::HANDLED   => [ 'level' => MUD_LOG_LEVEL_5_NOTICE,   'final' => false, 'max' =>  2 ],
    MudExceptionSort::IGNORED   => [ 'level' => MUD_LOG_LEVEL_4_WARNING,  'final' => false, 'max' =>  4 ],
    MudExceptionSort::SHUTDOWN  => [ 'level' => MUD_LOG_LEVEL_3_ERROR,    'final' => false, 'max' =>  6 ],
    MudExceptionSort::FATAL     => [ 'level' => MUD_LOG_LEVEL_2_CRITICAL, 'final' => true,  'max' =>  8 ],
    MudExceptionSort::UNHANDLED => [ 'level' => MUD_LOG_LEVEL_2_CRITICAL, 'final' => true,  'max' => 10 ],
  ];


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - private fields...
  //

  private $logger_list = [];


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleLog|null $previous = null) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_logger_null() {

    return new MudLoggerNull();

  }

  public function new_mud_logger_stderr( int $level = MUD_DEFAULT_LOG_LEVEL ) {

    return new MudLoggerStderr( $level );

  }

  public function new_mud_logger_weblog( int $level = MUD_DEFAULT_LOG_LEVEL ) {

    return new MudLoggerWeblog( $level );

  }

  public function new_mud_logger_syslog( $copy_to_stderr = true, int $level = MUD_DEFAULT_LOG_LEVEL ) {

    return new MudLoggerSyslog( $copy_to_stderr, $level );

  }

  public function new_mud_logger_file( string $path, int $level = MUD_DEFAULT_LOG_LEVEL ) {

    return new MudLoggerFile( $path, $level );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  public function register( $logger ) {

    $this->logger_list[] = $logger;

  }

  /*
  public function init( $log = MUD_LOGGER_SYSLOG, array $options = [] ) {

    $level          = $options[ MUD_LOG_OPT_LEVEL  ] ?? MUD_DEFAULT_LOG_LEVEL;
    $path           = $options[ MUD_LOG_OPT_PATH   ] ?? MUD_DEFAULT_LOG_PATH;
    $copy_to_stderr = $options[ MUD_LOG_OPT_STDERR ] ?? MUD_DEFAULT_LOG_STDERR;
    $copy_to_weblog = $options[ MUD_LOG_OPT_WEBLOG ] ?? MUD_DEFAULT_LOG_WEBLOG;

    // 2020-04-16 jj5 - NOTE: we could factor out this logger creation code
    // into factory methods, but we don't need those yet so that's not done
    // yet.

    switch ( $log ) {

      case MUD_LOGGER_NULL :

        $logger = MudLoggerNull::Instance();

        break;

      case MUD_LOGGER_FILE :

        $logger = new MudLoggerFile(
          $path,
          $level,
          $copy_to_stderr,
          $copy_to_weblog
        );

        break;

      case MUD_LOGGER_SYSLOG :
      default :

        $logger = new MudLoggerSyslog(
          $level,
          $copy_to_stderr,
          $copy_to_weblog
        );

        break;

    }

    $this->logger = $logger;

  }
  */

  // 2021-04-13 jj5 - if something happens where we can't log properly use this function to try
  // and warn an admin that there is some type of unexpected problem occurring...
  //
  public function try_warn( $message ) {

    try {

      error_log( $message );

      // 2021-04-13 jj5 - THINK: we need to think if this is serious enough to open a special
      // connection to syslog so that the following function will work...
      //
      //syslog( $syslog_priority, $message );

    }
    catch ( Throwable $ignored ) { ; }

    return false;

  }

  public function log_exception( Throwable $exception, int $sort, bool $pclog = true ) {

    try {

      if ( $pclog ) {

        mud_pclog_log_exception( $exception, $sort );

      }

      $previous = $exception->getPrevious();

      if ( $previous ) { $this->log_exception( $previous, MudExceptionSort::PREVIOUS, false ); }

      $type = get_class( $exception );
      $code = $exception->getCode();

      $this->get_location( $exception->getTrace(), $location );

      $message = $this->normalize_string( $exception->getMessage() );

      if ( $location ) {

        $message = "{$type}[$code]: $location: $message";

      }
      else {

        $message = "{$type}[$code]: $message";

      }

      $level = $this->settings[ $sort ][ 'level' ];

      return $this->log( $message, $level );

    }
    catch ( Throwable $ex ) {

      $this->notify_log_failure_and_exit( __CLASS__, __FUNCTION__, $ex );

      exit( MUD_EXIT_ABORT );

    }
  }

  public function log( string $message, int $level = LOG_NOTICE ) {

    try {

      if ( count( $this->logger_list ) === 0 ) {

        // 2021-04-13 jj5 - if you don't want this cluttering up your logs then initialize the
        // logging system with a null logger: mud_log_init_null();

        return mud_log_try_warn( $message );

      }

      //var_dump ( $this->logger_list ); exit;

      foreach ( $this->logger_list as $logger ) {

        $logger->log( $message, $level );

      }
    }
    catch ( Throwable $ex ) {

      $this->notify_log_failure_and_exit( __CLASS__, __FUNCTION__, $ex );

      exit( MUD_EXIT_ABORT );

    }
  }

  public function get_ident() {

    // 2020-04-16 jj5 - the 'ident' is how we identify this system to syslog
    // and in our logs... ideally we have an app slug which includes the
    // app's code and its version.

    static $ident = null;

    if ( $ident === null ) {

      if ( defined( 'APP_SLUG' ) ) {

        $ident = APP_SLUG;

      }
      else {

        // 2020-04-15 jj5 - if we don't have an app slug just use the script
        // file name (without its full path)...

        $ident = basename( $_SERVER[ 'SCRIPT_FILENAME' ] ?? MUDBALL_SLUG );

      }
    }

    return $ident;

  }

  public function get_location(
    array $trace,
    &$location,
    &$file = null,
    &$line = null
  ) {

    // 2020-04-16 jj5 - when trying to figure out the location of the caller
    // we skip our library files which have helper functions which might be
    // in the call stacks but which are not interesting...
    //
    static $skip_files = [

      // 2020-04-17 jj5 - critical files to skip...
      //
      'mud_error.php', 'MudModuleError.php',
      'mud_log.php', 'MudModuleLog.php',
      'mud_pclog.php', 'MudModulePclog.php',

      // 2020-04-29 jj5 - class files to skip...
      //
      '1-MudLoggerBase.php',
      '2-MudLoggerNull.php',
      '3-MudLoggerStderr.php',
      '4-MudLoggerWeblog.php',
      '5-MudLoggerSyslog.php',
      '6-MudLoggerFile.php',

    ];

    $location = null;
    $file = null;
    $line = null;

    foreach ( $trace as $call ) {

      $file = $call[ 'file' ] ?? null;
      $line = $call[ 'line' ] ?? null;

      if ( $file === null || $line === null ) { continue; }

      $check_file = basename( $file );

      if ( in_array( $check_file, $skip_files ) ) { continue; }

      break;

    }

    if ( $file ) {

      $file = basename( $file );

    }

    if ( $file && $line ) {

      $location = "$file:$line";

    }
  }

  public function normalize_string( string $input ) {

    // 2020-04-16 jj5 - convert nulls and control chars to question marks...
    //
    $safe = preg_replace( '/[\x00-\x1f\x7f]+/', '?', $input );

    // 2020-04-16 jj5 - normalize whitespace...
    //
    return trim( preg_replace( '/\s+/', ' ', $safe ) );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - protected functions...
  //

  protected function get_logger() : IMudLog {

    if ( $this->logger === null ) {

      $this->logger = new_mud_logger_syslog();

    }

    return $this->logger;

  }

  protected function notify_log_failure_and_exit( $class, $func, $ex ) {

    error_reporting( 0 );

    static $read = [
      'code' => 'getCode',
      'file' => 'getFile',
      'line' => 'getLine',
      'text' => 'getMessage',
    ];

    // 2018-07-15 jj5 - if we get an exception while logging an excpetion
    // try writing to the system log as a last-ditch effort and report
    // failure by returning false...

    // 2021-03-04 jj5 - NOTE: we exit from here because otherwise we're a prime candidate for
    // infinite regress...

    try {

      //$code = $ex->getCode();
      //$file = $ex->getFile();
      //$line = $ex->getLine();
      //$text = $ex->getMessage();

      $info = [
        'code' => 'unknown',
        'file' => 'unknown',
        'line' => 'unknown',
        'text' => 'unknown',
      ];

      foreach ( $read as $name => $getter ) {

        try {

          $func = [ $ex, $getter ];

          if ( is_callable( $func ) ) {

            $info[ $name ] = call_user_func( $func );

          }
        }
        catch ( Throwable $ignore_info_ex ) { ; }

      }

      extract( $info );

      $log = "ERROR WRITING LOG: in $class::$func()[$code]: $file:$line: $text";

      $this->try_warn( $log );

      exit( MUD_EXIT_ABORT );

    }
    catch ( Throwable $ignored ) {

      // 2020-04-19 jj5 - we do *not* try to log this exception with our exception logging
      // facilities, this method being called indicates that exception logging is not working...

      $this->try_warn( $ignored->getMessage() );

      exit( MUD_EXIT_ABORT );

    }

    exit( MUD_EXIT_ABORT );

  }
}
