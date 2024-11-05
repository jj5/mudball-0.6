<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-10 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_cache.php';
require_once __DIR__ . '/test/common.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - define some constants...
//

define( 'TEST_CACHE_NAME', 'play-cache' );
define( 'TEST_CACHE_SPIN', 50000 );
define( 'APP_CACHE_DIR', '/dev/shm' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-10 jj5 - declare tests...
//

declare_tests([

  'cache spin single' => function() {

    mud_init();

    mud_log_init_stderr( MUD_LOG_LEVEL_7_DEBUG );

    run_test( 1 );

    return 0;

  },

  'cache spin multiple' => function() {

    mud_init();

    mud_log_init_stderr( MUD_LOG_LEVEL_7_DEBUG );

    run_test( 10 );

    return 0;

  },

]);

function run_dal( $thread ) {

  $cache = new_mud_cache( TEST_CACHE_NAME );

  for ( $n = 1; $n <= TEST_CACHE_SPIN; $n++ ) {

    $container = 'test-container-' . substr( md5( microtime() ), -1 );

    $id =  substr( md5( microtime() ), -5 );

    // 2021-04-11 jj5 - NOTE: the value must always be the same for any given ID, so we base
    // our example values on the hash of the ID...
    //
    $input = md5( $id );

    if ( $cache->read( $container, $id, $cache_key, $result ) ) {

      // we already have the value

      assert( $result === $input );

    }
    else {

      $cache->write( $container, $cache_key, $input );

      //assert( $cache->read( $container, $id, $cache_key, $result ) );

      //assert( $result === $input );

    }
  }

  if ( $thread === 1 ) { $cache->report(); }

}
