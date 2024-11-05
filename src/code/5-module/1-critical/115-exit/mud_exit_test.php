<?php


//////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_exit.php';


//////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - missing exit name
  //

  'missing exit name' => function() {

    try {

      mud_define_exit( '', 1, '', '' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      var_dump( $message );

      assert( $message === 'error while processing: exit name is required.' );
      assert( $code === MUD_ERR_EXIT_NAME_IS_REQUIRED );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - duplicate exit name
  //

  'duplicate exit name' => function() {

    try {

      mud_define_exit( 'MUD_ERR_EXAMPLE', 1, 'example', 'example' );
      mud_define_exit( 'MUD_ERR_EXAMPLE', 2, 'example', 'example' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: duplicate exit name.' );
      assert( $code === MUD_ERR_EXIT_NAME_IS_DUPLICATE );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - duplicate exit code
  //

  'duplicate exit code' => function() {

    try {

      mud_define_exit( 'MUD_ERR_EXAMPLE', 1, 'example', 'example' );
      mud_define_exit( 'MUD_ERR_EXAMPLE', 1, 'example', 'example' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: duplicate exit name.' );
      assert( $code === MUD_ERR_EXIT_NAME_IS_DUPLICATE );

      return 0;

    }

    assert( false );

  },

]);

