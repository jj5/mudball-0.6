<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../415-http/mud_http.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_XSRF_TOKEN_MISSING', 'XSRF token missing.' );
mud_define_error( 'MUD_ERR_XSRF_TOKEN_INVALID', 'XSRF token invalid.' );
mud_define_error( 'MUD_ERR_XSRF_NOT_CONFIGURED', 'XSRF not configured.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleXsrf.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-04-16 jj5 - functional interface...
//

function mud_xsrf_configure( string $token_curr, $token_prev = null ) {

  return mud_module_xsrf()->configure( $token_curr, $token_prev );

}

function mud_xsrf_get_token_name() {

  return mud_module_xsrf()->get_token_name();

}

function mud_xsrf_get_token_hash() {

  return mud_module_xsrf()->get_token_hash();

}

function mud_xsrf_check( $request ) {

  return mud_module_xsrf()->check( $request );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_xsrf() : MudModuleXsrf {

  return mud_locator()->get_module( MudModuleXsrf::class );

}
