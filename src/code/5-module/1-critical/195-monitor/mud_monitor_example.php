<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_monitor.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - standard...
  //

  'standard' => function() {

    $value = new DateTime;

    $proxy = mud_monitor( $value );

    $proxy->setTimestamp( 1234 );

    assert( $proxy->getTimestamp() === $value->getTimestamp() );

    assert( $proxy->format( 'r' ) === $value->format( 'r' ) );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - array...
  //

  'array' => function() {

    $value = [ 'a' => 1, 'b' => 2, 'c' => 3 ];

    $proxy = mud_monitor( $value );

    assert( $proxy[ 'a' ] === 1 );
    assert( $proxy[ 'b' ] === 2 );
    assert( $proxy[ 'c' ] === 3 );

    return 0;

  },

]);
