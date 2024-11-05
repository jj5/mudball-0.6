<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-04-16 jj5 - default functionality... can be extended...
//

class MudModuleXsrf extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - protected fields
  //

  protected $token = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public methods...
  //

  public function configure( string $token ) {

    $this->token = $token;

  }

  public function get_token_name() {

    return 'xsrf';

  }

  public function get_token_hash() {

    $this->check_init();

    // 2020-04-14 jj5 - SEE: crimesafe-csrf.php:
    // https://github.com/hannob/crimesafe-csrf/blob/master/crimesafe-csrf.php

    $prefix = random_bytes( MUD_TOKEN_LENGTH );
    $suffix = hash( 'sha384', $prefix . $this->token, true );

    return base64_encode( $prefix . $suffix );

  }

  public function check( $request ) {

    $this->check_init();

    if ( $request->is_safe() ) { return true; }

    $token_name = $this->get_token_name();

    $token_hash_base64 = $request->get_value( $token_name );

    if ( ! $token_hash_base64 ) {

      mud_fail(
        MUD_ERR_XSRF_TOKEN_MISSING,
        [ 'token_name' => $token_name ]
      );

    }

    // 2020-04-14 jj5 - SEE: crimesafe-csrf.php:
    // https://github.com/hannob/crimesafe-csrf/blob/master/crimesafe-csrf.php

    $token_hash_bin = base64_decode( $token_hash_base64 );

    $prefix = substr( $token_hash_bin, 0, MUD_TOKEN_LENGTH );
    $suffix = substr( $token_hash_bin, MUD_TOKEN_LENGTH );

    $expected_suffix = hash( 'sha384', $prefix . $this->token, true );

    if ( $expected_suffix === $suffix ) { return true; }

    mud_fail( MUD_ERR_XSRF_TOKEN_INVALID );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - protected methods...
  //

  protected function check_init() {

    if ( $this->token ) { return; }

    mud_fail( MUD_ERR_XSRF_NOT_CONFIGURED );

  }
}
