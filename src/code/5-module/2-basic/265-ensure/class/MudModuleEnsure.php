<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleEnsure extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleEnsure|null $previous = null) {

    parent::__construct( $previous );

  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - public methods...
  //

  public function is_string( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( is_string( $value ), 'is a string', $variable, $value );

  }

  public function is_not_string( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( ! is_string( $value ), 'is not a string', $variable, $value );

  }

  public function is_array( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( is_array( $value ), 'is an array', $variable, $value );

  }

  public function is_not_array( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( ! is_array( $value ), 'is not an array', $variable, $value );

  }

  public function is_empty( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( empty( $value ), 'is empty', $variable, $value );

  }

  public function is_not_empty( $value, string $variable = MUD_DEFAULT_VARIABLE ) {

    $this->ensure( ! empty( $value ), 'is not empty', $variable, $value );

  }

  public function is_defined( string $constant ) {

    $this->ensure( defined( $constant ), 'is defined', $constant, null );

  }

  public function is_not_defined( string $constant ) {

    $this->ensure( ! defined( $constant ), 'is not defined', $constant, null );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - protected methods...
  //

  protected function ensure(
    bool $true,
    string $requirement,
    string $variable,
    $value
  ) {

    if ( $true ) { return true; }

    mud_fail(
      MUD_ERR_ENSURE_REQUIREMENT_VIOLATED,
      [ 'requirement' => $requirement, 'variable' => $variable, 'value' => $value ]
    );

  }
}
