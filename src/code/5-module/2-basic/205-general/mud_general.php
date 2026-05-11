<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../200-basic/mud_basic.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleGeneral.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-11 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_VERIFICATION_FAILED', 'verification failed.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//

function mud_init( array $argv = [] ) : MudModuleGeneral {

  return mud_module_general()->init( $argv );

}

function mud_is_bool_name( string $name ) : bool {

  return mud_module_general()->is_bool_name( $name );

}

function mud_is_missing( $value ) : bool {

  return mud_module_general()->is_missing( $value );

}

function mud_assert( $test, $error = MUD_ERR_GENERAL, $data = null ) {

  return mud_module_general()->assert( $test, $error, $data );

}

function mud_verify( bool $test, string $file, int $line, array $data = [] ) {

  return mud_module_general()->verify( $test, $file, $line, $data );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_general() : MudModuleGeneral {

  return mud_locator()->get_module( MudModuleGeneral::class );

}
