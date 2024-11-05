<?php

define( 'DEV', true );
define( 'DEBUG', true );
define( 'TEST', true );

// 2024-02-16 jj5 - SEE: https://www.jj5.net/wiki/Error_levels
define( 'MUD_EXIT_SUCCESS', 0 );
define( 'MUD_EXIT_EXCEPTION', 82 );
define( 'MUD_EXIT_INVALID', 85 );

require_once __DIR__ . '/../../../inc/example.php';

function declare_tests() {
  
  $args = func_get_args();

  error_reporting( ~0 );

  set_error_handler( 'handle_error', ~0 );
  set_exception_handler( 'handle_exception' );

  $arg_a = $args[ 0 ] ?? null;
  $arg_b = $args[ 1 ] ?? null;

  if ( is_array( $arg_a ) ) {

    $input = $arg_a;
    $context = $arg_b;

  }
  else {

    $input = $arg_b;
    $context = $arg_a;

  }

  global $argv;

  $test = $argv[ 1 ] ?? null;

  $tests = [];

  foreach ( $input as $key => $val ) {

    $tests[ str_replace( ' ', '-', $key ) ] = $val;

  }

  $function = $tests[ $test ] ?? function() use( $tests ) {

    echo implode( "\n", array_keys( $tests ) ) . "\n";

    return 0;

  };

  try {

    $result = $function( $context );

    if ( is_int( $result ) ) { exit( $result ); }

    var_dump( $result );

    echo "Did you forget to return an error level?\n";

    exit( MUD_EXIT_INVALID );

  }
  catch ( Throwable $ex ) {

    report_exception( $ex );

    exit( MUD_EXIT_EXCEPTION );

  }
}

function report_exception( $ex ) {

  echo $ex->getMessage() . "\n";

}

function handle_error(
  $severity,
  $message,
  $file,
  $line,
  $context = null
) {

  // 2019-08-05 jj5 - if error reporting is disabled don't throw...
  //
  if ( error_reporting() === 0 ) { return; }

  if ( function_exists( 'new_php_error_exception' ) ) {

    throw new_php_error_exception( $message, 0, $severity, $file, $line );

  }

  throw new ErrorException( $message, 0, $severity, $file, $line );

}

function handle_exception( $ex ) {

  report_exception( $ex );

  exit( MUD_EXIT_EXCEPTION );

}
