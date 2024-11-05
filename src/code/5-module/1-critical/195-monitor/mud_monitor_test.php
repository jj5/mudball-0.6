<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_monitor.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - declare tests...
//

declare_tests([


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - standard...
  //

  'standard' => function() {

    $object = new class {

      public $a, $b, $c;

      function test( $a, $b, $c ) {

        return [
          $this->a => $a,
          $this->b => $b,
          $this->c => $c,
        ];

      }
    };

    $monitor = mud_monitor( $object );

    $monitor->a = 'a';
    $monitor->b = 'b';
    $monitor->c = 'c';

    $result = $monitor->test( 1, 2, 3 );

    assert( $result === [ 'a' => 1, 'b' => 2, 'c' => 3 ] );

    $log = $monitor->get_monitor_log();

    assert( count( $log ) === 4 );

    assert( $log[ 0 ][ 'func' ] === '__set' );
    assert( $log[ 0 ][ 'name' ] === 'a' );

    assert( $log[ 1 ][ 'func' ] === '__set' );
    assert( $log[ 1 ][ 'name' ] === 'b' );

    assert( $log[ 2 ][ 'func' ] === '__set' );
    assert( $log[ 2 ][ 'name' ] === 'c' );

    assert( $log[ 3 ][ 'func' ] === '__call' );
    assert( $log[ 3 ][ 'name' ] === 'test' );

    return 0;

  },


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - array...
  //

  'array' => function() {

    $object = new class implements ArrayAccess {

      private $data = [];

      function offsetExists( mixed $offset ): bool {

        return isset( $this->data[ $offset ] );

      }

      function offsetGet( mixed $offset ): mixed {

        return $this->data[ $offset ];

      }

      function offsetSet( mixed $offset , mixed $value ): void {

        $this->data[ $offset ] = $value;

      }

      function offsetUnset( mixed $offset ): void {

        unset( $this->data[ $offset ] );

      }

      function test( $a, $b, $c ) {

        return [
          $this[ 'A' ] => $a,
          $this[ 'B' ] => $b,
          $this[ 'C' ] => $c,
        ];

      }

    };

    $monitor = mud_monitor( $object );

    $monitor[ 'A' ] = 'a';
    $monitor[ 'B' ] = 'b';
    $monitor[ 'C' ] = 'c';

    $result = $monitor->test( 1, 2, 3 );

    assert( $result === [ 'a' => 1, 'b' => 2, 'c' => 3 ] );

    $log = $monitor->get_monitor_log();

    assert( count( $log ) === 4 );

    assert( $log[ 0 ][ 'func' ] === 'offsetSet' );
    assert( $log[ 0 ][ 'name' ] === 'A' );

    assert( $log[ 1 ][ 'func' ] === 'offsetSet' );
    assert( $log[ 1 ][ 'name' ] === 'B' );

    assert( $log[ 2 ][ 'func' ] === 'offsetSet' );
    assert( $log[ 2 ][ 'name' ] === 'C' );

    assert( $log[ 3 ][ 'func' ] === '__call' );
    assert( $log[ 3 ][ 'name' ] === 'test' );

    return 0;

  },

]);
