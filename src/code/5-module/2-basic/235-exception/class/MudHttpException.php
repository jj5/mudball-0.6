<?php

class MudHttpException extends MudException {

  protected $http_status_code, $location;

  public function __construct(
    int $http_status_code,
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
    $this->location = $location;

  }

  public function get_http_status_code() { return $this->http_status_code; }
  public function get_location() { return $this->location; }

}
