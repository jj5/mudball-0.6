<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_general.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - init
  //

  'init' => function() {

    // 2021-02-25 jj5 - this will do a bunch of good things to initialize your PHP environment so
    // call it early in your program.
    //
    mud_init();

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - abort
  //

  'abort' => function() {

    mud_expect_exit( 'MUD_EXIT_ABORT' );

    mud_abort( 'just testing...' );

    assert( false );

  },

]);
