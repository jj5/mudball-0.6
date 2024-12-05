<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_log.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - syslog default
  //

  'syslog default' => function() {

    mud_init();

    mud_log_init_syslog();

    mud_log_0_emergency( 'emergency' );
    mud_log_1_alert( 'alert' );
    mud_log_2_critical( 'critical' );
    mud_log_3_error( 'error' );
    mud_log_4_warning( 'warning' );

    // 2021-03-04 jj5 - the following will be ignored by default...
    //
    mud_log_5_notice( 'notice' );
    mud_log_6_info( 'info' );
    mud_log_7_debug( 'debug' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - syslog debug
  //

  'syslog debug' => function() {

    mud_init();

    mud_log_init_syslog( MUD_LOG_LEVEL_7_DEBUG );

    // 2021-03-04 jj5 - the following should all be logged...
    //
    mud_log_0_emergency( 'emergency' );
    mud_log_1_alert( 'alert' );
    mud_log_2_critical( 'critical' );
    mud_log_3_error( 'error' );
    mud_log_4_warning( 'warning' );
    mud_log_5_notice( 'notice' );
    mud_log_6_info( 'info' );
    mud_log_7_debug( 'debug' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - file log default
  //

  'file log default' => function() {

    mud_init();

    $path = tempnam ( '/dev/shm', 'mudball-' );

    assert( is_string( $path ) );
    assert( file_exists( $path ) );

    mud_log_init_file( $path );

    mud_log_0_emergency( 'emergency' );
    mud_log_1_alert( 'alert' );
    mud_log_2_critical( 'critical' );
    mud_log_3_error( 'error' );
    mud_log_4_warning( 'warning' );

    // 2021-03-04 jj5 - the following will be ignored by default...
    //
    mud_log_5_notice( 'notice' );
    mud_log_6_info( 'info' );
    mud_log_7_debug( 'debug' );

    $lines = file( $path );

    assert( count( $lines ) === 5 );
    assert( preg_match( '/^\[EMERGENCY\].+emergency$/', $lines[ 0 ] ) );
    assert( preg_match( '/^\[ALERT\].+alert$/', $lines[ 1 ] ) );
    assert( preg_match( '/^\[CRITICAL\].+critical$/', $lines[ 2 ] ) );
    assert( preg_match( '/^\[ERROR\].+error$/', $lines[ 3 ] ) );
    assert( preg_match( '/^\[WARNING\].+warning$/', $lines[ 4 ] ) );

    unlink( $path );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - file log debug
  //

  'file log debug' => function() {

    mud_init();

    $path = tempnam ( '/dev/shm', 'mudball-' );

    assert( is_string( $path ) );
    assert( file_exists( $path ) );

    mud_log_init_file( $path, MUD_LOG_LEVEL_7_DEBUG );

    mud_log_0_emergency( 'emergency' );
    mud_log_1_alert( 'alert' );
    mud_log_2_critical( 'critical' );
    mud_log_3_error( 'error' );
    mud_log_4_warning( 'warning' );
    mud_log_5_notice( 'notice' );
    mud_log_6_info( 'info' );
    mud_log_7_debug( 'debug' );

    $lines = file( $path );

    assert( count( $lines ) === 8 );
    assert( preg_match( '/^\[EMERGENCY\].+emergency$/', $lines[ 0 ] ) );
    assert( preg_match( '/^\[ALERT\].+alert$/', $lines[ 1 ] ) );
    assert( preg_match( '/^\[CRITICAL\].+critical$/', $lines[ 2 ] ) );
    assert( preg_match( '/^\[ERROR\].+error$/', $lines[ 3 ] ) );
    assert( preg_match( '/^\[WARNING\].+warning$/', $lines[ 4 ] ) );
    assert( preg_match( '/^\[NOTICE\].+notice$/', $lines[ 5 ] ) );
    assert( preg_match( '/^\[INFO\].+info$/', $lines[ 6 ] ) );
    assert( preg_match( '/^\[DEBUG\].+debug$/', $lines[ 7 ] ) );

    unlink( $path );

    return 0;

  },

]);
