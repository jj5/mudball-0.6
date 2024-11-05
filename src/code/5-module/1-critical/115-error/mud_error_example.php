<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_error.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail
  //

  'fail' => function() {

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    mud_fail( MUD_ERR_EXAMPLE );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - fail with data
  //

  'fail with data' => function() {

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.' );

    mud_fail( MUD_ERR_EXAMPLE, [ 'data' => 'value' ] );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - define error with hint then fail; a hint is for suggesting to the user what
  // they might do to fix a particular problem.
  //

  'define error with hint then fail' => function() {

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_define_error( 'MUD_ERR_EXAMPLE', 'an example error.', 'do you need a hint?' );

    mud_fail( MUD_ERR_EXAMPLE, [ 'data' => 'value' ] );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - redact secrets
  //

  'redact secrets' => function() {

    $sensitive_data = [ 'secret' => '**SECRET**', 'password' => '**SECRET**' ];

    $safe_data = mud_redact_secrets( $sensitive_data );

    assert( $safe_data[ 'secret' ] === '**REDACTED**' );
    assert( $safe_data[ 'password' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - redact secrets with special whitelist literal
  //

  'redact secrets with special whitelist literal' => function() {

    $sensitive_data = [ 'secret' => '**SAFE**', 'password' => '**SECRET**' ];

    $safe_data = mud_redact_secrets( $sensitive_data, $whitelist = [ 'secret' ] );

    assert( $safe_data[ 'secret' ] === '**SAFE**' );
    assert( $safe_data[ 'password' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - redact secrets with special whitelist pattern
  //

  'redact secrets with special whitelist pattern' => function() {

    $sensitive_data = [ 'secret' => '**SAFE**', 'password' => '**SECRET**' ];

    $safe_data = mud_redact_secrets( $sensitive_data, $whitelist = [ '|^secret.*$|' ] );

    assert( $safe_data[ 'secret' ] === '**SAFE**' );
    assert( $safe_data[ 'password' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - redact secrets with special blacklist literal
  //

  'redact secrets with special blacklist literal' => function() {

    $sensitive_data = [ 'example_1' => '**SECRET**', 'example_2' => '**SECRET**' ];

    $safe_data = mud_redact_secrets( $sensitive_data, [], $blacklist = [ 'example' ] );

    assert( $safe_data[ 'example_1' ] === '**REDACTED**' );
    assert( $safe_data[ 'example_2' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - redact secrets with special blacklist pattern
  //

  'redact secrets with special blacklist pattern' => function() {

    $sensitive_data = [ 'example_1' => '**SECRET**', 'example_2' => '**SECRET**' ];

    $safe_data = mud_redact_secrets( $sensitive_data, [], $blacklist = [ '|^example.*$|' ] );

    assert( $safe_data[ 'example_1' ] === '**REDACTED**' );
    assert( $safe_data[ 'example_2' ] === '**REDACTED**' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - not implemented
  //

  'not implemented' => function() {

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_not_implemented( [ 'data' => 'value' ] );

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - not supported
  //

  'not supported' => function() {

    mud_expect_exit( MUD_EXIT_EXCEPTION );

    mud_not_supported( [ 'data' => 'value' ] );

  },

]);
