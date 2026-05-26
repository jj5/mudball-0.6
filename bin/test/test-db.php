#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../debug.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../inc/framework/cli.php';

function main( $argv ) {

  if ( DB_CERT ) {

    if ( ! file_exists( DB_CERT ) ) {

      echo "Certificate file not found: " . DB_CERT . "\n";
      exit( 1 );

    }
  }

  $std = mud_declare_schema( 'std', 'mudballdb', __DIR__ . '/../../src/code/6-schema/mudballdb' );
  $bus = mud_declare_schema( 'bus', 'demodb', __DIR__ . '/../../src/code/6-schema/demodb' );

  $db = mud_declare_database( [ $std, $bus ] );

  $connection = $db->get_connection( MudConnectionTypeLite::DBA );

  $row = $connection->query( "show status like 'Ssl_cipher'" );

  var_dump( $row );

}

main( $argv );
