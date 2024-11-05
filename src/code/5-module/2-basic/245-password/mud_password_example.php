<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/example.php';
require_once __DIR__ . '/mud_password.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare examples...
//

declare_examples([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - password hash and verify
  //

  'password hash and verify' => function() {

    static $password_list = [ '', 'test', 't0ps3cr3t' ];

    foreach ( $password_list as $password ) {

      $password_hash = mud_password_hash( $password );

      assert( mud_password_verify( $password, $password_hash ) );

    }

    return 0;

  },

]);
