<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_flags.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-25 jj5 - flags
  //

  'flags' => function() {

    // 2021-02-25 jj5 - here we use regular flags, being incremental powers of two...
    //
    $flag_a = pow( 2, 0 );
    $flag_b = pow( 2, 1 );
    $flag_c = pow( 2, 2 );
    $flag_d = pow( 2, 3 );

    $flags = 0;

    assert( ! mud_has_flag( $flags, $flag_a ) );
    assert( ! mud_has_flag( $flags, $flag_b ) );
    assert( ! mud_has_flag( $flags, $flag_c ) );
    assert( ! mud_has_flag( $flags, $flag_d ) );
    assert( $flags === 0 );

    $flags = mud_set_flag( $flags, $flag_a, true );
    $flags = mud_set_flag( $flags, $flag_b, true );
    $flags = mud_set_flag( $flags, $flag_c, true );
    $flags = mud_set_flag( $flags, $flag_d, true );

    assert( mud_has_flag( $flags, $flag_a ) );
    assert( mud_has_flag( $flags, $flag_b ) );
    assert( mud_has_flag( $flags, $flag_c ) );
    assert( mud_has_flag( $flags, $flag_d ) );
    assert( $flags === $flag_a + $flag_b + $flag_c + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_c | $flag_d );

    $flags = mud_set_flag( $flags, $flag_a, false );
    $flags = mud_set_flag( $flags, $flag_b, false );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, false );

    assert( ! mud_has_flag( $flags, $flag_a ) );
    assert( ! mud_has_flag( $flags, $flag_b ) );
    assert( ! mud_has_flag( $flags, $flag_c ) );
    assert( ! mud_has_flag( $flags, $flag_d ) );
    assert( $flags === 0 );

    $flags = mud_set_flag( $flags, $flag_a, false );
    $flags = mud_set_flag( $flags, $flag_b, true  );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, true  );
    assert( $flags === $flag_b + $flag_d );
    assert( $flags === $flag_b | $flag_d );

    $flags = mud_set_flag( $flags, $flag_a + $flag_b, true );

    $flags = mud_set_flag( $flags, $flag_a, true  );
    $flags = mud_set_flag( $flags, $flag_b, true  );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, true  );
    assert( $flags === $flag_a + $flag_b + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_d );

    $flags = mud_set_flag( $flags, $flag_c + $flag_d, true );

    $flags = mud_set_flag( $flags, $flag_a, true );
    $flags = mud_set_flag( $flags, $flag_b, true );
    $flags = mud_set_flag( $flags, $flag_c, true );
    $flags = mud_set_flag( $flags, $flag_d, true );
    assert( $flags === $flag_a + $flag_b + $flag_c + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_c | $flag_d );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-25 jj5 - irregular flags
  //

  'irregular flags' => function() {

    // 2021-02-25 jj5 - here we use irregular flags, being noncontiguous powers of two...
    //
    $flag_a = pow( 2, 2 );
    $flag_b = pow( 2, 5 );
    $flag_c = pow( 2, 7 );
    $flag_d = pow( 2, 8 );

    $flags = 0;

    assert( ! mud_has_flag( $flags, $flag_a ) );
    assert( ! mud_has_flag( $flags, $flag_b ) );
    assert( ! mud_has_flag( $flags, $flag_c ) );
    assert( ! mud_has_flag( $flags, $flag_d ) );
    assert( $flags === 0 );

    $flags = mud_set_flag( $flags, $flag_a, true );
    $flags = mud_set_flag( $flags, $flag_b, true );
    $flags = mud_set_flag( $flags, $flag_c, true );
    $flags = mud_set_flag( $flags, $flag_d, true );

    assert( mud_has_flag( $flags, $flag_a ) );
    assert( mud_has_flag( $flags, $flag_b ) );
    assert( mud_has_flag( $flags, $flag_c ) );
    assert( mud_has_flag( $flags, $flag_d ) );
    assert( $flags === $flag_a + $flag_b + $flag_c + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_c | $flag_d );

    $flags = mud_set_flag( $flags, $flag_a, false );
    $flags = mud_set_flag( $flags, $flag_b, false );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, false );

    assert( ! mud_has_flag( $flags, $flag_a ) );
    assert( ! mud_has_flag( $flags, $flag_b ) );
    assert( ! mud_has_flag( $flags, $flag_c ) );
    assert( ! mud_has_flag( $flags, $flag_d ) );
    assert( $flags === 0 );

    $flags = mud_set_flag( $flags, $flag_a, false );
    $flags = mud_set_flag( $flags, $flag_b, true  );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, true  );
    assert( $flags === $flag_b + $flag_d );
    assert( $flags === $flag_b | $flag_d );

    $flags = mud_set_flag( $flags, $flag_a + $flag_b, true );

    $flags = mud_set_flag( $flags, $flag_a, true  );
    $flags = mud_set_flag( $flags, $flag_b, true  );
    $flags = mud_set_flag( $flags, $flag_c, false );
    $flags = mud_set_flag( $flags, $flag_d, true  );
    assert( $flags === $flag_a + $flag_b + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_d );

    $flags = mud_set_flag( $flags, $flag_c + $flag_d, true );

    $flags = mud_set_flag( $flags, $flag_a, true );
    $flags = mud_set_flag( $flags, $flag_b, true );
    $flags = mud_set_flag( $flags, $flag_c, true );
    $flags = mud_set_flag( $flags, $flag_d, true );
    assert( $flags === $flag_a + $flag_b + $flag_c + $flag_d );
    assert( $flags === $flag_a | $flag_b | $flag_c | $flag_d );

    return 0;

  },

]);
