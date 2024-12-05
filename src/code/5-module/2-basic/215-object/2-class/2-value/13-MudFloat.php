<?php

class MudFloat extends MudNumber implements IMudFloat {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private float $value;

<<<<<<< HEAD
=======
  private float $max_value;

  private float $min_value;

>>>>>>> e3a066e (Work, work...)

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

<<<<<<< HEAD
  public function __construct( float $value ) {

    parent::__construct();

    $this->value = $value;

=======
  public function __construct( float $value, float $max_value = INF, float $min_value = -INF ) {

    $this->value = $value;

    $this->max_value = $max_value;
    $this->min_value = $min_value;

>>>>>>> e3a066e (Work, work...)
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

<<<<<<< HEAD
    return $this->value >= $this->get_value_min_float() && $this->value <= $this->get_value_max_float();
=======
    return $this->value >= $this->min_value && $this->value <= $this->max_value;
>>>>>>> e3a066e (Work, work...)

  }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

<<<<<<< HEAD
  //public function is_integer( int $n ) : bool { return $this->to_int() === $n; }
=======
  public function is_integer( int $n ) : bool { return $this->to_int() === $n; }
>>>>>>> e3a066e (Work, work...)

  public function is_nan() : bool { return is_nan( $this->value ); }

  public function to_bool() : bool { return boolval( $this->value ); }

  public function to_int() : int { return intval( $this->value ); }

  public function to_float() : float { return floatval( $this->value ); }

  public function to_string() : string { return strval( $this->value ); }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : int|float|string|null { return $this->is_nan() ? null : $this->value; }

  public function format( mixed $spec = null ) : string {

<<<<<<< HEAD
    $spec = $this->get_format( $spec );

=======
>>>>>>> e3a066e (Work, work...)
    $decimals = intval( $spec ?? 0 );

    return number_format( $this->value, $decimals, '.', ',' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
  // 2024-07-29 jj5 - IMudNumber interface...
=======
  // 2024-06-29 jj5 - IMudNumber interface...
>>>>>>> e3a066e (Work, work...)
  //


  public function get_number() : float|int { return $this->value; }

<<<<<<< HEAD
  public function get_value_min_numeric() : int|float { return $this->get_value_min_float(); }

  public function get_value_max_numeric() : int|float { return $this->get_value_max_float(); }



  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - IMudFloat interface...
  //

  public function get_float() : float { return $this->value; }

  public function get_value_min_float() : float { return -INF; }

  public function get_value_max_float() : float { return INF; }

=======
>>>>>>> e3a066e (Work, work...)
}
