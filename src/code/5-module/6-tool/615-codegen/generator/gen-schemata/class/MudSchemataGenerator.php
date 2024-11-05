<?php

class MudSchemataGenerator extends MudGenerator {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - protected fields...
  //

  protected $verbose = true;
  protected $debug = false;
  protected $script_path = null;
  protected $target = null;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //

  function run( $argv ) {

    //
    // 2021-03-29 jj5 - set up and check our environemnt...
    //

    if ( $argv === null ) {

      die( 'This is a command-line app, not a web app.' );

    }

    //
    // 2021-03-29 jj5 - parse our command-line...
    //

    $this->script_path = array_shift( $argv );

    $this->script_path = realpath( $this->script_path );

    $this->target = array_shift( $argv );

    if ( ! is_dir( $this->target ) ) {

      $this->error( 'invalid target.', MUD_TOOL_EXIT_INVALID_TARGET );

    }

    $path = $this->get_path( 'schemata.dat' );

    if ( ! is_file( $path ) ) {

      // 2022-04-08 jj5 - this can happen if we've never run the schema generator before...

      //assert( false, 'are we in the right place..?' );

    }

    while ( $arg = array_shift( $argv ) ) {

      switch ( $arg ) {

        case '--debug'    : $this->debug    = true;   break;
        case '--verbose'  : $this->verbose  = true;   break;
        case '--quiet'    : $this->verbose  = false;  break;

        default :

          $this->value_error( 'unsupported argument', $arg, MUD_TOOL_EXIT_UNKNOWN_ARG );

      }
    }

    $schemata = MudSchemata::Load( $use_cache = false );

    file_put_contents( $path, serialize( $schemata ) );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //

  public function get_path( $file_name ) {

    return $this->target . '/' . $file_name;

  }
}
