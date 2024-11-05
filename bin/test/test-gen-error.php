#!/usr/bin/env php
<?php

define( 'DEBUG', true );

require_once __DIR__ . '/../../src/gen/error/errors.php';

$type = $argv[ 1 ];
$code = intval( $argv[ 2 ] );
$const = $argv[ 3 ];

try {

  switch ( $type ) {

    case 'code' : my_exit( $code );

    case 'quiet' : my_exit( $code, $print_error = false, $print_hint = false );

    case 'error' : throw new ErrorException();

    case 'exception' : throw new Exception;

    case 'assertion' : assert( false );

    case 'string' : my_exit( 'test error message' );

  }

  my_exit( EXIT_ABORT );

}
catch ( Throwable $ex ) {

  my_exit( $ex );

}
