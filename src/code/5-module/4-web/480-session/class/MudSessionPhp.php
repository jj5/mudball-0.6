<?php

class MudSessionPhp extends MudSession {

  public function __construct() {

    parent::__construct();

    session_start();

  }

  public function set_user( $user ) {

    $_SESSION[ 'user-id' ] = $user->get_id();

  }

  public function get_user() {

    $user_id = $_SESSION[ 'user-id' ] ?? null;

    if ( ! $user_id ) { return app_null_object(); }

    return app_orm()->get_mud_user([
      A_STD_USER_ID => $user_id
    ]);

  }

  public function get_session_token() {

    if ( ! array_key_exists( 'session-token', $_SESSION ) ) {

      $_SESSION[ 'session-token' ] = mud_new_token();

    }

    return $_SESSION[ 'session-token' ];

  }

  public function flash( $message = null ) {

    if ( $message ) {

      $this->write_cookie( 'flash', $message );

    }
    else {

      $flash = mud_request()->get_cookie( 'flash' );

      $this->clear_cookie( 'flash' );

      return $flash;

    }
  }

  protected function write_cookie( $name, $value ) {

    setcookie( $this->get_cookie_name( $name ), $value, 0, '/' );

  }

  protected function clear_cookie( $name ) {

    $cookie_name = $this->get_cookie_name( $name );

    if ( ! array_key_exists( $cookie_name, $_COOKIE ) ) { return; }

    setcookie( $cookie_name, '', 0, '/' );

  }

  protected function get_cookie_name( $name ) {

    $cookie_prefix = mud_get_config( [ 'app', 'cookie', 'prefix' ], APP_CODE . '_' );

    return "{$cookie_prefix}{$name}";

  }
}
