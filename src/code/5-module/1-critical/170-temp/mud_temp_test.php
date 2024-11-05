<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_temp.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - managed temp file...
  //

  'managed temp file' => function() {

    $tmp_file = mud_get_temp_file();

    assert( file_exists( $tmp_file ) );

    mud_module_temp()->shutdown();

    assert( ! file_exists( $tmp_file ) );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - unmanaged temp file...
  //

  'unmanaged temp file' => function() {

    $tmp_file = mud_get_temp_file( $managed = false );

    assert( file_exists( $tmp_file ) );

    mud_module_temp()->shutdown();

    assert( file_exists( $tmp_file ) );

    mud_unlink( $tmp_file );

    return 0;

  },

]);
