<?php declare(strict_types=1);

class MudModuleHttp_IngressCookie extends MudModuleHttp_IngressHeader {

  private $cookie_path = null;
  private $cookie_prefix = null;
  private $cookie_secure = null;

  function set_cookie_path( $path ) {

    $this->cookie_path = $path;

  }

  function get_cookie_path() {

    if ( $this->cookie_path === null ) {

      global $config;

      if ( isset( $config[ 'cookie' ][ 'path' ] ) ) {

        $this->cookie_path = $config[ 'cookie' ][ 'path' ];

      }
    }

    return $this->cookie_path;

  }

  function set_cookie_prefix( $prefix ) {

    $this->cookie_prefix = $prefix;

  }

  function get_cookie_prefix() {

    if ( $this->cookie_prefix === null ) {

      global $config;

      if ( isset( $config[ 'cookie' ][ 'prefix' ] ) ) {

        $this->cookie_prefix = $config[ 'cookie' ][ 'prefix' ];

      }

      $this->cookie_prefix = strval( $this->cookie_prefix );

    }

    return $this->cookie_prefix;

  }

  function set_cookie_secure( $secure ) {

    $this->cookie_secure = $secure;

  }

  function get_cookie_secure() {

    if ( $this->cookie_secure === null ) {

      global $config;

      if ( isset( $config[ 'cookie' ][ 'secure' ] ) ) {

        $this->cookie_secure = $config[ 'cookie' ][ 'secure' ];

      }
    }

    return $this->cookie_secure;

  }

  function get_cookie_name( $key ) {

    return $this->get_cookie_prefix() . $key;

  }

  function has_cookie( $name, $value = null ) {

    if ( ! array_key_exists( $name, $_COOKIE ) ) { return false; }

    if ( $value !== null && $_COOKIE[ $name ] === $value ) { return true; }

    return false;

  }

  // set a session cookie that can be read by client-side javascript
  function set_dom_cookie( $key, $value ) {

    $this->set_session_cookie( $key, $value, false );

  }

  // 2017-02-23 jj5 - TODO: in both set_session_cookie() and set_browser_cookie()
  //  need to change COOKIE_PREFIX to HTTP_COOKIE_PREFIX, COOKIE_PATH to
  //  HTTP_COOKIE_PATH and SECURE to HTTP_SECURE. Then we need to ensure these
  //  constants have sensible default and are set automatically if necessary.
  //
  function set_session_cookie( $key, $value, $http_only = true ) {

    $cookie_name = $this->get_cookie_name( $key );

    // 2017-04-03 jj5 - DONE: we don't set the cookie if it's already set...
    //
    if ( $this->has_cookie( $cookie_name, $value ) ) { return; }

    $cookie_value = rawurlencode( $value );

    if ( mud_is_web() ) {

      setrawcookie(
        $cookie_name,
        $cookie_value,
        0,
        $this->get_cookie_path(),
        null,
        $this->get_cookie_secure(),
        $http_only
      );

    }

    // 2017-04-03 jj5 - DONE: we record that we've set the cookie (so we can
    // check later and avoid setting it twice)...

    $_COOKIE[ $cookie_name ] = $value;

  }

  function set_browser_cookie( $key, $value, $days = 365, $http_only = true ) {

    $cookie_name = $this->get_cookie_name( $key );

    $cookie_value = rawurlencode( $value );

    $expires = time() + ( 60 * 60 * 24 * $days );

    if ( mud_is_web() ) {

      setrawcookie(
        $cookie_name,
        $cookie_value,
        $expires,
        $this->get_cookie_path(),
        null,
        $this->get_cookie_secure(),
        $http_only
      );

    }
  }

  function get_cookie( $key, $default = null ) {

    return $this->read_array(
      $this->get_cookie_name( $key ),
      $_COOKIE,
      $default
    );

  }

  function get_session_cookie_name() {

    $name = get_config( [ 'cookie', 'session' ] );

    if ( is_string( $name ) ) {

      return $this->get_cookie_name( $name );

    }

    return null;

  }

  function get_browser_cookie_name() {

    $name = get_config( [ 'cookie', 'browser' ] );

    if ( is_string( $name ) ) {

      return $this->get_cookie_name( $name );

    }

    return null;

  }

}
