<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_compression.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - zlob encode and decode
  //

  'zlob encode and decode' => function() {

    $data = file_get_contents( __FILE__ );

    for ( $level = 1; $level <= 9; $level++ ) {

      $zlob = mud_zlob_encode( $data, $level );

      //echo strlen( $data ) . ' => ' . strlen( $zlob ) . "\n";

      $uncompressed = mud_zlob_decode( $zlob );

      assert( $data === $uncompressed );

    }

    return 0;

  },

]);
