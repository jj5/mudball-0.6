<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_format.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - declare tests...
//

declare_tests([

  'format external id' => function() {

    $external_id = MUD_EXTERNAL_ID_MIN + 1337;

    $external_id_string = mud_format_external_id( $external_id );

    //var_dump( $external_id_string );

    assert( $external_id_string === '500-000-000-001-337' );

    return 0;

  },

  'format external id with prefix' => function() {

    $external_id = MUD_EXTERNAL_ID_MIN + 1337;

    $external_id_string = mud_format_external_id( $external_id, 'eg' );

    //var_dump( $external_id_string );

    assert( $external_id_string === 'eg-500-000-000-001-337' );

    return 0;

  },

  'format multiple external id' => function() {

    for ( $i = 0; $i < 100; $i++ ) {

      $external_id = mud_new_external_id();

      assert( $external_id >= MUD_EXTERNAL_ID_MIN );
      assert( $external_id <= MUD_EXTERNAL_ID_MAX );

      $external_id_string = mud_format_external_id( $external_id );

      echo "$external_id_string\n";

    }

    return 0;

  },


]);
