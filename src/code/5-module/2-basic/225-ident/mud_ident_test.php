<?php


/////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_ident.php';


/////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2023-02-22 jj5 - new external id
  //

  'new external id' => function() {

    for ( $i = 0; $i < 100; $i++ ) {

      $external_id = mud_new_external_id();

      assert( $external_id >= MUD_EXTERNAL_ID_MIN );
      assert( $external_id <= MUD_EXTERNAL_ID_MAX );

      $external_id_string = mud_format_external_id( $external_id );
      $external_id_string_prefix = mud_format_external_id( $external_id, 'eg' );

      echo "$external_id: $external_id_string: $external_id_string_prefix\n";

      assert( $external_id === mud_parse_external_id( $external_id_string ) );
      assert( $external_id === mud_parse_external_id( $external_id_string_prefix ) );

    }

    return 0;

  },

]);
