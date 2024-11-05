<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_log.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - uninitialized behanvior...
  //

  'uninitialized behanvior' => function() {

    mud_log_4_warning( 'this is a fake warning from the test script...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - null log...
  //

  'null log' => function() {

    mud_log_init_null();

    mud_log_3_error( 'this is a fake error from the test script which no one will ever see...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - stderr log...
  //

  'stderr log' => function() {

    mud_log_init_stderr();

    mud_log_3_error( 'this is a fake error from the test script coming to a stderr near you...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - weblog log...
  //

  'weblog log' => function() {

    mud_log_init_weblog();

    mud_log_3_error( 'this is a fake error from the test script coming to a stderr or weblog near you...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - syslog and stderr test
  //

  'syslog and stderr test' => function() {

    mud_log_init_syslog();

    mud_log_7_debug( 'this is a fake debug message from the test script...' );
    mud_log_6_info( 'this is a fake info message from the test script...' );
    mud_log_5_notice( 'this is a fake notice from the test script...' );
    mud_log_4_warning( 'this is a fake warning from the test script...' );
    mud_log_3_error( 'this is a fake error from the test script...' );
    mud_log_2_critical( 'this is a fake critical error from the test script...' );
    mud_log_1_alert( 'this is a fake alert from the test script...' );
    mud_log_0_emergency( 'this is a fake emergency from the test script...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - syslog without stderr test
  //

  'syslog without stderr test' => function() {

    mud_log_init_syslog( $copy_to_stderr = false );

    mud_log_7_debug( 'this is a fake debug message from the test script...' );
    mud_log_6_info( 'this is a fake info message from the test script...' );
    mud_log_5_notice( 'this is a fake notice from the test script...' );
    mud_log_4_warning( 'this is a fake warning from the test script...' );
    mud_log_3_error( 'this is a fake error from the test script...' );
    mud_log_2_critical( 'this is a fake critical error from the test script...' );
    mud_log_1_alert( 'this is a fake alert from the test script...' );
    mud_log_0_emergency( 'this is a fake emergency from the test script...' );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - file log...
  //

  'file log' => function() {

    mud_log_init_file( $tmp_file = mud_get_temp_file() );

    mud_log_7_debug( 'this is a fake debug message from the test script...' );
    mud_log_6_info( 'this is a fake info message from the test script...' );
    mud_log_5_notice( 'this is a fake notice from the test script...' );
    mud_log_4_warning( 'this is a fake warning from the test script...' );
    mud_log_3_error( 'this is a fake error from the test script...' );
    mud_log_2_critical( 'this is a fake critical error from the test script...' );
    mud_log_1_alert( 'this is a fake alert from the test script...' );
    mud_log_0_emergency( 'this is a fake emergency from the test script...' );

    $lines = file( $tmp_file );

    assert( strpos( $lines[ 0 ], '[WARNING]: ' ) === 0 );
    assert( strpos( $lines[ 1 ], '[ERROR]: ' ) === 0 );
    assert( strpos( $lines[ 2 ], '[CRITICAL]: ' ) === 0 );
    assert( strpos( $lines[ 3 ], '[ALERT]: ' ) === 0 );
    assert( strpos( $lines[ 4 ], '[EMERGENCY]: ' ) === 0 );

    assert( count( $lines ) === 5 );

    return 0;

  },

]);
