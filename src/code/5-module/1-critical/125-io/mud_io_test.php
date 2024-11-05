<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_io.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - start reset clear
  //

  'start reset clear' => function() {

    mud_buffer_start();

    echo "this will be discarded\n";

    mud_buffer_reset();

    echo "this will be retained\n";

    $result = mud_buffer_clear( $length, $return = true );

    assert( $result === "this will be retained\n" );
    assert( mud_module_io()->get_total_flushed_bytes() === 0 );
    assert( mud_module_io()->get_total_cleared_bytes() === 45 );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - start reset flush
  //

  'start reset flush' => function() {

    mud_buffer_start();

    echo "this will be discarded\n";

    mud_buffer_reset();

    echo "this will be retained and flushed\n";

    $result = mud_buffer_flush( $length, $return = true );

    assert( $result === "this will be retained and flushed\n" );
    assert( mud_module_io()->get_total_flushed_bytes() === 34 );
    assert( mud_module_io()->get_total_cleared_bytes() === 23 );

    return 0;

  },

]);
