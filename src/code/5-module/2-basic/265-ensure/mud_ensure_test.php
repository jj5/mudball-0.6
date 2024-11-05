<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_ensure.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - happy path
  //

  'happy path' => function() {

    mud_module_ensure()->is_string( '' );
    mud_module_ensure()->is_string( '0' );
    mud_module_ensure()->is_string( '123' );
    mud_module_ensure()->is_string( 'string' );

    mud_module_ensure()->is_not_string( null );
    mud_module_ensure()->is_not_string( true );
    mud_module_ensure()->is_not_string( false );
    mud_module_ensure()->is_not_string( 0 );
    mud_module_ensure()->is_not_string( 123 );
    mud_module_ensure()->is_not_string( [] );
    mud_module_ensure()->is_not_string( [ 1, 2, 3 ] );
    mud_module_ensure()->is_not_string( [ 'a' => 1, 'b' => 2 ] );
    mud_module_ensure()->is_not_string( new DateTime() );
    mud_module_ensure()->is_not_string( function() { return ''; } );

    mud_module_ensure()->is_array( [] );
    mud_module_ensure()->is_array( [ 1, 2, 3 ] );
    mud_module_ensure()->is_array( [ 'a' => 1, 'b' => 2 ] );

    mud_module_ensure()->is_not_array( null );
    mud_module_ensure()->is_not_array( true );
    mud_module_ensure()->is_not_array( false );
    mud_module_ensure()->is_not_array( 0 );
    mud_module_ensure()->is_not_array( 123 );
    mud_module_ensure()->is_not_array( '' );
    mud_module_ensure()->is_not_array( '0' );
    mud_module_ensure()->is_not_array( '123' );
    mud_module_ensure()->is_not_array( 'string' );
    mud_module_ensure()->is_not_array( new DateTime() );
    mud_module_ensure()->is_not_array( function() { return []; } );

    mud_module_ensure()->is_empty( null );
    mud_module_ensure()->is_empty( false );
    mud_module_ensure()->is_empty( 0 );
    mud_module_ensure()->is_empty( '' );
    mud_module_ensure()->is_empty( '0' );
    mud_module_ensure()->is_empty( [] );

    mud_module_ensure()->is_not_empty( true );
    mud_module_ensure()->is_not_empty( 123 );
    mud_module_ensure()->is_not_empty( '123' );
    mud_module_ensure()->is_not_empty( 'string' );
    mud_module_ensure()->is_not_empty( [ 1, 2, 3 ] );
    mud_module_ensure()->is_not_empty( [ 'a' => 1, 'b' => 2 ] );
    mud_module_ensure()->is_not_empty( new DateTime() );
    mud_module_ensure()->is_not_empty( function() { return []; } );

    mud_module_ensure()->is_defined( 'PHP_INT_MAX' );
    mud_module_ensure()->is_defined( 'MUD_DEFAULT_VARIABLE' );

    mud_module_ensure()->is_not_defined( '' );
    mud_module_ensure()->is_not_defined( '0' );
    mud_module_ensure()->is_not_defined( '123' );
    mud_module_ensure()->is_not_defined( 'string' );

    return 0;

  },

]);
