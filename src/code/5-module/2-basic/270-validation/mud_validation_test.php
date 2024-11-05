<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_validation.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - happy path
  //

  'happy path' => function() {

    assert( mud_is_valid_url( 'https://www.progclub.org/' ) );

    assert( ! mud_is_valid_url( 'not-a-url' ) );

    assert( mud_is_valid_email_address( MUDBALL_MAINTAINER_EMAIL ) );
    assert( mud_is_valid_email_address( 'jj5@progclub.org' ) );

    assert( ! mud_is_valid_url( 'not-an-email' ) );

    assert( mud_is_valid_username( 'jj5' ) );

    assert( ! mud_is_valid_username( '' ) );

    assert( mud_is_trimmed( '' ) );
    assert( mud_is_trimmed( 'asdf' ) );
    assert( mud_is_trimmed( 'foo bar' ) );

    assert( ! mud_is_trimmed( ' ' ) );
    assert( ! mud_is_trimmed( "\t" ) );
    assert( ! mud_is_trimmed( "\r" ) );
    assert( ! mud_is_trimmed( "\n" ) );
    assert( ! mud_is_trimmed( "\r\n" ) );
    assert( ! mud_is_trimmed( ' asdf ' ) );
    assert( ! mud_is_trimmed( ' foo bar ' ) );

    assert( mud_is_ascii_structure( 'asdf' ) );

    assert( ! mud_is_ascii_structure( 'foo bar' ) );

    assert( mud_is_ascii_printable( 'asdf' ) );

    foreach ( [
      MUD_ASCII_NUL,
      MUD_ASCII_STX,
      MUD_ASCII_SOT,
      MUD_ASCII_ETX,
      MUD_ASCII_EOT,
      MUD_ASCII_ENQ,
      MUD_ASCII_ACK,
      MUD_ASCII_BEL,
      MUD_ASCII_BS,
      MUD_ASCII_VT,
      MUD_ASCII_FF,
      MUD_ASCII_SO,
      MUD_ASCII_SI,
      MUD_ASCII_DLE,
      MUD_ASCII_DC1,
      MUD_ASCII_DC2,
      MUD_ASCII_DC3,
      MUD_ASCII_DC4,
      MUD_ASCII_NAK,
      MUD_ASCII_SYN,
      MUD_ASCII_ETB,
      MUD_ASCII_CAN,
      MUD_ASCII_EM,
      MUD_ASCII_SUB,
      MUD_ASCII_ESC,
      MUD_ASCII_FS,
      MUD_ASCII_GS,
      MUD_ASCII_RS,
      MUD_ASCII_US,
      MUD_ASCII_DEL,
      // 2021-03-19 jj5 - NOTE: tabs and new lines count as non-printable...
      MUD_ASCII_HT,
      MUD_ASCII_LF,
      MUD_ASCII_CR,
      MUD_UTF8_NBSP,

    ] as $char ) {

      assert( ! mud_is_ascii_printable( $char ) );

    }

    assert( mud_is_ascii( 'asdf' ) );

    assert( ! mud_is_ascii( MUD_UTF8_NBSP ) );

    return 0;

  },

]);
