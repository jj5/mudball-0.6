#!/usr/bin/env -S php -d zend.assertions=1 -d assert.exception=1
<?php declare(strict_types=1);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-11-20 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../../inc/framework/test.php';

require_once __DIR__ . '/mud_option.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-11-20 jj5 - test constants...
//



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-11-20 jj5 - declare tests...
//

mud_declare_tests([

  'test-mud-opt-present' => function() {

    $map = [ 'a' => 'x', 'n' => 5 ];

    assert( mud_opt( $map, 'a' ) === 'x' );
    assert( mud_opt( $map, 'n' ) === 5 );
    assert( mud_opt( $map, 'a', 'default' ) === 'x' );

    return 0;

  },

  'test-mud-opt-missing' => function() {

    assert( mud_opt( [], 'a' ) === null );
    assert( mud_opt( [ 'b' => 1 ], 'a' ) === null );
    assert( mud_opt( [], 'a', 'default' ) === 'default' );
    assert( mud_opt( [], 'a', 0 ) === 0 );

    return 0;

  },

  'test-mud-opt-null-value-uses-default' => function() {

    // 2026-11-20 jj5 - a null value is treated as missing (the ?? operator).
    assert( mud_opt( [ 'a' => null ], 'a', 'default' ) === 'default' );

    return 0;

  },

  'test-mud-opt-falsy-values-preserved' => function() {

    $map = [ 'zero' => 0, 'empty' => '', 'false' => false, 'list' => [], 'str0' => '0' ];

    assert( mud_opt( $map, 'zero', 'd' ) === 0 );
    assert( mud_opt( $map, 'empty', 'd' ) === '' );
    assert( mud_opt( $map, 'false', 'd' ) === false );
    assert( mud_opt( $map, 'list', 'd' ) === [] );
    assert( mud_opt( $map, 'str0', 'd' ) === '0' );

    return 0;

  },

  'test-mud-opt-key-matching' => function() {

    $map = [ 'a' => 1, 'A' => 2, '1' => 'one' ];

    // 2026-11-20 jj5 - keys are case sensitive.
    assert( mud_opt( $map, 'a' ) === 1 );
    assert( mud_opt( $map, 'A' ) === 2 );
    assert( mud_opt( $map, 'b', 'd' ) === 'd' );

    // 2026-11-20 jj5 - numeric string keys are normalized to ints by PHP.
    assert( mud_opt( $map, '1' ) === 'one' );

    return 0;

  },

  'test-mud-opt-value-types' => function() {

    $obj = new stdClass;

    $map = [ 'f' => 1.5, 't' => true, 'arr' => [ 1, 2 ], 'obj' => $obj ];

    assert( mud_opt( $map, 'f' ) === 1.5 );
    assert( mud_opt( $map, 't' ) === true );
    assert( mud_opt( $map, 'arr' ) === [ 1, 2 ] );
    assert( mud_opt( $map, 'obj' ) === $obj );

    // 2026-11-20 jj5 - the default is returned as-is, whatever its type.
    assert( mud_opt( [], 'x', $obj ) === $obj );
    assert( mud_opt( [], 'x', [ 1 ] ) === [ 1 ] );

    return 0;

  },

  'test-mud-opt-does-not-modify-map' => function() {

    $map = [ 'a' => 1 ];
    $copy = $map;

    mud_opt( $map, 'a' );
    mud_opt( $map, 'missing', 'd' );

    assert( $map === $copy );

    return 0;

  },

  'test-mud-opt-strict-types' => function() {

    // 2026-11-20 jj5 - the key must be a string under strict_types.
    try {

      mud_opt( [], 1 );

      assert( false, 'expected TypeError' );

    }
    catch ( TypeError $ex ) {

      // expected.

    }

    return 0;

  },

  'test-module-locator' => function() {

    $module = mud_module_option();

    assert( $module instanceof MudModuleOption );
    assert( mud_module_option() === $module );
    assert( $module->get_option( [ 'a' => 1 ], 'a' ) === 1 );

    return 0;

  },

]);
