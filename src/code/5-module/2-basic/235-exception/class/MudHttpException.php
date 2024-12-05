<?php

class MudHttpException extends MudException {

<<<<<<< HEAD
  protected $http_status_code, $http_status_message, $location;

  public function __construct(
    int $http_status_code,
    string $http_status_message,
=======
  protected $http_status_code, $location;

  public function __construct(
    int $http_status_code,
>>>>>>> e3a066e (Work, work...)
    $location = null,
    $data = null,
    $previous = null
  ) {

    mud_module_error()->read_error_info(
      MUD_ERR_EXCEPTION_HTTP,
      $code,
      $name,
      $message,
      $hint
    );

    parent::__construct( $message, $code, $previous, $name, $hint, $data );

    $this->http_status_code = $http_status_code;
<<<<<<< HEAD
    $this->http_status_message = $http_status_message;
=======
>>>>>>> e3a066e (Work, work...)
    $this->location = $location;

  }

  public function get_http_status_code() { return $this->http_status_code; }
<<<<<<< HEAD
  public function get_http_status_message() { return $this->http_status_message; }
=======
>>>>>>> e3a066e (Work, work...)
  public function get_location() { return $this->location; }

}
