<?php

// 2024-08-07 jj5 - in this file performance critical functions are implemented directly rather than through the
// MudModuleIo class... the implications of this are that the functions are not as easily mocked for testing, but
// they are faster to execute. Note too that some of the output functions defined in this file omit some of the
// bookkeeping that is done in the MudModuleIo class, such as tracking the number of bytes flushed or cleared.

// 2024-08-07 jj5 - NOTE: buffer management probably isn't ever going to be performance critical, so it's probably
// not worth implementing these functions directly. The input functions might be reviewed in future, but usually output
// is the main game for perf so that's what I have implemented now.

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - functional interface...
//
//

function mud_print( string $line ) : void {

  echo $line;
  echo "\n";

}

function mud_write( string $output ) : void {

  echo $output;

}

function mud_flush( string $output ) : void {

  echo $output;

  flush();

}

function mud_stdout( string $output, bool $flush = false ) : void {

  echo $output;

  if ( $flush ) { flush(); }

}

if ( defined( 'STDERR' ) ) {

  function mud_stderr( string $output, bool $flush = false ) : void {

    fwrite( STDERR, $output );

    if ( $flush ) { fflush( STDERR ); }

  }
}
else {

  function mud_stderr( string $output, bool $flush = false ) : void {

    error_log( $output );

  }
}
