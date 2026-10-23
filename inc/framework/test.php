<?php declare(strict_types=1);

// 2026-10-23 jj5 - report all PHP errors.
error_reporting( E_ALL );

// 2026-10-23 jj5 - convert PHP errors into exceptions.
set_error_handler(

  function ( int $severity, string $message, string $file, int $line ): bool {

    if ( ! ( error_reporting() & $severity ) ) { return false; }

    throw new ErrorException( $message, 0, $severity, $file, $line );

  }
);

if ( ! defined( 'TEST' ) ) { define( 'TEST', true ); }

if ( TEST ) {

  if ( ! defined( 'DEBUG' ) ) { define( 'DEBUG', true ); }

  if ( ! defined( 'PROD' ) ) { define( 'PROD', false ); }
  if ( ! defined( 'BETA' ) ) { define( 'BETA', false ); }
  if ( ! defined( 'DEV' ) ) { define( 'DEV', true ); }

}

if ( defined( 'DEBUG' ) && DEBUG ) {

  // 2026-10-23 jj5 - display errors (DEBUG only).
  ini_set( 'display_errors', '1' );
  ini_set( 'display_startup_errors', '1' );

}

function mud_declare_tests() {

  $zend_assertions = intval( ini_get( 'zend.assertions' ) );
  $assert_exception = intval( ini_get( 'assert.exception' ) );

  if ( $zend_assertions !== 1 || $assert_exception !== 1 ) {

    throw new RuntimeException( 'Assertions not properly configured' );

  }

  $args = func_get_args();

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

    error_log( "Did you forget to return an error level?" );

    $mud_exit_invalid = 85;

    exit( $mud_exit_invalid );

  }
  catch ( Throwable $ex ) {

    error_log( $ex->getMessage() );

    $mud_exit_exception = 82;

    exit( $mud_exit_exception );

  }
}
