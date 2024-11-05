<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-07 jj5 - module errors...
//



/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-07 jj5 - class definition...
//

class MudModuleSecret extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleSecret|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public methods...
  //

  public function read_stdin( $prompt = MUD_SECRET_PROMPT_DEFAULT, $secret = null ) {

    // 2021-08-07 jj5 - NOTE: in this function the `stty` calls are non-essential and we don't
    // try to do error handling on them.

    // 2021-08-07 jj5 - note that this loop will be short-circuited if $secret is already set and
    // was passed in which is just a convenience for the caller who may have read the secret from
    // the command line options for instance...
    //
    while ( ! $secret ) {

      // 2021-08-07 jj5 - prompt the user for the secret...
      //
      mud_stdout( $prompt );

      // 2021-08-07 jj5 - disable echo on the TTY so that password is not shown on screen...
      //
      shell_exec( 'stty -echo' );

      // 2021-08-07 jj5 - read one line of input from STDIN...
      //
      $input = fgets( STDIN );

      // 2021-08-07 jj5 - restore the TTY...
      //
      shell_exec( 'stty echo' );

      // 2021-08-07 jj5 - remove the trailing new line character...
      //
      $secret = substr( $input, 0, -1 );

      // 2021-08-07 jj5 - put a new line on STDOUT as the new line in STDIN was captured...
      //
      mud_stdout( "\n" );

    }

    return $secret;

  }

  public function generate( $length = 32 ) {

    return mud_new_token( $length );

  }
}
