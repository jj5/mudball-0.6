<?php

class AppRequest extends MudRequest {

  public function get_value( $name, $default = null ) {

    $result = parent::get_value( $name, $default );

    //error_log( "$name = $result" );

    return $result;

  }
}
