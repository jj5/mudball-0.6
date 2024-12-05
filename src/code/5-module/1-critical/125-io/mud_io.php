<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../120-debug/mud_debug.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleIo.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//
//

function mud_buffer_reset() : int {

  return mud_module_io()->reset();

}

function mud_buffer_start() : int {

  return mud_module_io()->start();

}

function mud_buffer_flush( &$length = null, bool $return = false ) {

  return mud_module_io()->flush( $length, $return );

}

function mud_buffer_clear( &$length = null, bool $return = false ) {

  return mud_module_io()->clear( $length, $return );

}

function mud_buffer_clear_all( &$length = null, bool $return = false ) {

  return mud_module_io()->clear_all( $length, $return );

}

function mud_read_acord( $input ) {

  return mud_module_io()->read_acord( $input );

}

function mud_read_ucord( $input ) {

  return mud_module_io()->read_ucord( $input );

}

function mud_read_atext( $input ) {

  return mud_module_io()->read_atext( $input );

}

function mud_read_utext( $input ) {

  return mud_module_io()->read_utext( $input );

}


function mud_print( $line, &$bytes_written = null ) : string {

  return mud_module_io()->printline( $line, $bytes_written );

}

function mud_write( $output, &$bytes_written = null ) : string {

  return mud_module_io()->stdout( $output, $flush = false, $bytes_written );

}

function mud_flush( $output, &$bytes_written = null ) : string {

  return mud_module_io()->stdout( $output, $flush = true, $bytes_written );

}

function mud_stdout( $output, bool $flush = false, &$bytes_written = 0 ) : string {

  return mud_module_io()->stdout( $output, $flush, $bytes_written );

}

function mud_stderr( $output, bool $flush = false, &$bytes_written = 0 ) : string {

  return mud_module_io()->stderr( $output, $flush, $bytes_written );

}


/////////////////////////////////////////////////////////////////////////////
// 2021-02-24 JJ5 - service locator...
//
//

function mud_module_io() : MudModuleIo {

  return mud_locator()->get_module( MudModuleIo::class );

}
