<?php

define( 'TEST_CONFIG', realpath( __DIR__ . '/../../../../etc/test/config.php' ) );

if ( file_exists( TEST_CONFIG ) ) { require_once TEST_CONFIG; }

require_once __DIR__ . '/../../../../inc/example.php';

<<<<<<< HEAD
/*
=======
>>>>>>> e3a066e (Work, work...)
(function() {

  foreach ( [ 'DEBUG', 'DEV', 'TEST' ] as $const ) {

    if ( defined( $const ) ) { continue; }

    define( $const, true );

  }
})();
<<<<<<< HEAD
*/
=======
>>>>>>> e3a066e (Work, work...)

require_once __DIR__ . '/../../../../src/code/5-module/1-critical/190-pclog/mud_pclog.php';
