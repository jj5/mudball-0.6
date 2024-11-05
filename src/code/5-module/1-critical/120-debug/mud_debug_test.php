<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_debug.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([

  'dump' => function() {

    class AppModuleExit extends MudModuleExit {

      public function exit( $code ) {

        assert( $code === 1 );

        exit( 0 );

      }
    }

    mud_locator()->set_module( MudModuleExit::class, new AppModuleExit() );

    mud_dump( [ 'a' => 1, 'b' => 2, 'c' => 3 ] );

    assert( false );

  },

  'dump' => function() {

    class MudModuleTest extends MudModuleExit {

      public function exit( $code_or_name ) {

        assert( $code_or_name === 1 );

        exit( 0 );

      }
    }

    mud_locator()->set_module( MudModuleExit::class, new MudModuleTest() );

    mud_dump( [ 'a' => 1, 'b' => 2, 'c' => 3 ] );

    assert( false );
    
  },

]);

