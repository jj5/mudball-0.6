<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - class definition...
//

class MudModuleInput extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - public instance methods...
  //

  public function read_acord( mixed $input, string|null $default = '' ) : string|null {

    $value = $this->read_ascii( $input, null );

    if ( $value === null ) { return $default; }

    return mud_normalize_space( $value );

  }

  public function read_ucord( mixed $input, string|null $default = '' ) : string|null {


  }

  public function read_atext( mixed $input, string|null $default = '' ) : string|null {


  }

  public function read_utext( mixed $input, string|null $default = '' ) : string|null {


  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - protected instance methods...
  //

  protected function read_ascii( $value, $default ) {

    $value = $this->read_cord( $value, null );

    if ( $value === null ) { return $default; }

    return iconv( 'UTF-8', 'us-ascii//TRANSLIT', $value );

  }

  protected function read_cord( $value, $default ) {

    $value = $this->read_text( $value, null );

    if ( $value === null ) { return $default; }

    return trim( $value );

  }

  protected function read_text( $value, $default ) {

    if ( is_null( $value ) ) { return $default; }

    if ( is_object( $value ) ) {

      if ( method_exists( $object, '__toString' ) ) {

        $value = strval( $object );

      }
      else {

        return $default;

      }
    }

    if ( is_string( $value ) ) { return mud_strip_control_chars( $value ); }

    if ( is_bool( $value ) ) { return $value ? 'true' : 'false'; }

    if ( is_int( $value ) || is_float( $value ) ) { return strval( $value ); }

    // 2019-11-06 jj5 - THINK: format DateTime..?

    return $default;

  }
}
