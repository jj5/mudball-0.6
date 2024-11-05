<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_random.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - new token
  //

  'new token' => function() {

    $token = mud_new_token();

    assert( strlen( $token ) === 32 );

    $token = mud_new_token( 12 );

    assert( strlen( $token ) === 12 );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - new seed
  //

  'new token' => function() {

    $seed = mud_new_seed();

    assert( $seed >= 1337 );
    assert( $seed <= MUD_MAX_INT32 );

    return 0;

  },

]);
