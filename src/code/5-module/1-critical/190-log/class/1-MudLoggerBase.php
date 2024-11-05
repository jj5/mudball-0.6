<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

abstract class MudLoggerBase extends MudGadget {

  protected $level;

  public function __construct( int $level = MUD_DEFAULT_LOG_LEVEL ) {

    parent::__construct();

    $this->level = $level;

  }

  protected function get_log_line(
    string $message,
    int $level,
    string $type = MUD_LOG_FORMAT_STANDARD
  ) {

    $message = mud_normalize_string( $message );

    $this->get_log_info(
      $level,
      $label,
      $ident,
      $time,
      $user,
      $host,
      $location
    );

    switch ( $type ) {

      case MUD_LOG_FORMAT_SYSLOG :

        // 2020-04-16 jj5 - $time and $ident are redundant for syslog...

        if ( $location ) {

          return "$label: $user@$host: $location: $message";

        }

        return "$label: $user@$host: $message";

      case MUD_LOG_FORMAT_WEB :

        // 2020-04-16 jj5 - $time is redundant for web logs...

        if ( $location ) {

          return "$label: $ident: $user@$host: $location: $message";

        }

        return "$label: $ident: $user@$host: $message";

      case MUD_LOG_FORMAT_STANDARD :
      default :

        // 2020-04-16 jj5 - standard and default format includes as much
        // info as we have...

        if ( $location ) {

          return "$label: $time: $ident: $user@$host: $location: $message";

        }

        return "$label: $time: $ident: $user@$host: $message";

    }
  }

  protected function get_log_info(
    int $level,
    &$label,
    &$ident,
    &$time,
    &$user,
    &$host,
    &$location,
    &$file = null,
    &$line = null
  ) {

    $label = $this->get_label( $level );
    $ident = mud_log_get_ident();

    $time = date( 'r' );
    $user = mud_pclog_get_user();
    $host = mud_pclog_get_host();
    $trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );

    mud_log_get_location( $trace, $location, $file, $line );

  }

  protected function get_label( $level ) {

    static $labels = [
      LOG_EMERG   => '[EMERGENCY]',
      LOG_ALERT   => '[ALERT]',
      LOG_CRIT    => '[CRITICAL]',
      LOG_ERR     => '[ERROR]',
      LOG_WARNING => '[WARNING]',
      LOG_NOTICE  => '[NOTICE]',
      LOG_INFO    => '[INFO]',
      LOG_DEBUG   => '[DEBUG]',
    ];

    return $labels[ $level ] ?? '[UNKNOWN]';

  }
}
