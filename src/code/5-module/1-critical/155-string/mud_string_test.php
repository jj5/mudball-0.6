<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-28 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_string.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-28 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-28 jj5 - mud_format() tests...
  //

  'mud_format' => function() {

    $test_datetime = "2021-03-28 00:56:57";

    $datetime = new DateTime( $test_datetime );

    assert( mud_format( null ) === '' );

    assert( mud_format( true ) === 'true' );

    assert( mud_format( false ) === 'false' );

    assert( mud_format( 1 ) === '1' );

    assert( mud_format( 123456 ) === '123,456' );

    assert( mud_format( 1.234 ) === '1.23' );

    assert( mud_format( $datetime ) === $test_datetime );

    assert( mud_format( 0 ) === '0' );

    assert( mud_format( -0 ) === '0' );

    assert( mud_format( 0.0 ) === '0' );

    assert( mud_format( -0.0 ) === '0' );

    return 0;

  },

  'mud_unicode_normalize' => function() {

    $data = explode( "\n", file_get_contents( __FILE__ ) );

    // 2022-04-10 jj5 - this source file is ASCII so this should be true:
    //
    assert( $data === mud_unicode_normalize( $data ) );

    return 0;

  },

  'escape' => function() {

    $result = mud_escape( "'1 2 3'" );

    assert( $result === "\\'1 2 3\\'" );
    
    return 0;

  },

  'quote' => function() {

    $result = mud_quote( "'1 2 3'" );

    assert( $result === "'\\'1 2 3\\''" );
    
    $result = mud_escape( "\0\n\r\t\x0B" );

    assert( $result === "\\0\\n\\r\\t\\v" );

    $result = mud_escape( "\0\t\n\v\f\r\e" );

    assert( $result === "\\0\\t\\n\\v\\f\\r\\e" );

    try {

      mud_escape( "\x80\x80\x80" );

      assert( false );

    }
    catch ( Exception $ex ) {

      assert( $ex->getMessage() === "error while processing: requirement violated." );

      return 0;

    }

    return 1;

  },


]);
