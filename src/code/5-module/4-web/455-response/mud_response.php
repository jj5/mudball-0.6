<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include dependencies...
//

require_once __DIR__ . '/../450-request/mud_request.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudResponse.php';

require_once __DIR__ . '/class/MudResponse.php';
require_once __DIR__ . '/class/MudModuleResponse.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - factory methods...
//

function new_mud_response() {

  return mud_module_response()->new_mud_response();

}

function mud_response( MudResponse|false $set = false ) : MudResponse {

  static $instance = false;

  if ( $set !== false ) {

    $instance = $set;

  }
  else if ( $instance === false ) {

    $instance = MudResponse::Create();

  }

  return $instance;

}

function mud_new_client_id() {

  return mud_module_response()->new_client_id();

}

function mud_get_client_id() {

  return mud_module_response()->get_client_id();

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locator...
//

function mud_module_response() : MudModuleResponse {

  return mud_locator()->get_module( MudModuleResponse::class );

}
