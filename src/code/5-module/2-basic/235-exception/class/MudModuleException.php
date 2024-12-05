<?php

class MudModuleException extends MudModuleBasic {


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleException|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_http_exception(
    int $http_status_code,
<<<<<<< HEAD
    string $http_status_message,
=======
>>>>>>> e3a066e (Work, work...)
    $location = null,
    $data = null,
    $previous = null,
  ) {

<<<<<<< HEAD
    $data = [
      'http_status_code' => $http_status_code,
      'http_status_message' => $http_status_message,
      'location' => $location,
      'data' => $data,
    ];

    return MudHttpException::Create(
      $http_status_code,
      $http_status_message,
=======
    return new MudHttpException(
      $http_status_code,
>>>>>>> e3a066e (Work, work...)
      $location,
      $data,
      $previous
    );

  }
}
