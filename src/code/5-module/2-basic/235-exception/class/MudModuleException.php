<?php

class MudModuleException extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleException|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_http_exception(
    int $http_status_code,
    $location = null,
    $data = null,
    $previous = null,
  ) {

    return new MudHttpException(
      $http_status_code,
      $location,
      $data,
      $previous
    );

  }
}
