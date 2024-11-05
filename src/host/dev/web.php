<?php

require_once __DIR__ . '/inc/common.php';

function declare_tests() {

  error_reporting( ~0 );

  set_error_handler( 'handle_error', ~0 );
  set_exception_handler( 'handle_exception' );

  assert_options( ASSERT_ACTIVE, 1 );
  assert_options( ASSERT_WARNING, 0 );

  // 2022-11-09 jj5 - OLD: this is no longer supported...
  //assert_options( ASSERT_QUIET_EVAL, 1 );

  assert_options( ASSERT_CALLBACK, 'handle_assertion_violation' );

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

  mud_buffer_start();

  $test = $_GET[ 'test' ] ?? null;

  $tests = [];

  foreach ( $input as $key => $val ) {

    $tests[ str_replace( ' ', '-', $key ) ] = $val;

  }

  $function = $tests[ $test ] ?? null;

  if ( $function === null ) {

    render_head();

    echo "<h1>Tests</h1>\n";

    echo "<ul>\n";

    foreach ( $tests as $key => $val ) {

      echo "<li><a href='?test=" . henc( $key ) . "'>" . henc( $key ) . "</a></li>\n";

    }

    echo "</ul>\n";

    render_foot();

    return;

  }

  try {

    render_head();

    echo "<h1>" . henc( $test ) . "</h1>\n";

    $result = $function( $context );

    var_dump( $result );

    render_foot();

  }
  catch ( Throwable $ex ) {

    //report_problem( $ex->getMessage(), $ex->getFile(), $ex->getLine() );

    handle_exception( $ex );

  }
}

function henc( $value ) { return htmlentities( $value, ENT_QUOTES ); }

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

  throw new_php_error_exception( $message, 0, $severity, $file, $line );

}

function handle_exception( $ex ) {

  //report_problem( $ex->getMessage(), $ex->getFile(), $ex->getLine() );

  mud_buffer_reset();

  render_head();

  echo "<h1>Exception</h1>\n";

  echo '<pre>' . mud_module_pclog()->report_exception( $ex ) . "</pre>\n";

  render_foot();

  exit( 1 );

}

function handle_assertion_violation(
  $file,
  $line,
  $assertion,
  $description = null
) {

  report_problem( $description, $file, $line );

}

function report_problem( $message, $file, $line ) {

  mud_buffer_reset();

  render_head();

  echo "<h1>Error</h1>\n";

  echo '<p>' . henc( "{$file}[$line]: $message" ) . "</p>\n";

  render_foot();

  exit( 1 );

}

function render_head() {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mudball web tests</title>
    <meta charset="UTF-8">
  </head>
  <body>
    <p><a href="?">Tests</a></p>
<?php
}

function render_foot() {
?>
  </body>
</html>
<?php
}
