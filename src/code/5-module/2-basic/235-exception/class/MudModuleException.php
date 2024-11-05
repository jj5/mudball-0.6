<?php

class MudModuleException extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_http_exception(
    int $http_status_code,
    string $http_status_message,
    $location = null,
    $data = null,
    $previous = null,
  ) {

    $data = [
      'http_status_code' => $http_status_code,
      'http_status_message' => $http_status_message,
      'location' => $location,
      'data' => $data,
    ];

    return MudHttpException::Create(
      $http_status_code,
      $http_status_message,
      $location,
      $data,
      $previous
    );

  }
}
