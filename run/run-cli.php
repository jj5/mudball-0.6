<?php

require_once __DIR__ . '/../inc/framework/cli.php';

function mud_host_cli( $argv ) {

  error_reporting( ~0 );

  $error_handler = function_exists( 'app_handle_error' ) ? 'app_handle_error' : 'mud_handle_error';

  set_error_handler( $error_handler );

  try {

    main( $argv );

  }
  catch ( Throwable $ex ) {

    error_log( $ex->getMessage() );

    throw $ex;

  }
}

mud_host_cli( $argv );
