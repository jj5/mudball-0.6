<?php

/*
** log to stderr (is STDERR for CLI and web log for web)
** log to error log
** log to stdout
** log to syslog
** log to file
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../185-json/mud_json.php';

// 2022-02-21 jj5 - the log module and the pclog module are symbiotic...
//
require_once __DIR__ . '/../190-pclog/mud_pclog.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudLog.php';

require_once __DIR__ . '/class/MudModuleWebLog.php';
require_once __DIR__ . '/class/MudModuleLog.php';

require_once __DIR__ . '/class/1-MudLoggerBase.php';
require_once __DIR__ . '/class/2-MudLoggerNull.php';
require_once __DIR__ . '/class/3-MudLoggerStderr.php';
require_once __DIR__ . '/class/4-MudLoggerWeblog.php';
require_once __DIR__ . '/class/5-MudLoggerSyslog.php';
require_once __DIR__ . '/class/6-MudLoggerFile.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_logger_null() {

  return mud_module_log()->new_mud_logger_null();

}

function new_mud_logger_stderr( int $level = MUD_DEFAULT_LOG_LEVEL ) {

  return mud_module_log()->new_mud_logger_stderr( $level );

}

function new_mud_logger_weblog( int $level = MUD_DEFAULT_LOG_LEVEL ) {

  return mud_module_log()->new_mud_logger_weblog( $level );

}

function new_mud_logger_syslog( $copy_to_stderr = true, int $level = MUD_DEFAULT_LOG_LEVEL ) {

  return mud_module_log()->new_mud_logger_syslog( $copy_to_stderr, $level );

}

function new_mud_logger_file( string $path, int $level = MUD_DEFAULT_LOG_LEVEL ) {

  return mud_module_log()->new_mud_logger_file( $path, $level );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - functional interface...
//

// 2020-05-01 jj5 - SEE: The Syslog Protocol:
// https://tools.ietf.org/html/rfc5424
//
// 2020-04-16 jj5 - initialization and miscellaneous functions go here.
// Note that if you don't initialize the logger you will get a syslog logger
// by default.
//

function mug_log_register( $logger ) {

  mud_module_log()->register( $logger );

}

function mud_log_init_null() {

  mug_log_register( MudLoggerNull::Instance() );

}

function mud_log_init_stderr( int $level = MUD_DEFAULT_LOG_LEVEL ) {

  mug_log_register( new_mud_logger_stderr( $level ) );

}

function mud_log_init_weblog( int $level = MUD_DEFAULT_LOG_LEVEL ) {

  mug_log_register( new_mud_logger_weblog( $level ) );

}

function mud_log_init_syslog( bool $copy_to_stderr = true, int $level = MUD_DEFAULT_LOG_LEVEL ) {

  mug_log_register( new_mud_logger_syslog( $copy_to_stderr, $level ) );

}

function mud_log_init_file( string $path, int $level = MUD_DEFAULT_LOG_LEVEL ) {

  mug_log_register( new_mud_logger_file( $path, $level ) );

}

function mud_log_get_ident() {

  return mud_module_log()->get_ident();

}

function mud_log_get_location(
  array $trace,
  &$location,
  &$file = null,
  &$line = null
) {

  return mud_module_log()->get_location( $trace, $location, $file, $line );

}

function mud_normalize_string( string $input ) {

  return mud_module_log()->normalize_string( $input );

}

function mud_log_try_warn( $message ) {

  return mud_module_log()->try_warn( $message );

}

// 2020-04-19 jj5 - a 'handled' exception is something we've recovered from.
//
function mud_log_exception_handled( Throwable $ex ) {

  return mud_module_log()->log_exception( $ex, MudExceptionKind::HANDLED );

}

// 2020-04-19 jj5 - an 'ignored' exception is something we weren't expecting
// but which we've ignored...
//
function mud_log_exception_ignored( Throwable $ex ) {

  return mud_module_log()->log_exception( $ex, MudExceptionKind::IGNORED );

}

// 2020-04-19 jj5 - a 'fatal' exception is an irrecoverable error which is
// causing us to exit (or HTTP 500) immediately after logging the exception...
//
function mud_log_exception_fatal( Throwable $ex ) {

  return mud_module_log()->log_exception( $ex, MudExceptionKind::FATAL );

}

/*
// 2020-04-19 jj5 - a 'shutdown' exception is an exception we've encountered
// while processing a shutdown handler...
//
function mud_log_exception_shutdown(
  Throwable $ex,
  int $level = LOG_CRIT,
  bool $pclog = true
) {

  // 2020-04-19 jj5 - NOTE: this function is for logging exceptions
  // encountered while processing a shutdown function registered with
  // register_shutdown_function(). We might need to think harder about what
  // services may not be available during shutdown which may affect the
  // ability to write this log.

  // 2020-04-19 jj5 - at the moment we just assume the log functionality will
  // work... this might be wrong and should be reconsidered/investigated.

  // 2020-04-19 jj5 - NOTE: exceptions is shutdown functions are probably
  // very "serious", but they don't count as "fatal", because they are
  // essentially ignored...

  return mud_module_log()->log_exception( $ex, $level, $pclog );

}
*/


//
// 2020-04-16 jj5 - we have specific logging functions here, and a generic
// one too...
//

// 2020-04-15 jj5 - SEE: https://www.php.net/manual/en/function.syslog.php

function mud_log_level( string $message, int $level = LOG_NOTICE ) {

  return mud_module_log()->log( $message, $level );

}

// 2020-04-16 jj5 - mud_log_trace() is just a back-compat thing, consider
// removing it...
//
function mud_log_trace( string $message, $data = null ) {

  if ( $data !== null ) {

    $message = "$message: " . json_encode( $data, JSON_UNESCAPED_SLASHES );

  }

  mud_log_7_debug( $message );

}

function mud_log_0_emergency( string $message ) {

  return mud_module_log()->log( $message, LOG_EMERG );

}

function mud_log_1_alert( string $message ) {

  return mud_module_log()->log( $message, LOG_ALERT );

}

function mud_log_2_critical( string $message ) {

  return mud_module_log()->log( $message, LOG_CRIT );

}

function mud_log_3_error( string $message ) {

  return mud_module_log()->log( $message, LOG_ERR );

}

function mud_log_4_warning( string $message ) {

  return mud_module_log()->log( $message, LOG_WARNING );

}

function mud_log_5_notice( string $message ) {

  return mud_module_log()->log( $message, LOG_NOTICE );

}

function mud_log_6_info( string $message ) {

  return mud_module_log()->log( $message, LOG_INFO );

}

function mud_log_7_debug( string $message ) {

  return mud_module_log()->log( $message, LOG_DEBUG );

}


function mud_log_web_request() : bool {

  return mud_module_log()->log_web_request();

}

function mud_log_web_response() : bool {

  return mud_module_log()->log_web_response();

}

function mud_get_http_reason_phrase( int $http_status_code ) : string {

  return mud_module_log()->get_http_reason_phrase( $http_status_code );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - service locator...
//
//

function mud_module_log() : MudModuleLog {

  return mud_locator()->get_module( MudModuleLog::class );

}
