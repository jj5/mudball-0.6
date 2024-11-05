<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../120-debug/mud_debug.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleBuffer.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - service locator...
//
//

function mud_module_buffer() : MudModuleBuffer {

  return mud_locator()->get_module( MudModuleBuffer::class );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - functional interface...
//
//

function mud_buffer_reset() : int {

  return mud_module_buffer()->reset();

}

function mud_buffer_start() : int {

  return mud_module_buffer()->start();

}

function mud_buffer_flush( &$length = null, bool $return = false ) {

  return mud_module_buffer()->flush( $length, $return );

}

function mud_buffer_clear( &$length = null, bool $return = false ) {

  return mud_module_buffer()->clear( $length, $return );

}

function mud_buffer_clear_all( &$length = null, bool $return = false ) {

  return mud_module_buffer()->clear_all( $length, $return );

}
