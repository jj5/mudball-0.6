<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../400-web/mud_web.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleHttp.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - functional interface...
//

function mud_is_http_query() {

  return mud_module_http()->is_http_query();

}

function mud_is_http_submission() {

  return mud_module_http()->is_http_submission();

}

function mud_get_http_verb() {

  return mud_module_http()->get_http_verb();

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_http() : MudModuleHttp {

  return mud_locator()->get_module( MudModuleHttp::class );

}
