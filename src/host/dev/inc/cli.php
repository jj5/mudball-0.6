<?php

require_once __DIR__ . '/common.php';

function mud_expect_exit( $code_or_name ) {

  $code = mud_exit_get_code( $code_or_name );
  $name = mud_exit_get_name( $code_or_name );

  $message = MUD_ANSI_YELLOW . 'expect error level ' . $name . ': ' . $code . MUD_ANSI_END;

  echo "$message\n";

}

function declare_things( bool $catch, array $args ) {

  if ( $catch ) {

    error_reporting( ~0 );

    set_error_handler( 'handle_error', ~0 );
    set_exception_handler( 'handle_exception' );

  }

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

  if ( $catch ) {

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
  else {

    $result = $function( $context );

    if ( is_int( $result ) ) { exit( $result ); }

    var_dump( $result );

    exit( MUD_EXIT_INVALID );

  }
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

/*
function handle_assertion_violation(
  $file,
  $line,
  $assertion,
  $description = null
) {

  report_problem( $description, $file, $line );

  exit( MUD_EXIT_ASSERT );

}
*/

function report_exception( $ex ) {

  echo mud_module_pclog()->report_exception( $ex );

  return;



  report_problem( $ex->getMessage(), $ex->getFile(), $ex->getLine() );

  if ( is_a( $ex, 'MudException' ) ) {

    var_dump( $ex->getData() );

  }

  // 2021-03-04 jj5 - you can dump a trace if that's helpful...
  //
  //var_dump( $ex->getTrace() );

}

function report_problem( $message, $file, $line ) {

  echo "{$file}[$line]: $message\n";

}
