<?php

class MudReader extends MudService {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-10 jj5 - public methods...
  //

  public function read( $col_name, $default = null, $sub_name = null ) {

    if ( $sub_name === null ) {

      $name_parts = explode( '_', $col_name, 3 );

      $sub_name = str_replace( '_', '-', $name_parts[ 2 ] );

    }

    $value = mud_request()->get_value( $sub_name, $default );

    $valid = mud_schema()->is_valid( $col_name, $value, $problem );

    if ( ! $valid ) {

      mud_response()->set_error( $sub_name, $problem );

    }

    return $value;

  }
}
