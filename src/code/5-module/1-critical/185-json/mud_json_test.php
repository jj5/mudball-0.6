<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_json.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - test context...
//

class TestContext {

  public function test_encode( $test_list, $func ) {

    foreach ( $test_list as $test_data ) {

      $test_json = $test_data[ 0 ];
      $expect_data = $test_data[ 1 ];
      $expect_json = $test_data[ 2 ] ?? $test_json;

      //var_dump( $test_json ); var_dump( $expect_data );

      $data = mud_json_decode( $test_json );

      //var_dump( $data );

      assert( $data === $expect_data );

      $json = $func( $data );

      if ( $expect_json === false ) { continue; }

      //var_dump( $test_json ); var_dump( $json );

      if ( $json !== $expect_json ) {

        var_dump([
          'json' => $json,
          'expect_json' => $expect_json,
        ]);

      }

      assert( $json === $expect_json );

    }

    return 0;

  }
}

/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests(

  new TestContext, [


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - encode and decode pretty print
  //

  'encode and decode pretty print' => function( $context ) {

    static $test_list = [
      [ 'null'               , null                                     ],
      [ 'true'               , true                                     ],
      [ 'false'              , false                                    ],
      [ '0'                  , 0                                        ],
      [ '1'                  , 1                                        ],
      [ '1.1'                , 1.1,                               '1.1' ],
      [ '""'                 , ''                                       ],
      [ '"test"'             , 'test'                                   ],
      [ '"/home/jj5/desktop"', '/home/jj5/desktop'                      ],
      [ '[0,1,2,3]'          , [ 0, 1, 2, 3 ],                    false ],
      [ '{"a":1,"b":2,"c":3}', [ 'a' => 1, 'b' => 2, 'c' => 3 ],  false ],
    ];

    return $context->test_encode( $test_list, 'mud_json_pretty' );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - encode and decode in compact format
  //

  'encode and decode in compact format' => function( $context ) {

    static $test_list = [
      [ 'null'               , null                                     ],
      [ 'true'               , true                                     ],
      [ 'false'              , false                                    ],
      [ '0'                  , 0                                        ],
      [ '1'                  , 1                                        ],
      [ '1.1'                , 1.1,                               '1.1' ],
      [ '""'                 , ''                                       ],
      [ '"test"'             , 'test'                                   ],
      [ '"/home/jj5/desktop"', '/home/jj5/desktop'                      ],
      [ '[0,1,2,3]'          , [ 0, 1, 2, 3 ],                          ],
      [ '{"a":1,"b":2,"c":3}', [ 'a' => 1, 'b' => 2, 'c' => 3 ],        ],
    ];

    return $context->test_encode( $test_list, 'mud_json_compact' );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - encode and decode in ASCII format
  //

  'encode and decode in ASCII format' => function( $context ) {

    static $test_list = [
      [ 'null'               , null                                     ],
      [ 'true'               , true                                     ],
      [ 'false'              , false                                    ],
      [ '0'                  , 0                                        ],
      [ '1'                  , 1                                        ],
      [ '1.1'                , 1.1,                               '1.1' ],
      [ '""'                 , ''                                       ],
      [ '"test"'             , 'test'                                   ],
      [ '"/home/jj5/desktop"', '/home/jj5/desktop'                      ],
      [ '[0,1,2,3]'          , [ 0, 1, 2, 3 ],                          ],
      [ '{"a":1,"b":2,"c":3}', [ 'a' => 1, 'b' => 2, 'c' => 3 ],        ],
    ];

    return $context->test_encode( $test_list, 'mud_json_ascii' );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - encode and decode in HTML/script embed format
  //

  'encode and decode in HTML/script embed format' => function( $context ) {

    static $test_list = [
      [ 'null'               , null                                                           ],
      [ 'true'               , true                                                           ],
      [ 'false'              , false                                                          ],
      [ '0'                  , 0                                                              ],
      [ '1'                  , 1                                                              ],
      [ '1.1'                , 1.1,                               '1.1'                       ],
      [ '""'                 , ''                                                             ],
      [ '"test"'             , 'test'                                                         ],
      [ '"/home/jj5/desktop"', '/home/jj5/desktop',               '"\\/home\\/jj5\\/desktop"' ],
      [ '[0,1,2,3]'          , [ 0, 1, 2, 3 ],                                                ],
      [ '{"a":1,"b":2,"c":3}', [ 'a' => 1, 'b' => 2, 'c' => 3 ],                              ],
    ];

    return $context->test_encode( $test_list, 'mud_json_embed' );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - encoding fails on recursive data
  //

  'encoding fails on recursive data' => function( $context ) {

    $func_list = [ 'mud_json_pretty', 'mud_json_compact', 'mud_json_ascii', 'mud_json_embed' ];

    $data = new stdClass;
    $data->recurse = $data;

    foreach ( $func_list as $func ) {

      try {

        // 2021-03-04 jj5 - if we ask for partial output on error then we should get partial
        // output and no error...
        //
        $json = $func( $data, JSON_PARTIAL_OUTPUT_ON_ERROR );

        assert( true );

        // 2021-03-04 jj5 - when we don't ask for partial output on error then the encoding
        // should fail with an exception...
        //
        $json = $func( $data );

        assert( false );

      }
      catch ( Exception $ex ) {

        assert( $ex->getCode() === MUD_ERR_JSON_ENCODING_ERROR );
        assert( $ex->getData()[ 'error' ] === 6 );
        assert( $ex->getData()[ 'error_msg' ] === 'Recursion detected' );

        continue;

      }

      assert( false );

    }

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - decoding invalid JSON fails
  //

  'decoding invalid JSON fails' => function( $context ) {

    static $invalid_list = [ '', '***NOT JSON***' ];

    foreach ( $invalid_list as $invalid_json ) {

      try {

        $data = mud_json_decode( $invalid_json );

        assert( false );

      }
      catch ( Exception $ex ) {

        assert( $ex->getCode() === MUD_ERR_JSON_DECODING_ERROR );
        assert( $ex->getData()[ 'error' ] === 4 );
        assert( $ex->getData()[ 'error_msg' ] === 'Syntax error' );

        continue;

      }

      assert( false );

    }

    return 0;

  },

]);
