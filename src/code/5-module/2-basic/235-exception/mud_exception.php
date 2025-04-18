<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-05 jj5 - include dependencies...
//

require_once __DIR__ . '/../225-ident/mud_ident.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-05 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_EXCEPTION_HTTP', 'HTTP completion.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudHttpException.php';
require_once __DIR__ . '/class/MudModuleException.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - factory methods...
//

function new_mud_http_exception(
  int $http_status_code,
  string $http_status_message,
  $location = null,
  $data = null,
  $previous = null,
) {

  return mud_module_exception()->new_mud_http_exception(
    $http_status_code,
    $http_status_message,
    $location,
    $data,
    $previous,
  );

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locator...
//

function mud_module_exception() : MudModuleException {

  return mud_locator()->get_module( MudModuleException::class );

}
