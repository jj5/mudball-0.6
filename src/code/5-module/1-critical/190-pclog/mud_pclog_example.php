<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_pclog.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_raw([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - throw exception
  //

  'throw exception' => function() {

    class MockPclog extends MudModulePclog {

      protected function post( $url, $json, &$result, &$http_status, &$curl_error ) {

        // 2021-03-04 jj5 - we intercept the HTTP POST operation so this doesn't actually get
        // sent to the server...

        $result = strval( $this->gen_timestamp() );
        $http_status = 200;
        $curl_error = null;

        echo "POST: $url\n";

      }
    }

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_module_pclog( new MockPclog );

    throw new Exception( 'just testing...' );

  },

]);
