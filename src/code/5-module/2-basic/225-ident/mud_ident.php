<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - include dependencies...
//

require_once __DIR__ . '/../215-object/mud_object.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_IDENT_INVALID_EXTERNAL_ID', 'external ID is invalid.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleIdent.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - functional interface...
//

function mud_new_external_id() : int {

  return mud_module_ident()->new_external_id();

}

function mud_format_external_id( int $external_id, $type = null ) {

  return mud_module_ident()->format_external_id( $external_id, $type );

}

function mud_parse_external_id( string $external_id_string ) {

  return mud_module_ident()->parse_external_id( $external_id_string );

}

function mud_try_parse_external_id( string $external_id_string, &$external_id = null ) {

  return mud_module_ident()->try_parse_external_id( $external_id_string, $external_id );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_ident() : MudModuleIdent {

  return mud_locator()->get_module( MudModuleIdent::class );

}
