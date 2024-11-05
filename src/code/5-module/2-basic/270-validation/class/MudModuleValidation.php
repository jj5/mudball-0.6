<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleValidation extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - public methods...
  //

  public function is_valid_url(
    string $url,
    &$problem = null,
    $required = true,
    $require_scheme = false, // [ 'https', 'http' ],
    $require_host = false
  ) {

    $problem = null;

    if ( ! $this->is_trimmed( $url, $problem ) ) { return false; }

    if ( ! $this->is_ascii_structure( $url, $problem ) ) { return false; }

    if ( $url === '' ) {

      if ( ! $required ) { return true; }

      return $this->problematic( $url, $problem, 'URL is required' );

    }

    $parts = parse_url( $url );

    if ( ! $parts ) {

      return $this->problematic( $url, $problem, 'malformed URL' );

    }

    if ( $require_scheme ) {

      $scheme = $parts[ 'scheme' ] ?? null;

      if ( ! $scheme ) {

        return $this->problematic( $url, $problem, 'scheme missing' );

      }

      if ( is_array( $require_scheme ) ) {

        if ( ! in_array( $scheme, $require_scheme, $strict = true ) ) {

          return $this->problematic( $url, $problem, 'unsupported scheme' );

        }
      }
      else if ( is_string( $require_scheme ) ) {

        if ( $scheme !== $require_scheme ) {

          return $this->problematic( $url, $problem, 'unsupported scheme' );

        }
      }
      else if ( is_bool( $require_scheme ) ) {

        // 2019-11-12 jj5 - nothing more to do in this case...

      }
      else {

        mud_fail(
          MUD_ERR_VALIDATION_URL_SCHEME_SPEC_IS_INVALID,
          [
            'require_scheme' => $require_scheme,
            'url' => $url,
            'parts' => $parts,
          ]
        );

      }
    }

    if ( $require_host ) {

      $host = $parts[ 'host' ] ?? null;

      if ( ! $host ) {

        return $this->problematic( $url, $problem, 'host missing' );

      }

      if ( is_array( $require_host ) ) {

        if ( ! in_array( $host, $require_host, $strict = true ) ) {

          return $this->problematic( $url, $problem, 'unsupported host' );

        }
      }
      else if ( is_string( $require_host ) ) {

        if ( $host !== $require_host ) {

          return $this->problematic( $url, $problem, 'unsupported host' );

        }

      }
      else if ( is_bool( $require_host ) ) {

        // 2019-11-12 jj5 - nothing more to do in this case...

      }
      else {

        mud_fail(
          MUD_ERR_VALIDATION_URL_HOST_SPEC_IS_INVALID,
          [
            'require_host' => $require_host,
            'url' => $url,
            'parts' => $parts,
          ]
        );

      }
    }

    // 2019-11-12 jj5 - if we make it this far we're considered valid...
    //
    return true;

  }

  public function is_valid_email_address(
    string $email_address,
    &$problem = null,
    bool $required = true
  ) {

    $problem = null;

    if ( ! $this->is_trimmed( $email_address, $problem ) ) { return false; }

    if ( ! $this->is_ascii_structure( $email_address, $problem ) ) { return false; }

    if ( $email_address === '' ) {

      if ( ! $required ) { return true; }

      return $this->problematic( $url, $problem, 'email address is required' );

    }

    if ( ! $this->is_valid_format( $email_address, MUD_REGEX_VALID_EMAIL ) ) {

      return $this->problematic( $email_address, $problem, 'email address is not valid' );

    }

    return true;

  }

  public function is_valid_username(
    string $username,
    &$problem = null,
    bool $required = true
  ) {

    // 2019-11-12 jj5 - the idea with the banned list is to try and avoid
    // things which might create a problem for us, we probably don't want
    // to go silly banning names like 'god' or 'sickcunt' or whatever, such
    // usage can be managed administratively if and when required...
    //
    static $banned_usernames = null;

    if ( $banned_usernames === null ) {

      // 2021-04-13 jj5 - TODO: support additional banned usernames in config file...

      $banned_usernames = [ 'root', 'null', 'n-a', ];

    }

    $problem = null;

    if ( ! $this->is_trimmed( $username, $problem ) ) { return false; }

    if ( ! $this->is_ascii_structure( $username, $problem ) ) { return false; }

    if ( $username === '' ) {

      if ( ! $required ) { return true; }

      return $this->problematic( $username, $problem, 'username is required' );

    }

    if ( in_array( $username, $banned_usernames, $strict = true ) ) {

      return $this->problematic( $username, $problem, 'username is not allowed' );

    }

    if ( ! $this->is_valid_format( $username, MUD_REGEX_VALID_USERNAME ) ) {

      return $this->problematic( $email_address, $problem, 'username is not valid' );

    }

    return true;

  }

  public function is_trimmed( $value, &$problem = null ) {

    $problem = null;

    if ( preg_match( '/^\s+/', $value ) ) {

      return $this->problematic( $value, $problem, 'invalid leading whitespace' );

    }

    if ( preg_match( '/\s+$/', $value ) ) {

      return $this->problematic( $value, $problem, 'invalid trailing whitespace' );

    }

    return true;

  }

  // 2019-11-12 jj5 - for our purposes a 'structure' is an ASCII string which
  // doesn't contain non-printable characters or whitespace... this is a
  // useful validation for e.g. URLs, email addresses, and usernames.
  //
  public function is_ascii_structure( string $value, &$problem = null ) {

    $problem = null;

    if ( ! $this->is_ascii_printable( $value, $problem ) ) { return false; }

    if ( preg_match( '/\s/', $value ) ) {

      return $this->problematic( $value, $problem, 'value contains unsupported spatial characters' );

    }

    return true;

  }

  public function is_ascii_printable( string $value, &$problem = null ) {

    $problem = null;

    if ( ! $this->is_ascii( $value, $problem ) ) { return false; }

    if ( preg_match( '/[\x00-\x1f\x7f]+/', $value ) ) {

      return $this->problematic( $value, $problem, 'value contains non-printable characters' );

    }

    return true;

  }

  public function is_ascii( string $value, &$problem = null ) {

    static $encodings = [ 'ASCII' ];

    $problem = null;

    if ( 'ASCII' === mb_detect_encoding( $value, $encodings, $strict = true ) ) { return true; }

    return $this->problematic( $value, $problem, 'value is not ASCII' );

    // 2022-01-29 jj5 - OLD:
    /*

    $problem = null;

    if ( preg_match( '/[\x80-\xff]+/', $value ) ) {

      return $this->problematic( $value, $problem, 'value contains unsupported (non-ASCII) characters' );

    }

    return true;

    */

  }

  public function is_utf8( string $value, &$problem = null ) {

    static $encodings = [ 'UTF-8' ];

    $problem = null;

    if ( 'UTF-8' === mb_detect_encoding( $value, $encodings, $strict = true ) ) { return true; }

    return $this->problematic( $value, $problem, 'value is not UTF-8' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - protected methods...
  //

  protected function is_valid_format( string $input, string $regex ) {

    $problem = null;

    return preg_match( $regex, $input ) ? true : false;

  }

  protected function problematic( $value, &$problem, $set_problem ) {

    $problem = $set_problem;

    if ( function_exists( 'app' ) ) {

      $function = debug_backtrace()[ 1 ][ 'function' ];

      app()->log_validation_problem( $function, $value, $problem );

    }

    return false;

  }
}
