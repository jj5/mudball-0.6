<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test-early.php';
require_once __DIR__ . '/mud_environment.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - declare tests...
//

declare_tests([

  'is-dev' => function () {

    assert( mud_is_dev() );

    return 0;

  },

  'is-beta'=> function () {

    assert( ! mud_is_beta() );

    return 0;

  },

  'is-prod' => function () {

    assert( ! mud_is_prod() );

    return 0;

  },

  'is-cli' => function() {

    assert( mud_is_cli() );

    return 0;

  },

  'is-web' => function() {

    assert( ! mud_is_web() );

    return 0;

  },

  'is-posix' => function() {

    // 2024-02-08 jj5 - works on my machine!

    assert( mud_is_posix() );

    return 0;

  },

  'is-windows' => function() {

    // 2024-02-08 jj5 - works on my machine!

    assert( ! mud_is_windows() );

    return 0;

  },

  'get-username' => function() {

    $username = mud_get_username();

    assert( is_string( $username ) );
    assert( strlen( $username ) );

    return 0;

  },

]);
