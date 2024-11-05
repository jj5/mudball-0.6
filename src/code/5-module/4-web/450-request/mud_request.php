<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include dependencies...
//

require_once __DIR__ . '/../445-facility/mud_facility.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudSubmission.php';
require_once __DIR__ . '/interface/IMudRequest.php';

require_once __DIR__ . '/class/MudRequest.php';
require_once __DIR__ . '/class/MudRequestReader.php';
require_once __DIR__ . '/class/MudModuleRequest.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - factory methods...
//

function new_mud_request_reader() {

  return mud_module_request()->new_mud_request_reader();

}

function new_mud_request(
  string $verb,
  array $headers,
  ?string $http_user_agent,
  ?string $http_accept,
  ?string $http_accept_language,
  ?string $http_accept_encoding,
  ?string $http_if_modified_since,
  ?string $http_if_none_match,
  string $scheme,
  string $host,
  int $port,
  string $controller_path,
  array $request_path_parts,
  ?array $selector,
  array $criteria,
  array $submission,
  array $files,
  array $cookies,
  array $state,
  $facility,
) {

  return mud_module_request()->new_mud_request(
    $verb,
    $headers,
    $http_user_agent,
    $http_accept,
    $http_accept_language,
    $http_accept_encoding,
    $http_if_modified_since,
    $http_if_none_match,
    $scheme,
    $host,
    $port,
    $controller_path,
    $request_path_parts,
    $selector,
    $criteria,
    $submission,
    $files,
    $cookies,
    $state,
    $facility,
  );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locators...
//

function mud_module_request() : MudModuleRequest {

  return mud_locator()->get_module( MudModuleRequest::class );

}

function mud_request() : MudRequest {

  return mud_locator()->get_service( MudRequest::class );

}
