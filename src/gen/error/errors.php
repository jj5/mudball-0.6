<?php

// 2024-02-09 jj5 - SEE: https://www.jj5.net/wiki/error_levels

define( 'LX_EXIT_SUCCESS', 0 );
define( 'LX_EXIT_CANNOT_CONTINUE', 10 );
define( 'LX_EXIT_BAD_DATA', 20 );
define( 'LX_EXIT_BAD_FORMAT', 21 );
define( 'LX_EXIT_BAD_VALUE', 22 );
define( 'LX_EXIT_BAD_COMMAND', 30 );
define( 'LX_EXIT_NO_FILE', 31 );
define( 'LX_EXIT_WRONG_FILE', 32 );
define( 'LX_EXIT_BAD_FILE', 33 );
define( 'LX_EXIT_USER_CANCEL', 34 );
define( 'LX_EXIT_BAD_ENVIRONMENT', 40 );
define( 'LX_EXIT_FILE_MISSING', 41 );
define( 'LX_EXIT_NO_ACCESS', 42 );
define( 'LX_EXIT_BAD_CONFIG', 43 );
define( 'LX_EXIT_NO_LOCK', 44 );
define( 'LX_EXIT_NO_SERVICE', 56 );
define( 'LX_EXIT_NO_DATABASE', 57 );
define( 'LX_EXIT_EXHAUSTED', 58 );
define( 'LX_EXIT_OFFLINE', 59 );
define( 'LX_EXIT_BAD_PROGRAM', 70 );
define( 'LX_EXIT_ERROR', 71 );
define( 'LX_EXIT_EXCEPTION', 72 );
define( 'LX_EXIT_ASSERT', 73 );
define( 'LX_EXIT_TEST_FAILED', 74 );
define( 'LX_EXIT_INVALID', 75 );
define( 'LX_EXIT_NOT_IMPLEMENTED', 80 );
define( 'LX_EXIT_NOT_SUPPORTED', 81 );
define( 'LX_EXIT_NOT_POSSIBLE', 82 );
define( 'LX_EXIT_DEBUG', 88 );
define( 'LX_EXIT_ABORT', 89 );
define( 'LX_EXIT_SPECIAL_SUCCESS', 90 );
define( 'LX_EXIT_OPTIONS_LISTED', 98 );
define( 'LX_EXIT_HELP', 99 );
define( 'LX_EXIT_UNIX_BAD_PERMISSION', 126 );
define( 'LX_EXIT_UNIX_BAD_COMMAND', 127 );
define( 'LX_EXIT_TERMINATED_BY_SIGNAL', 128 );
define( 'LX_EXIT_TERMINATED_BY_CTRLC', 130 );
define( 'LX_EXIT_GENERIC_1', 1 );
define( 'LX_EXIT_GENERIC_2', 2 );
define( 'LX_EXIT_GENERIC_255', 255 );

function my_exit( int|string|Throwable $argument = EXIT_SUCCESS, bool $print_error = true, bool|null $print_hint = null ) {

  // if $argument is an int it is treated as an error code

  // if $argument is a string it is treated as an error message and EXIT_ABORT is used

  // if $argument is some type of Throwable an appropriate error level is determined

  // if $print_error is true an error message is logged

  // if $print_hint is true a hint for the programmer concerning other possibly related codes is printed

  // the DEBUG constant can influence the behaviour of this function, see the code for details

  if (
    $argument === EXIT_SUCCESS          ||
    $argument === EXIT_SPECIAL_SUCCESS  ||
    $argument === EXIT_OPTIONS_LISTED   ||
    $argument === EXIT_HELP
  ) {

    // shortcircuit the "success" cases which don't need an error message

    exit( $argument );

  }

  $is_debug = defined( 'DEBUG' ) && DEBUG;

  if ( $print_hint === null ) {

    $print_hint = $is_debug;

  }

  static $map = [
     EXIT_SUCCESS => [
       'code'         => 0,
       'name'         => "EXIT_SUCCESS",
       'category'     => "success",
       'description'  => "success!",
     ],
     EXIT_CANNOT_CONTINUE => [
       'code'         => 10,
       'name'         => "EXIT_CANNOT_CONTINUE",
       'category'     => "logic exit",
       'description'  => "cannot continue; but nothing is abnormal or wrong",
       'hint'         => "consider EXIT_SPECIAL_SUCCESS",
     ],
     EXIT_BAD_DATA => [
       'code'         => 20,
       'name'         => "EXIT_BAD_DATA",
       'category'     => "input error",
       'description'  => "there was a problem with inputs",
     ],
     EXIT_BAD_FORMAT => [
       'code'         => 21,
       'name'         => "EXIT_BAD_FORMAT",
       'category'     => "input error",
       'description'  => "data was in an invalid format",
     ],
     EXIT_BAD_VALUE => [
       'code'         => 22,
       'name'         => "EXIT_BAD_VALUE",
       'category'     => "input error",
       'description'  => "data nominated an invalid value (but was in correct format)",
     ],
     EXIT_BAD_COMMAND => [
       'code'         => 30,
       'name'         => "EXIT_BAD_COMMAND",
       'category'     => "user error",
       'description'  => "invalid command-line or options",
     ],
     EXIT_NO_FILE => [
       'code'         => 31,
       'name'         => "EXIT_NO_FILE",
       'category'     => "user error",
       'description'  => "a required file/directory path not nominated",
     ],
     EXIT_WRONG_FILE => [
       'code'         => 32,
       'name'         => "EXIT_WRONG_FILE",
       'category'     => "user error",
       'description'  => "user nominated file (or directory) missing; use EXIT_FILE_MISSING for system files",
     ],
     EXIT_BAD_FILE => [
       'code'         => 33,
       'name'         => "EXIT_BAD_FILE",
       'category'     => "user error",
       'description'  => "user nominated file (or directory) cannot be accessed due to invalid permissions",
       'hint'         => "use EXIT_NO_ACCESS for system files",
     ],
     EXIT_USER_CANCEL => [
       'code'         => 34,
       'name'         => "EXIT_USER_CANCEL",
       'category'     => "user error",
       'description'  => "user canceled",
     ],
     EXIT_BAD_ENVIRONMENT => [
       'code'         => 40,
       'name'         => "EXIT_BAD_ENVIRONMENT",
       'category'     => "environment error",
       'description'  => "invalid run-time environment; cannot run",
     ],
     EXIT_FILE_MISSING => [
       'code'         => 41,
       'name'         => "EXIT_FILE_MISSING",
       'category'     => "environment error",
       'description'  => "a file (or directory) that is expected to always be available is not available",
       'hint'         => "use EXIT_WRONG_FILE for user nominated files",
     ],
     EXIT_NO_ACCESS => [
       'code'         => 42,
       'name'         => "EXIT_NO_ACCESS",
       'category'     => "environment error",
       'description'  => "a file (or directory) that should be accessible cannot be accessed due to invalid permissions",
       'hint'         => "use EXIT_BAD_FILE for user nominated files",
     ],
     EXIT_BAD_CONFIG => [
       'code'         => 43,
       'name'         => "EXIT_BAD_CONFIG",
       'category'     => "environment error",
       'description'  => "invalid configuration; config file missing or invalid",
     ],
     EXIT_NO_LOCK => [
       'code'         => 44,
       'name'         => "EXIT_NO_LOCK",
       'category'     => "environment error",
       'description'  => "could not acquire lock",
     ],
     EXIT_NO_SERVICE => [
       'code'         => 56,
       'name'         => "EXIT_NO_SERVICE",
       'category'     => "environment error",
       'description'  => "cannot establish connection to a required service",
       'hint'         => "prefer EXIT_NO_DATABASE for database services",
     ],
     EXIT_NO_DATABASE => [
       'code'         => 57,
       'name'         => "EXIT_NO_DATABASE",
       'category'     => "environment error",
       'description'  => "cannot establish connection to a required database",
     ],
     EXIT_EXHAUSTED => [
       'code'         => 58,
       'name'         => "EXIT_EXHAUSTED",
       'category'     => "environment error",
       'description'  => "resources exhausted; out of memory, disk space, inodes, etc",
     ],
     EXIT_OFFLINE => [
       'code'         => 59,
       'name'         => "EXIT_OFFLINE",
       'category'     => "environment error",
       'description'  => "system offline; as configured by administrator",
     ],
     EXIT_BAD_PROGRAM => [
       'code'         => 70,
       'name'         => "EXIT_BAD_PROGRAM",
       'category'     => "program error",
       'description'  => "an unhandled and fatal situation encountered",
     ],
     EXIT_ERROR => [
       'code'         => 71,
       'name'         => "EXIT_ERROR",
       'category'     => "program error",
       'description'  => "an error caused process termination",
     ],
     EXIT_EXCEPTION => [
       'code'         => 72,
       'name'         => "EXIT_EXCEPTION",
       'category'     => "program error",
       'description'  => "an unhandled exception caused process termination",
     ],
     EXIT_ASSERT => [
       'code'         => 73,
       'name'         => "EXIT_ASSERT",
       'category'     => "program error",
       'description'  => "an assertion violation caused process termination",
     ],
     EXIT_TEST_FAILED => [
       'code'         => 74,
       'name'         => "EXIT_TEST_FAILED",
       'category'     => "program error",
       'description'  => "test failed; unit-test did not succeed",
     ],
     EXIT_INVALID => [
       'code'         => 75,
       'name'         => "EXIT_INVALID",
       'category'     => "program error",
       'description'  => "invalid error level; the programmer nominated an invalid error level and the host exited with 85 instead",
     ],
     EXIT_NOT_IMPLEMENTED => [
       'code'         => 80,
       'name'         => "EXIT_NOT_IMPLEMENTED",
       'category'     => "program error",
       'description'  => "functionality not implemented",
     ],
     EXIT_NOT_SUPPORTED => [
       'code'         => 81,
       'name'         => "EXIT_NOT_SUPPORTED",
       'category'     => "program error",
       'description'  => "situation not supported",
     ],
     EXIT_NOT_POSSIBLE => [
       'code'         => 82,
       'name'         => "EXIT_NOT_POSSIBLE",
       'category'     => "program error",
       'description'  => "situation is supposed to be impossible",
     ],
     EXIT_DEBUG => [
       'code'         => 88,
       'name'         => "EXIT_DEBUG",
       'category'     => "program error",
       'description'  => "programmer exited for debugging purposes",
     ],
     EXIT_ABORT => [
       'code'         => 89,
       'name'         => "EXIT_ABORT",
       'category'     => "program error",
       'description'  => "programmer aborted with error message",
     ],
     EXIT_SPECIAL_SUCCESS => [
       'code'         => 90,
       'name'         => "EXIT_SPECIAL_SUCCESS",
       'category'     => "special purpose",
       'description'  => "special operation successful; used for safety (in case improperly invoked)",
     ],
     EXIT_OPTIONS_LISTED => [
       'code'         => 98,
       'name'         => "EXIT_OPTIONS_LISTED",
       'category'     => "special purpose",
       'description'  => "program options listed; use when programs can be invoked to list their options in a machine readable format",
     ],
     EXIT_HELP => [
       'code'         => 99,
       'name'         => "EXIT_HELP",
       'category'     => "special purpose",
       'description'  => "help or version number requested ",
     ],
     EXIT_UNIX_BAD_PERMISSION => [
       'code'         => 126,
       'name'         => "EXIT_UNIX_BAD_PERMISSION",
       'category'     => "UNIX error",
       'description'  => "command was found but could not be executed due to permissions",
     ],
     EXIT_UNIX_BAD_COMMAND => [
       'code'         => 127,
       'name'         => "EXIT_UNIX_BAD_COMMAND",
       'category'     => "UNIX error",
       'description'  => "command not found or could not be executed",
     ],
     EXIT_TERMINATED_BY_SIGNAL => [
       'code'         => 128,
       'name'         => "EXIT_TERMINATED_BY_SIGNAL",
       'category'     => "UNIX error",
       'description'  => "process terminated by signal",
     ],
     EXIT_TERMINATED_BY_CTRLC => [
       'code'         => 130,
       'name'         => "EXIT_TERMINATED_BY_CTRLC",
       'category'     => "UNIX error",
       'description'  => "process terminated by Ctrl+C",
     ],
     EXIT_GENERIC_1 => [
       'code'         => 1,
       'name'         => "EXIT_GENERIC_1",
       'category'     => "general error",
       'description'  => "error during processing",
     ],
     EXIT_GENERIC_2 => [
       'code'         => 2,
       'name'         => "EXIT_GENERIC_2",
       'category'     => "general error",
       'description'  => "error during processing",
     ],
     EXIT_GENERIC_255 => [
       'code'         => 255,
       'name'         => "EXIT_GENERIC_255",
       'category'     => "general error",
       'description'  => "error during processing",
     ],
  ];

  if ( is_int( $argument ) ) {

    $spec = $map[ $argument ] ?? $map[ EXIT_INVALID ];

  }
  elseif ( is_string( $argument ) ) {

    error_log( $argument );

    $spec = $map[ EXIT_ABORT ];

  }
  elseif ( $argument instanceof ErrorException ) {

    $spec = $map[ EXIT_ERROR ];

  }
  elseif ( $argument instanceof AssertionError ) {

    $spec = $map[ EXIT_ASSERT ];

  }
  elseif ( $argument instanceof Throwable ) {

    $spec = $map[ EXIT_EXCEPTION ];

  }
  else {

    $spec = $map[ EXIT_INVALID ];

  }

  $code = $spec[ 'code' ];

  if ( $print_error ) {

    $name = $spec[ 'name' ];
    $category = $spec[ 'category' ];
    $description = $spec[ 'description' ];
    $hint = $spec[ 'hint' ] ?? null;

    if ( $hint && $print_hint ) {

      error_log( "hint: $hint" );

    }

    if ( $is_debug ) {

      error_log( "$category: $description ($name)" );

    }
    else {

      error_log( "$category: $description" );

    }
  }

  exit( $code );

}
