<?php

class MudFloat extends MudNumber implements IMudFloat {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private float $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( float $value ) {

    parent::__construct();

    $this->value = $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - Stringable interface...
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

    return $this->value >= $this->get_value_min_float() && $this->value <= $this->get_value_max_float();

  }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  //public function is_integer( int $n ) : bool { return $this->to_int() === $n; }

  public function is_nan() : bool { return is_nan( $this->value ); }

  public function to_bool() : bool { return boolval( $this->value ); }

  public function to_int() : int { return intval( $this->value ); }

  public function to_float() : float { return floatval( $this->value ); }

  public function to_string() : string { return strval( $this->value ); }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : int|float|string|null { return $this->is_nan() ? null : $this->value; }

  public function format( mixed $spec = null ) : string {

    $spec = $this->get_format( $spec );

    $decimals = intval( $spec ?? 0 );

    return number_format( $this->value, $decimals, '.', ',' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - IMudNumber interface...
  //


  public function get_number() : float|int { return $this->value; }

  public function get_value_min_numeric() : int|float { return $this->get_value_min_float(); }

  public function get_value_max_numeric() : int|float { return $this->get_value_max_float(); }



  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - IMudFloat interface...
  //

  public function get_float() : float { return $this->value; }

  public function get_value_min_float() : float { return -INF; }

  public function get_value_max_float() : float { return INF; }

}
