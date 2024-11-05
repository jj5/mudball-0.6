<?php

class MudClientState extends MudGadget {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - private fields...
  //

  private $state = [];


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - public methods...
  //

  public function get_state( string $name, $default = null ) {

    return $this->state[ $name ] ?? $default;

  }

  public function set_state( string $name, $value ) {

    $this->state[ $name ] = $value;

  }

  public function clear_state( string $name ) {

    unset( $this->state[ $name ] );

  }

  public function clear_all_state() {

    $this->state = [];

  }

  public function save_state() {

    mud_set_cookie( 'state', json_encode( $this->state ) );

  }

  public function load_state() {

    $state = mud_get_cookie( 'state' );

    if ( $state ) {

      $this->state = json_decode( $state, true );

    }
  }
}
