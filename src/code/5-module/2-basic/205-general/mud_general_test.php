<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_general.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - init
  //

  'init' => function() {

    mud_init();

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-25 jj5 - is bool name
  //

  'is bool name' => function() {

    static $pos_tests = [
      'a_is_funny', 'is_funny',
      'a_has_joke', 'has_joke',
      'a_was_kidding', 'was_kidding',
      'a_can_laugh', 'can_laugh',
      'a_should_probably_not', 'should_probably_not',
    ];

    static $neg_tests = [ '', 'not', 'not this either' ];

    foreach ( $pos_tests as $name ) {

      assert( mud_is_bool_name( $name ) );

    }

    foreach ( $neg_tests as $name ) {

      assert( ! mud_is_bool_name( $name ) );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - assert false
  //

  'assert false' => function() {

    try {

      mud_assert( false );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_GENERAL );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - assert true
  //

  'assert true' => function() {

    try {

      mud_assert( true );

      assert( true );

    }
    catch ( MudException $ex ) {

      assert( false );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - assert custom
  //

  'assert custom' => function() {

    try {

      mud_assert( 1 === 2, 'this is a custom error', [ 'with' => 'data' ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_GENERAL );

      assert( $ex->getMessage() === 'this is a custom error' );

      assert( $ex->getData() === [ 'with' => 'data' ] );

    }

    return 0;

  },

]);
