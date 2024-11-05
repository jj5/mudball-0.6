<?php

class MudObjectValue extends MudAtom implements IMudObjectValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-03 jj5 - private fields...
  //

  private object|null $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-03 jj5 - constructor...
  //

  public function __construct( object|null $value = null ) {

    parent::__construct();

    $this->value = $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-03 jj5 - Stringable interface...
  //

  public function __toString() : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return false; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudValue interface...
  //

  public function is_valid( mixed $options = null ) : bool {

    return true;

  }

  public function is_empty() : bool { return empty( $this->get_value() ); }

  public function is_zero() : bool { return false; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return ! $this->is_empty(); }

  public function to_int() : int { return intval( $this->to_string() ); }

  public function to_float() : float { return floatval( $this->to_string() ); }

  public function to_string() : string { return strlva( $this->get_value() ); }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : int|float|string|null { return $this->get_value()->get_db_value(); }

  public function format( mixed $spec = null ) : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-03 jj5 - IMudObjectValue interface...
  //

  public function get_object() : object|null { return $this->value; }

}
