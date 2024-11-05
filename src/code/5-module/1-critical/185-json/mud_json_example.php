<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_json.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - jzon encode and decode
  //

  'jzon encode and decode' => function() {

    $data = [
      'string' => 'my string yeah woo long string yeah!',
      'secret' => '**SECRET**',
    ];

    for ( $level = 0; $level <= 9; $level++ ) {

      $jzon = mud_jzon_encode( $data, $level );

      $uncompressed = mud_jzon_decode( $jzon );

      assert( $uncompressed[ 'string' ] === $data[ 'string' ] );
      assert( $uncompressed[ 'secret' ] === '**REDACTED**' );

    }

    return 0;

  },

]);
