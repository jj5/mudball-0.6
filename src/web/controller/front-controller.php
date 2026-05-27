<?php

ob_start();

require_once __DIR__ . '/../../code/1-bootstrap/9-keystone.php';

(function() {

  $debug = defined( 'DEBUG' ) && DEBUG;

  if ( $debug ) {

    $request_uri = $_SERVER[ 'REQUEST_URI' ];

    error_log( 'init: ' . $request_uri );

  }

  ( new MudControllerWeb() )->run();

  if ( $debug ) {

    error_log( 'done: ' . $request_uri );

  }

})();
