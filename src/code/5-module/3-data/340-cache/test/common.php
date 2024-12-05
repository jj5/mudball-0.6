<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - shared testing / play functions...
//

function run_test( $thread_count ) {

  // 2021-04-11 jj5 - we delete the test cache before the test so that we have a consistent
  // context, but we don't delete the play cache, we keep that and let it grow...
  //
  if ( TEST_CACHE_NAME === 'test-cache' ) { MudCache::Delete( TEST_CACHE_NAME ); }

  $pid_list = [];

  // 2021-04-11 jj5 - spin up $n threads then take a bunch of caches for a concurrent workout...
  //
  for ( $n = 1; $n <= $thread_count; $n++ ) {

    $pid = pcntl_fork();

    if ( $pid === -1 || $pid === false ) {

      die( 'Fork failed' );

    }

    if ( $pid === 0 ) {

      // @child

      try_dal( $n );

    }
    else {

      // @parent

      $pid_list[] = $pid;

    }
  }

  foreach ( $pid_list as $pid ) {

    pcntl_waitpid( $pid, $status );

  }
}

function try_dal( $n ) {

  try {

    run_dal( $n );

    exit( 0 );

  }
  catch ( Exception $ex ) {

    mud_print( "run_dal threw: " . $ex->getMessage() );

    mud_log_exception_fatal( $ex );

    exit( 1 );

  }
  finally {

    exit( 2 );

  }
}

