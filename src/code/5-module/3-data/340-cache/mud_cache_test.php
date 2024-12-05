<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-10 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_cache.php';
require_once __DIR__ . '/test/common.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - define some constants...
//

define( 'TEST_CACHE_NAME', 'test-cache' );
define( 'TEST_CACHE_SPIN', 10000 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-10 jj5 - declare tests...
//

declare_tests([

  'cache test single' => function() {

    mud_init();

    mud_log_init_stderr( MUD_LOG_LEVEL_7_DEBUG );

    run_test( 1 );

    return 0;

  },

  'cache test multiple' => function() {

    mud_init();

    mud_log_init_stderr( MUD_LOG_LEVEL_7_DEBUG );

    run_test( 10 );

    return 0;

  },

  'binary cache' => function() {

    $cache = new_mud_cache( TEST_CACHE_NAME );

    $container = 'test-container';

    $id =  mud_hash( microtime(), $raw = true );

    $input = mud_hash( $id, $raw = true );

    if ( $cache->read( $container, $id, $cache_key, $result ) ) {

      assert( false );

    }
    else {

      $cache->write( $container, $cache_key, $input );

      assert( $cache->read( $container, $id, $cache_key, $result ) );

      assert( $result === $input );

    }

    return 0;

  },

  'missing state directory' => function() {

    try {

      define( 'APP_CODE', 'invalid-example' );
      define( 'APP_SLUG', 'mudball-0.1' );

      $path = MudCache::GetCachePath( $cache_name = 'example-cache' );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_CACHE_MISSING_STATE_DIRECTORY );

    }

    return 0;

  },

  'missing state directory custom' => function() {

    try {

      define( 'APP_CODE', 'mudball-test' );
      define( 'APP_SLUG', 'mudball-0.1' );

      define( 'APP_CACHE_DIR', '/tmp/path/does/not/exist' );

      assert( is_dir( '/var/state/mudball-test' ) );

      $path = MudCache::GetCachePath( $cache_name = 'example-cache' );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_CACHE_MISSING_STATE_DIRECTORY );

    }

    return 0;

  },

  'can create cache directory standard' => function() {

    define( 'APP_CODE', 'mudball-test' );
    define( 'APP_SLUG', 'mudball-0.1' );

    $expect_dir = '/var/state/' . APP_CODE;

    assert( is_dir( $expect_dir ) );

    $path = MudCache::GetCachePath( $cache_name = 'example-cache' );

    assert( is_dir( "$expect_dir/cache" ) );

    MudCache::Delete( $cache_name );

    if ( is_dir( "$expect_dir/cache" ) ) {

      assert( ! mud_is_dir_empty( "$expect_dir/cache" ) );

    }

    return 0;

  },

]);

function run_dal( $thread ) {

  $cache = new_mud_cache( TEST_CACHE_NAME );

  for ( $n = 1; $n <= TEST_CACHE_SPIN; $n++ ) {

    $container = 'test-container-' . substr( mud_hash( microtime() ), -1 );

    $id =  substr( mud_hash( microtime() ), -5 );

    // 2021-04-11 jj5 - NOTE: the value must always be the same for any given ID, so we base
    // our example values on the hash of the ID...
    //
    $input = mud_hash( $id );

    if ( $cache->read( $container, $id, $cache_key, $result ) ) {

      // we already have the value

      assert( $result === $input );

    }
    else {

      $cache->write( $container, $cache_key, $input );

      assert( $cache->read( $container, $id, $cache_key, $result ) );

      assert( $result === $input );

    }
  }
}
