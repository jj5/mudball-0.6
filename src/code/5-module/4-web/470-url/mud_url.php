<?php


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-04 jj5 - include dependencies...
//

require_once __DIR__ . '/../460-viewstate/mud_viewstate.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-04 jj5 - include dependencies...
//

require_once __DIR__ . '/../465-webcontext/mud_webcontext.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2021-09-05 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_URL_INVALID_PATH', 'invalid path.' );


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleUrl.php';
require_once __DIR__ . '/class/MudUrlBuilder.php';
//require_once __DIR__ . '/class/3-MudHref.php';
//require_once __DIR__ . '/class/4-MudUrl.php';


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2021-09-04 jj5 - functional interface...
//

function mud_get_full_request_url() : string {

  return mud_module_url()->get_full_request_url();

}

<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_url() : MudModuleUrl {

  return mud_locator()->get_module( MudModuleUrl::class );

}
<<<<<<< HEAD

function mud_url() : MudUrl {

  return mud_locator()->get_service( MudUrl::class );

}
=======
>>>>>>> e3a066e (Work, work...)
