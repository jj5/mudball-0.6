<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../255-time/mud_time.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_DEFINE_CONSTANTS_ALREADY_DEFINED', 'constants already defined.' );
mud_define_error( 'MUD_ERR_DEFINE_APP_CONSTANTS_CANNOT_BE_REDEFINED', 'cannot redefine app constants.' );
mud_define_error( 'MUD_ERR_DEFINE_APP_CONSTANT_IS_ALREADY_DEFINED', 'app constant already defined.' );
mud_define_error( 'MUD_ERR_DEFINE_VERSION_CONSTANT_IS_UNDEFINED', 'version constant not defined.' );
mud_define_error( 'MUD_ERR_DEFINE_CONSTANT_DEFINITION_IS_REQUIRED', 'constant definition required.' );
mud_define_error( 'MUD_ERR_DEFINE_CONSTANT_VALUE_IS_INVALID', 'invalid constant value.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleDefine.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - define ourselves...
//

mud_define_version( 'MUDBALL' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-07-15 jj5 - functional interface...
//

function mud_get_constants( string $prefix = '' ) {

  return mud_module_define()->get_constants( $prefix );

}

function mud_define_version( string $prefix ) {

  return mud_module_define()->define_version( $prefix );

}

function mud_define_app( string $prefix ) {

  return mud_module_define()->define_app( $prefix );

}

function mud_define_default( string $name, $value ) {

  return mud_module_define()->define_default( $name, $value );

}

function mud_require_define( string $name, $value ) {

  return mud_module_define()->require_define( $name, $value );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_define() : MudModuleDefine {

  return mud_locator()->get_module( MudModuleDefine::class );

}
