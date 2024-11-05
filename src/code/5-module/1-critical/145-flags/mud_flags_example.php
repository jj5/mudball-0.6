<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_flags.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - flags usage
  //

  'flags usage' => function() {

    $flag_a = pow( 2, 0 );
    $flag_b = pow( 2, 1 );
    $flag_c = pow( 2, 2 );

    $flags = $flag_a | $flag_c;

    assert( mud_has_flag( $flags, $flag_a ) );
    assert( ! mud_has_flag( $flags, $flag_b ) );
    assert( mud_has_flag( $flags, $flag_c ) );

    $flags = mud_set_flag( $flags, $flag_b );
    $flags = mud_set_flag( $flags, $flag_c, false );

    assert( mud_has_flag( $flags, $flag_a ) );
    assert( mud_has_flag( $flags, $flag_b ) );
    assert( ! mud_has_flag( $flags, $flag_c ) );

    return 0;

  },

]);
