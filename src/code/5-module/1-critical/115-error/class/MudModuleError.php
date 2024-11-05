<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: this module class provides facilities for defining errors and throwing exceptions based on those
// errors. It also provides facilities for redacting secrets from data structures.

class MudModuleError extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - private fields...
  //

  private array $error_map = [];

  private array $name_map = [];

  private array $scope_map = [];

  private array $counter_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - constructor...
  //

  public function __construct( MudModuleError|null $previous = null ) {

    parent::__construct( $previous );

    if ( $previous ) {

      $this->error_map = $previous->error_map;
      $this->name_map = $previous->name_map;
      $this->scope_map = $previous->scope_map;
      $this->counter_map = $previous->counter_map;

    }

    if ( ! defined( 'MUD_ERR_SUCCESS' ) ) {

      $this->add_error( 0, 'MUD_ERR_SUCCESS', 'program completed successfully.' );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - destructor...
  //

  public function __destruct() {

    if ( mud_is_dev() ) {

      $this->save_error_constants();

    }

    parent::__destruct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_exception(
    string|null $message,
    int|null $code,
    Throwable|null $previous,
    string $name,
    string $hint,
    mixed $data,
  ) {

    return new MudException( $message, $code, $previous, $name, $hint, $data );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - public methods...
  //

  public function get_error_text( $code ) { return $this->error_map[ $code ][ 'text' ] ?? null; }

  public function get_error_name( $code ) { return $this->error_map[ $code ][ 'name' ] ?? null; }
  
  public function get_error_hint( $code ) { return $this->error_map[ $code ][ 'hint' ] ?? null; }

  public function define_error(
    string $name,
    string $text,
    string $hint = '',
    string $scope = MUDBALL_CODE
  ) {

    // 2021-02-27 jj5 - the $tranche is the number of errors which can be declared per scope...
    //
    static $tranche = 10000;

    if ( ! $name ) {

      mud_fail( MUD_ERR_ERROR_NAME_IS_REQUIRED );

    }

    if ( array_key_exists( $name, $this->name_map ) ) {

      mud_fail( MUD_ERR_ERROR_NAME_IS_DUPLICATE, [ 'name' => $name ] );

    }

    if ( ! array_key_exists( $scope, $this->scope_map ) ) {

      $this->scope_map[ $scope ] = count( $this->scope_map ) + 1;
      $this->counter_map[ $scope ] = 0;

    }

    $scope_base = $this->scope_map[ $scope ] * $tranche;

    $counter = $this->counter_map[ $scope ]++;

    if ( $counter === $tranche ) {

      mud_fail(
        MUD_ERR_ERROR_LIMIT_EXCEEDED,
        [
          'scope' => $scope,
          'counter' => $counter,
        ]
      );

    }

    $code = $scope_base + $counter;

    $this->add_error( $code, $name, $text, $hint, $scope );

  }


  public function not_implemented( $data = null ) {

    mud_fail( MUD_ERR_NOT_IMPLEMENTED, $data );

  }

  public function not_supported( $data = null ) {

    mud_fail( MUD_ERR_NOT_SUPPORTED, $data );

  }

  public function not_possible( $data = null ) {

    mud_fail( MUD_ERR_NOT_POSSIBLE, $data );

  }

  public function fail(
    $code_or_message,
    $data = null,
    $previous = null,
    &$code = null,
    &$name = null,
    &$message = null,
    &$hint = null
  ) {

    $this->read_error_info( $code_or_message, $code, $name, $message, $hint );

    throw new_mud_exception( $message, $code, $previous, $name, $hint, $data );

  }

  public function redact_secrets(
    $input,
    array $whitelist = [],
    array $blacklist = []
  ) {

    return $this->redact_secrets_inner( $input, $whitelist, $blacklist, true );

  }

  public function read_error_info(
    $code_or_message,
    &$code,
    &$name,
    &$message = null,
    &$hint = null
  ) {

    if ( isset( $this->error_map[ $code_or_message ] ) ) {

      $code = intval( $code_or_message );
      $name = $this->error_map[ $code ][ 'name' ];
      $text = $this->error_map[ $code ][ 'text' ];
      $message = $message ? $message : "error while processing: {$text}";
      $hint = $this->error_map[ $code ][ 'hint' ];

    }
    else {

      $code = MUD_ERR_GENERAL;
      $name = 'MUD_ERR_GENERAL';
      $message = strval( $code_or_message );
      $hint = '';

    }
  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - protected methods...
  //

  protected function save_error_constants() {

    $this->save_constant_map(
      $this->error_map,
      function( $name ) { return preg_match( '/MUD_ERR_EXAMPLE_\d+/', $name ); },
    );

  }

  protected function add_error(
    int $code,
    string $name,
    string $text,
    string $hint = '',
    string $scope = MUDBALL_CODE
  ) {

    define( $name, $code );

    $this->error_map[ $code ] = [
      'code' => $code,
      'name' => $name,
      'text' => $text,
      'hint' => $hint,
      'scope' => $scope,
    ];

    $this->name_map[ $name ] = $code;

  }

  protected function redact_secrets_inner(
    $input,
    array $whitelist,
    array $blacklist,
    $prep = false
  ) {

    // 2018-06-17 jj5 - short circut some common values and data types...
    //
    if ( $input === null ) { return $input; }
    if ( $input === [] ) { return $input; }
    if ( is_string( $input ) ) { return $input; }
    if ( is_bool( $input ) ) { return $input; }
    if ( is_int( $input ) ) { return $input; }
    if ( is_float( $input ) ) { return $input; }

    // 2017-02-22 jj5 - NOTE: this function tries to sanitise data by
    //  removing passwords/secrets. It also removes data which might be
    //  problematic when it comes time for JSON serialisation.

    // 2017-02-25 jj5 - DONE: added support for RC4 secrets...

    // 2017-02-26 jj5 - DONE: added support for 'argv' secrets...

    // 2018-06-17 jj5 - DONE: added support for whitelist and blacklist...

    // 2018-08-14 jj5 - NOTE: wrap filters in '|' (pipe) characters for
    // regular expression matching, otherwise substrings are matched.

    // 2018-06-17 jj5 - the whitelist is processed before the blacklist, and
    // it thus applies preferentially...
    //
    static $global_whitelist = [

      // 2021-02-27 jj5 - this is an example of whitelisting, usually 'pass' will be blacklisted
      // but if it's 'pass' in 'compass' then it is probably safe... if you have a
      // 'compass_password' you are gonna have a bad time!
      //
      'compass',

      // 2022-04-05 jj5 - if it's an e.g. 'password hash' or 'password hash id' then that's ok...
      //
      'hash',

    ];

    // 2018-06-17 jj5 - the blacklist is processed after the whitelist and can
    // be used to redact values which have not otherwise been whitelisted...
    //
    static $global_blacklist = [

      // 2021-02-27 jj5 - this is for e.g. 'passwd' and 'password' we have 'compass' as a
      // whitelist above, and whitelisting takes precedence...
      //
      'pass',

      // 2021-02-27 jj5 - if you need to make sure content is redacted then put the substring
      // 'secret' in your variable name!
      //
      'secret',

      // 2021-02-27 jj5 - this was for support for this thing I had to deal with one time...
      //
      'rc4',

      // 2021-02-27 jj5 - these are a best efforts attempt to make sure command-line arguments
      // and arguments from stack traces are redacted which is trying to err on the side of
      // safety...
      //
      // 2022-02-24 jj5 - OLD: I've removed this because I need to know it a lot of the time and
      // you shouldn't be passing secrets this way anyhow...
      //'|^argv$|',

      // 2022-03-20 jj5 - these are in...
      //'|.*args$|'

    ];

    $data = null;

    if ( $prep ) {

      try {

        // 2021-02-27 jj5 - THINK: we should probably think about this max depth setting... the
        // default is 512 which is insane. Anything more than 3 or 4 probably isn't useful
        // anyway, so we're gonna go with 4 in the hope that we will have enough memory to cope
        // with that level if there's a cycle in the object graph... if it turns out there is
        // important missing data due to this setting it is probably okay to increase it a little.
        //
        $max_depth = 4;

        // 2020-03-11 jj5 - if this can't complete because of an out of
        // memory problem it's probaby because your object graph contains
        // a cycle. So implement JsonSerializable and remove the cycle.

        $json = json_encode(
          $input,
          JSON_PARTIAL_OUTPUT_ON_ERROR,
          $max_depth
        );

        $data = json_decode( $json, $assoc = true );

      }
      catch ( Exception $ex ) {

        // 2021-02-27 jj5 - this really shouldn't happen...

        $data = null;

      }
    }
    else {

      $data = $input;

    }

    if ( is_object( $data ) ) {

      $data = array_keys( get_class_vars( get_class( $data ) ) );

    }

    // 2018-06-17 jj5 - as redaction works via key names, and as non-array
    // data have no keys, the default for non-array data is simply to return...
    //
    if ( ! is_array( $data ) ) { return $data; }

    $whitelist = array_merge( $global_whitelist, $whitelist );
    $blacklist = array_merge( $global_blacklist, $blacklist );

    foreach ( $data as $key => $val ) {

      if ( is_object( $val ) ) {

        $val = array_keys( get_class_vars( get_class( $val ) ) );

      }

      $redact = false;

      $check = strtolower( trim( $key ) );

      if ( $this->is_match( $whitelist, $check, false ) ) {

        $redact = false;

      }
      else if ( $this->is_match( $blacklist, $check, true ) ) {

        $redact = true;

      }

      if ( $redact ) {

        $data[ $key ] = '**REDACTED**';

      }

      if ( is_array( $data[ $key ] ) ) {

        // 2018-06-17 jj5 - nested data doesn't need to be prepared again, we
        // prepared the whole lot once when we started...
        //
        $data[ $key ] = $this->redact_secrets_inner(
          $data[ $key ],
          $whitelist,
          $blacklist
        );

      }
    }

    return $data;

  }

  protected function is_match(
    array $filters,
    string $check,
    bool $default,
    string $regex_marker = '|'
  ) : bool {

    // 2018-06-17 jj5 - NOTE: if you want case-insensitive matching convert
    // inputs to lower case prior to calling... or use a regular expression
    // with the 'i' modifier...

    foreach ( $filters as $filter ) {

      // 2021-02-24 jj5 - the idea with these $default returns is that if the filter is
      // invalid then everything gets redacted, just to be safe.

      if ( ! is_string( $filter ) ) { return $default; }

      if ( $filter === '' ) { return $default; }

      if (
        ( $filter[ 0 ] === $regex_marker && preg_match( $filter, $check ) ) ||
        ( strpos( $check, $filter ) !== false )
      ) {

        return true;

      }
    }

    return false;

  }
}
