<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_retry.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - chdir
  //

  'chdir' => function() {

    $cwd = getcwd();

    // 2021-04-11 jj5 - if you run this script from /tmp you're gonna have bad time...
    //
    assert( $cwd !== '/tmp' );

    // 2021-04-11 jj5 - this is an example of calling with a closure...
    //
    mud_retry( function( $path ) { return @chdir( $path ); }, [ '/tmp' ] );

    assert( getcwd() === '/tmp' );

    chdir( $cwd );

    assert( $cwd !== '/tmp' );

    // 2021-04-11 jj5 - this does the same as above but directly without the wrapper...
    //
    mud_retry( 'chdir', [ '/tmp' ] );

    assert( getcwd() === '/tmp' );

    chdir( $cwd );

    return 0;

  },

]);
