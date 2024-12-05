<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../190-log/mud_log.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModulePclog.php';
require_once __DIR__ . '/class/MudModulePclogDispatcher.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - initialize the logger
//

// 2019-11-10 jj5 - we attach our event handlers as early as possible...
//
MudModulePclogDispatcher::Attach();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-11-10 jj5 - functional interface...
//

function mud_pclog_get_fatality() {

  return mud_module_pclog()->get_fatality();

}

function mud_pclog_get_last_exception() {

  return mud_module_pclog()->get_last_exception();

}

// 2019-11-10 jj5 - the 'ouput' is the type of output desired, e.g. text,
// html, json, etc...
//
function mud_pclog_set_output( $output ) {

  return mud_module_pclog()->set_output( $output );

}

function mud_pclog_get_output() {

  return mud_module_pclog()->get_output();

}

// 2019-11-10 jj5 - the 'user' info indicates the current user, may be a
// string comprising email address, username, user ID, or some combination
// thereof.
//
function mud_pclog_set_user( $user ) {

  return mud_module_pclog()->set_user( $user );

}

function mud_pclog_get_user() {

  return mud_module_pclog()->get_user();

}

// 2019-11-10 jj5 - the 'host' is the name of the server processing the
// request. By default this will be the HTTP HOST header for web requests and
// the fully qualified hostname for CLI requests, or you can override it.
//
function mud_pclog_set_host( $host ) {

  return mud_module_pclog()->set_host( $host );

}

function mud_pclog_get_host() {

  return mud_module_pclog()->get_host();

}

// 2019-11-10 jj5 - the 'rqid' is the application request ID, usually an
// a_interaction_id...
//
function mud_pclog_set_rqid( $rqid ) {

  return mud_module_pclog()->set_rqid( $rqid );

}

function mud_pclog_get_rqid() {

  return mud_module_pclog()->get_rqid();

}

function mud_pclog_get_file() {

  return mud_module_pclog()->get_file();

}

// 2019-11-10 jj5 - this function is for outputting the Javascript used for
// client-side logging... include it in your HTML <head> element...
//
function mud_pclog_render_scripts() {

  return mud_module_pclog()->render_scripts();

}

// 2019-11-10 jj5 - this function is for logging custom messages to the pclog
// server...
//
function mud_pclog_log_custom(
  string $form,
  string $message,
  $context = null,
  $trace = null
) {

  return mud_module_pclog()->log_custom( $form, $message, $context, $trace );

}

function mud_pclog_log_previous( Throwable $ex, string|null &$report = null, string|null &$issue = null ) {

  return mud_pclog_log_exception( $ex, MudExceptionKind::PREVIOUS, $report, $issue );

}

function mud_pclog_log_handled( Throwable $ex, string|null &$report = null, string|null &$issue = null ) {

  return mud_pclog_log_exception( $ex, MudExceptionKind::HANDLED, $report, $issue );

}

function mud_pclog_log_ignored( Throwable $ex, string|null &$report = null, string|null &$issue = null ) {

  return mud_pclog_log_exception( $ex, MudExceptionKind::IGNORED, $report, $issue );

}

function mud_pclog_log_fatal( Throwable $ex, string|null &$report = null, string|null &$issue = null ) {

  return mud_pclog_log_exception( $ex, MudExceptionKind::FATAL, $report, $issue );

}

function mud_pclog_log_unhandled( Throwable $ex, string|null &$report = null, string|null &$issue = null ) {

  return mud_pclog_log_exception( $ex, MudExceptionKind::UNHANDLED, $report, $issue );

}

function mud_pclog_log_exception(
  Throwable $ex,
  MudExceptionKind $kind,
  string|null &$report = null,
  string|null &$issue = null,
) {

  return mud_module_pclog()->log_exception( $ex, $kind, $report, $issue );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - service locator...
//

function mud_module_pclog() : MudModulePclog {

  return mud_locator()->get_module( MudModulePclog::class );

}
