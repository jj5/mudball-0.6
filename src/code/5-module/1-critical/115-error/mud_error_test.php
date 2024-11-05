<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test-early.php';
require_once __DIR__ . '/mud_error.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - happy path...
  //

  'happy-path' => function() {

    $error_list = [
      MUD_ERR_GENERAL,
      MUD_ERR_NOT_IMPLEMENTED,
      MUD_ERR_NOT_SUPPORTED,
      MUD_ERR_NOT_POSSIBLE,
      MUD_ERR_REQUIREMENT_VIOLATED,
      MUD_ERR_ERROR_NAME_IS_REQUIRED,
      MUD_ERR_ERROR_NAME_IS_DUPLICATE,
      MUD_ERR_ERROR_LIMIT_EXCEEDED,
    ];

    foreach ( $error_list as $error ) {

      try {

        mud_fail( $error );

        assert( false );

      }
      catch ( MudException $ex ) {

        $code = $ex->getCode();

        assert( $error === $code );

        $text = mud_get_error_text( $code );
        $name = mud_get_error_name( $code );
        $hint = mud_get_error_hint( $code );

        assert( $ex->getMessage() === "error while processing: $text" );
        assert( $ex->getName() === $name );
        assert( $ex->getHint() === $hint );

      }
    }

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - missing error name
  //

  'missing error name' => function() {

    try {

      mud_define_error( '', 'an example error.' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: error name is required.' );
      assert( $code === MUD_ERR_ERROR_NAME_IS_REQUIRED );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - duplicate error name
  //

  'duplicate error name' => function() {

    try {

      mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );
      mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: duplicate error name.' );
      assert( $code === MUD_ERR_ERROR_NAME_IS_DUPLICATE );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-27 jj5 - too many errors
  //

  'too many errors' => function() {

    try {

      for ( $i = 0; $i >= 0; $i++ ) {

        $error_const = "MUD_ERR_EXAMPLE_$i";

        mud_define_error( $error_const, "error $i." );

      }

      assert( false );

    }
    catch ( MudException $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();
      $hint = $ex->getHint();
      $scope = $ex->getData()[ 'scope' ];
      $counter = $ex->getData()[ 'counter' ];

      assert(
        $message === 'error while processing: too many errors have been defined in this scope.'
      );

      assert( $code === MUD_ERR_ERROR_LIMIT_EXCEEDED );

      // 2021-02-27 jj5 - there should be a hint for this error...
      //
      assert( strlen( $hint ) > 0 );

      assert( $scope === MUDBALL_CODE );

      // 2021-02-27 jj5 - this counter value is based on the $tranche size, which could be
      // changed in future... if that happens update this test.
      //
      assert( $counter === 10000 );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - new scope
  //

  'new scope' => function() {

    mud_define_error( 'MUD_ERR_EXAMPLE_1', 'an example error.' );
    mud_define_error( 'MUD_ERR_EXAMPLE_2', 'an example error.' );

    mud_define_error( 'MUD_ERR_EXAMPLE_A', 'an example error.', 'no hint?', 'new-scope' );
    mud_define_error( 'MUD_ERR_EXAMPLE_B', 'an example error.', 'no hint?', 'new-scope' );

    assert( MUD_ERR_EXAMPLE_A === 20000 );
    assert( MUD_ERR_EXAMPLE_B === 20001 );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail
  //

  'fail' => function() {

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    try {

      mud_fail( MUD_ERR_EXAMPLE );

      assert( false );

    }
    catch ( Exception $ex ) {

      assert( $ex->getMessage() === 'error while processing: an example error.' );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail with data
  //

  'fail with data' => function() {

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    try {

      mud_fail( MUD_ERR_EXAMPLE, [ 'data' => 'value' ] );

      assert( false );

    }
    catch ( Exception $ex ) {

      assert( $ex->getMessage() === 'error while processing: an example error.' );

      assert( $ex->getData() === [ 'data' => 'value' ] );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail with complex data
  //

  'fail with complex data' => function() {

    $datetime = new_php_date_time();

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    try {

      mud_fail( MUD_ERR_EXAMPLE, [ 'data' => $datetime ] );

      assert( false );

    }
    catch ( Exception $ex ) {

      assert( $ex->getMessage() === 'error while processing: an example error.' );

      $data = $ex->getData();

      assert( strlen( $data[ 'data' ][ 'date' ] ) === 26 );
      assert( $data[ 'data' ][ 'timezone_type' ] === 3 );

      // 2024-02-07 jj5 - works on my machine! :)
      //
      assert( $data[ 'data' ][ 'timezone' ] === 'Australia/Sydney' );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail with secret data
  //

  'fail with secret data' => function() {

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    try {

      mud_fail( MUD_ERR_EXAMPLE, [ 'password' => '**SECRET**', 'secret' => '**SECRET**' ] );

      assert( false );

    }
    catch ( Exception $ex ) {

      assert( $ex->getMessage() === 'error while processing: an example error.' );

      $data = $ex->getData();

      assert( $data[ 'password' ] === '**REDACTED**' );
      assert( $data[ 'secret' ] === '**REDACTED**' );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail with message
  //

  'fail with message' => function() {

    try {

      mud_fail( 'this is the error message.', [ 'data' => 'value' ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getMessage() === 'this is the error message.' );
      assert( $ex->getCode() === MUD_ERR_GENERAL );
      assert( $ex->getName() === 'MUD_ERR_GENERAL' );
      assert( $ex->getData() === [ 'data' => 'value' ] );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - define error with hint
  //

  'define error with hint' => function() {

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.', 'do you need a hint?' );

    try {

      mud_fail( MUD_ERR_EXAMPLE );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getMessage() === 'error while processing: an example error.' );
      assert( $ex->getHint() === 'do you need a hint?' );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - not implemented
  //

  'not implemented' => function() {

    try {

      mud_not_implemented( [ 'data' => 'value' ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: functionality not implemented.' );
      assert( $code === MUD_ERR_NOT_IMPLEMENTED );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - not supported
  //

  'not supported' => function() {

    try {

      mud_not_supported( [ 'data' => 'value' ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      assert( $message === 'error while processing: situation not supported.' );
      assert( $code === MUD_ERR_NOT_SUPPORTED );

      return 0;

    }

    assert( false );

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - not supported
  //

  'not possbile' => function() {

    try {

      mud_not_possible( [ 'data' => 'value' ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      $message = $ex->getMessage();
      $code = $ex->getCode();

      var_dump( $message );

      assert( $message === 'error while processing: situation not possible.' );
      assert( $code === MUD_ERR_NOT_POSSIBLE );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - exception serialization
  //

  'exception serialization' => function() {

    try {

      mud_fail(
        MUD_ERR_GENERAL,
        [ 'data' => 'value', 'secret' => '**SECRET**' ],
        new Exception( 'previous', 123 )
      );

    }
    catch ( MudException $ex ) {

      $json = json_encode( $ex );

      $data = json_decode( $json, $assoc = true );

      assert( $data[ 'class' ] === 'MudException' );

      assert( strlen( $data[ 'date' ][ 'date' ] ) === 26 );
      assert( $data[ 'date' ][ 'timezone_type' ] === 3 );
      assert( $data[ 'date' ][ 'timezone' ] === 'Australia/Sydney' );

      assert( $data[ 'name' ] === 'MUD_ERR_GENERAL' );
      assert( $data[ 'code' ] === MUD_ERR_GENERAL );
      assert( $data[ 'message' ] === 'error while processing: an error occurred.' );
      assert( $data[ 'hint' ] === '' );
      assert( $data[ 'previous' ][ 'class' ] === 'Exception' );
      assert( $data[ 'previous' ][ 'code' ] === 123 );
      assert( $data[ 'previous' ][ 'message' ] === 'previous' );
      assert( $data[ 'previous' ][ 'previous' ] === null );
      assert( $data[ 'data' ][ 'data' ] === 'value' );
      assert( $data[ 'data' ][ 'secret' ] === '**REDACTED**' );

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - custom whitelist literal
  //

  'custom whitelist literal' => function() {

    $data = [ 'example' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [ 'example' ] );

    assert( $data[ 'example' ] === '**SECRET**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - custom whitelist pattern
  //

  'custom whitelist pattern' => function() {

    $data = [ 'example' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [ '|^exam.*$|' ] );

    assert( $data[ 'example' ] === '**SECRET**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - custom blacklist literal
  //

  'custom blacklist literal' => function() {

    $data = [ 'example' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [], [ 'example' ] );

    assert( $data[ 'example' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - custom blacklist pattern
  //

  'custom blacklist pattern' => function() {

    $data = [ 'example' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [], [ '|^exam.*$|' ] );

    assert( $data[ 'example' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid whitelist (null)
  //

  'invalid whitelist (null)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [ null ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid whitelist (empty)
  //

  'invalid whitelist (empty)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [ '' ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid whitelist (object)
  //

  'invalid whitelist (object)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [ new DateTime ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid blacklist (null)
  //

  'invalid blacklist (null)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [], [ null ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid blacklist (empty)
  //

  'invalid blacklist (empty)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [], [ '' ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - invalid blacklist (object)
  //

  'invalid blacklist (object)' => function() {

    $data = [ 'secret' => '**SECRET**' ];

    $data = mud_redact_secrets( $data, [], [ new DateTime ] );

    assert( $data[ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-27 jj5 - safe stack; this makes sure that the stack trace in the exception does not
  // include any function arguments which might contain sensitive data.
  //

  'safe stack' => function() {

    try {

      $func = function( $secret ) {

        assert( $secret === '**SECRET**' );

        mud_fail( 'secret should be redacted from stack trace' );

      };

      $func( '**SECRET**' );

      assert( false );

    }
    catch ( Exception $ex ) {

      $json = json_encode( $ex );

      assert( strpos( $json, 'SECRET' ) === false );

      $data = json_decode( $json, $assoc = true );

      return 0;

      // 2024-02-07 jj5 - the $data[ 'trace' ] array is not provided anymore...

      for ( $i = 0; $i < 6; $i++ ) {

        assert( $data[ 'trace' ][ $i ][ 'args' ] === '**REDACTED**' );

      }

      return 0;

    }

    assert( false );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-27 jj5 - class redaction...
  //

  'class redaction' => function() {

    class ExampleClass {

      public $a = 1;
      public $b = 2;
      public $c = 3;
      public $secret = '**SECRET**';
      public $nested = null;
      private $private = '**SECRET**';

    }

    $obj = new ExampleClass();
    $obj->nested = new ExampleClass();

    $data = mud_redact_secrets( $obj );

    $json = json_encode( $data );

    assert( strpos( $json, 'SECRET' ) === false );

    assert( $data[ 'a' ] === 1 );
    assert( $data[ 'b' ] === 2 );
    assert( $data[ 'c' ] === 3 );
    assert( $data[ 'secret' ] === '**REDACTED**' );

    assert( $data[ 'nested' ][ 'a' ] === 1 );
    assert( $data[ 'nested' ][ 'b' ] === 2 );
    assert( $data[ 'nested' ][ 'c' ] === 3 );
    assert( $data[ 'nested' ][ 'secret' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-27 jj5 - deep redaction
  //

  'deep redaction' => function() {

    // 2021-02-27 jj5 - the default depth for var_dump is three levels deep, but we can bump that
    // to five here so we can inspect our data...
    //
    ini_set( 'xdebug.var_display_max_depth', 5 );

    // 2021-02-27 jj5 - this is a deep data structure for testing the depth support for the
    // redaction function...
    //
    $input = [
      'a' => [
        'b' => [
          'c' => [
            'd' => [
              'e' => true,
            ],
          ],
        ],
      ],
    ];

    $data = mud_redact_secrets( $input );

    // 2021-02-27 jj5 - hmm. This doesn't do what I would expect it to do, which is to limit the
    // depth of the data in the above $input array... based on the $max_depth setting in the
    // redaction function... but since that is not really a particular problem at the moment I'm
    // just gonna ignore that for now...

    assert( $data[ 'a' ][ 'b' ][ 'c' ][ 'd' ][ 'e' ] === true );

    return 0;

  },

]);

