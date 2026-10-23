<?php declare(strict_types=1);

class MudModuleHttp_EgressCookie extends MudModuleHttp_EgressHeader {

  function delete_all_cookies() {

    // 2017-02-23 jj5 - SEE: How to delete all cookies of my website:
    //  http://stackoverflow.com/questions/2310558/#2310591

    if ( ! isset( $_SERVER[ 'HTTP_COOKIE' ] ) ) { return; }

    $cookies = explode( ';', $_SERVER[ 'HTTP_COOKIE' ] );

    foreach ( $cookies as $cookie ) {

      $parts = explode( '=', $cookie, 2 );
      $name = trim( $parts[ 0 ] );
      setcookie( $name, '', time() - 1000 );
      setcookie( $name, '', time() - 1000, '/' );

    }
  }

  function delete_cookie( $key ) {

    $cookie_name = $this->get_cookie_name( $key );

    if ( $this->is_live() ) {

      setrawcookie(
        $cookie_name,
        '',
        time() - ( 60 * 60 * 24 * 7 ),
        $this->get_cookie_path()
      );

    }

    if ( array_key_exists( $cookie_name, $_COOKIE ) ) {

      unset( $_COOKIE[ $cookie_name ] );

    }
  }

}
