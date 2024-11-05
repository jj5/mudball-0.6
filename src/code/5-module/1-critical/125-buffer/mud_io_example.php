<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_io.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - start and flush
  //

  'start and flush' => function() {

    mud_buffer_start();

    echo "this is the output\n";

    mud_buffer_flush();

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - start and flush or clear
  //

  'start and flush or clear' => function() {

    mud_buffer_start();

    echo "this is the output\n";

    if ( random_int( 1, 2 ) % 2 === 1 ) {

      // 2021-02-24 jj5 - send the output...
      //
      mud_buffer_flush();

    }
    else {

      // 2021-02-24 jj5 - don't sent the output...
      //
      mud_buffer_clear();

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - start and abandon
  //

  'start and abandon' => function() {

    mud_buffer_start();

    echo "this output will be sent\n";

    // 2021-02-24 jj5 - the above output will be sent by default as we don't further modify the
    // buffer so it will be flushed at the end of our process.

    return 0;

  },

]);
