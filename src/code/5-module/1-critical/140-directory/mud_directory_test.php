<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_directory.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - declare tests...
//

declare_tests([

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - pushd and popd...
  //

  'pushd and popd' => function() {

    $init_cwd = getcwd();

    mud_pushd( '/tmp' );

    assert( '/tmp' === getcwd() );

    mud_pushd( '/home/jj5/desktop' );

    assert( '/home/jj5/desktop' === getcwd() );

    mud_pushd( '..' );

    assert( '/home/jj5' === getcwd() );

    mud_popd();

    assert( '/home/jj5/desktop' === getcwd() );

    mud_popd();

    assert( '/tmp' === getcwd() );

    mud_popd();

    assert( $init_cwd === getcwd() );

    return 0;

  },


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - no more popd...
  //

  'no more popd' => function() {

    try {

      // 2021-04-11 jj5 - if you popd with an empty directory stack, that's an error...

      mud_popd();

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_DIRECTORY_IS_INVALID );

    }

    return 0;

  },


]);
