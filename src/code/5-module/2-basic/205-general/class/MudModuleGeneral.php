<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleGeneral extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - private fields...
  //

  private $ready = false;
  private $trace = false;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  // 2018-06-17 jj5 - init() is called early, but late. Call it immediately
  // after you have finished loading your application and all its modulues
  // but before you start running your main code...
  //
  // 2018-06-17 jj5 - THINK: do we want to check that init() has been called
  // before running other functionality..? I don't think that's really
  // important at this stage but might become important at some stage...
  //
  public function init( array &$argv = [] ) : MudModuleGeneral {

    if ( $this->ready ) { return $this; }

    // 2018-06-17 jj5 - this is obviously not atomic. We set it early in case
    // of re-entrancy... if initialisation fails this flag can be considered
    // corrupted...
    //
    $this->ready = true;

    // 2018-07-16 jj5 - setup the PHP environment here... there are probably
    // other things we could add here to be sensible..?
    //
    // 2018-07-16 jj5 - THINK: do we need to do other config here for character
    // encoding, timezones, anything like that..?
    //
    error_reporting( ~0 );

    // 2021-03-04 jj5 - all multibyte stuff should be UTF-8...
    //
    mb_internal_encoding( MUD_UTF8 );
    mb_regex_encoding( MUD_UTF8 );
    mb_http_output( MUD_UTF8 );

    // 2021-02-25 jj5 - SEE: how to configure mail message encoding:
    // https://www.php.net/manual/en/function.mb-language.php
    //
    mb_language( 'uni' );

    // 2019-08-01 jj5 - SEE: apparently this is important in some situations:
    // https://stackoverflow.com/a/1287209
    //
    // 2021-03-04 jj5 - NOTE: if this is annoying you or creating a problem let me know at
    // jj5@progclub.org and we'll figure out what we need to do...
    //
    setlocale( LC_CTYPE, 'en_AU.UTF8' );

    // 2018-06-17 jj5 - here we read in our command line arguments, if we
    // have any...

    $done = false;
    $new_argv = [];

    for ( $i = 0; $i < count( $argv ); $i++ ) {

      $arg = $argv[ $i ];

      if ( $done ) { $new_argv[] = $arg; continue; }

      switch ( $arg ) {

        case '--trace' :

          // 2020-04-17 jj5 - TODO: revisit this tracing thing, it doesn't
          // seem like a terrible idea to be able to enable/disable tracing...

          $this->trace = true;

          break;

        default :

          $new_argv[] = $arg;

      }
    }

    $argv = $new_argv;

    // 2018-05-29 jj5 - here we define standard constants that we want to have
    // globally available in all of our applications. If they haven't been set
    // by now we configure them with default values...
    //
    foreach ( [ 'DEBUG', 'DEV', 'DB_ENABLE', 'TEST', 'BETA' ] as $const ) {

      if ( ! defined( $const ) ) { define( $const, false ); }

    }

    if ( ! defined( 'CONSOLE' ) ) { define( 'CONSOLE', mud_is_cli() ); }

    return $this;

  }

  public function is_bool_name( string $name ) : bool {

    static $prefix_list = [
      'a_is_', 'is_',
      'a_has_', 'has_',
      'a_was_', 'was_',
      'a_can_', 'can_',
      'a_should_', 'should_',
      'a_will_', 'will_',
    ];

    foreach ( $prefix_list as $prefix ) {

      if ( strpos( $name, $prefix ) === 0 ) { return true; }

    }

    return false;

  }

  public function is_missing( $value ) : bool {

    if ( ! $value ) { return true; }

    if ( method_exists( $value, 'is_null' ) ) { return $value->is_null(); }

    return false;

  }

  public function assert( $test, $error = MUD_ERR_GENERAL, $data = null ) {

    if ( $test ) { return; }

    mud_fail( $error, $data );

  }
}
