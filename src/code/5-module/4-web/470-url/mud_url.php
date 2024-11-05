<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-04 jj5 - include dependencies...
//

require_once __DIR__ . '/../465-webcontext/mud_webcontext.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-05 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_URL_INVALID_PATH', 'invalid path.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleUrl.php';
require_once __DIR__ . '/class/MudUrlBuilder.php';
//require_once __DIR__ . '/class/3-MudHref.php';
//require_once __DIR__ . '/class/4-MudUrl.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-04 jj5 - functional interface...
//

function mud_get_full_request_url() : string {

  return mud_module_url()->get_full_request_url();

}

/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_url() : MudModuleUrl {

  return mud_locator()->get_module( MudModuleUrl::class );

}
