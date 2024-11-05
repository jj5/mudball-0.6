<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_random.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - new token
  //

  'new token' => function() {

    for ( $i = 0; $i < 1000; $i++ ) {

      $token = mud_new_token();

      assert( strlen( $token ) === 48 );

      assert( preg_match( '/^[A-Za-z0-9]{48}$/', $token ) );

      // 2022-01-31 jj5 - echo "$token\n";

    }

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - new seed
  //

  'new seed' => function() {

    for ( $i = 0; $i < 1000; $i++ ) {

      $seed = mud_new_seed();

      assert( $seed >= 1337 );
      assert( $seed <= MUD_MAX_INT32 );

    }

    return 0;

  },

]);
