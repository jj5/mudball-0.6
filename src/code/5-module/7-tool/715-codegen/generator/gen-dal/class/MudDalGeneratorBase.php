<?php

abstract class MudDalGeneratorBase extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - private fields...
  //

  private $host;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - constructor...
  //

  public function __construct( MudDalGenerator $host ) {

    parent::__construct();

    $this->host = $host;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - protected methods...
  //

  protected function get_host() { return $this->host; }

  protected function quote( $input ) { return str_replace( "'", "\\'", $input ); }

  protected function get_generated_by( $path, $line ) { return $this->host->get_generated_by( $path, $line ); }

  protected function report( $line ) {

    return $this->host->report( $line );

  }

  protected function error( $problem, int $error_level ) {

    return $this->host->error( $problem, $error_level );

  }

  protected function value_error( $problem, $value, int $error_level ) {

    return $this->host->value_error( $problem, $value, $error_level );

  }

  protected function get_path( $file_name ) {

    return $this->host->get_path( $file_name );

  }

  protected function print_header() {

    $this->host->print_header();

  }
}
