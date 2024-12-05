<?php


define( 'MUD_STRING_HASH_FUNCTION', 'sha512/224' );


class MudString extends MudAtom implements IMudString {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private string $value;

<<<<<<< HEAD
=======
  private int $max_length;

  private int $min_length;

>>>>>>> e3a066e (Work, work...)

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

<<<<<<< HEAD
  public function __construct( string $value = '' ) {

    parent::__construct();

    $this->value = $value;

=======
  public function __construct( string $value, int $max_length = PHP_INT_MAX, int $min_length = 0 ) {

    $this->value = $value;

    $this->max_length = $max_length;
    $this->min_length = $min_length;

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
    $value = $this->get_string();

    if ( strlen( $value ) < $this->get_length_min() ) { return false; }

    if ( strlen( $value ) > $this->get_length_max() ) { return false; }

    foreach ( $this->get_regex_valid() as $regex ) {

      if ( ! preg_match( $regex, $value ) ) { return false; }

    }

    foreach ( $this->get_regex_invalid() as $regex ) {

      if ( preg_match( $regex, $value ) ) { return false; }

    }
=======
    if ( strlen( $this->value ) < $this->min_length ) { return false; }

    if ( strlen( $this->value ) > $this->max_length ) { return false; }
>>>>>>> e3a066e (Work, work...)

    return true;

  }

<<<<<<< HEAD
  public function is_empty() : bool { return strlen( $this->get_string() ) === 0; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  public function is_nan() : bool { return ! is_numeric( $this->get_string() ); }

  public function to_bool() : bool { return boolval( $this->get_string() ); }

  public function to_int() : int { return intval( $this->get_string() ); }

  public function to_float() : float { return floatval( $this->get_string() ); }

  public function to_string() : string { return $this->get_string(); }

  public function get_value() : mixed { return $this->get_string(); }

  public function get_db_value() : int|float|string|null { return $this->get_string(); }

  public function format( mixed $spec = null ) : string { return $this->get_string(); }
=======
  public function is_empty() : bool { return strlen( $this->value ) === 0; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  public function is_integer( int $n ) : bool { return $this->to_int() === $n; }

  public function is_nan() : bool { return ! is_numeric( $this->value ); }

  public function to_bool() : bool { return boolval( $this->value ); }

  public function to_int() : int { return intval( $this->value ); }

  public function to_float() : float { return floatval( $this->value ); }

  public function to_string() : string { return $this->value; }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : int|float|string|null { return $this->value; }

  public function format( mixed $spec = null ) : string { return $this->value; }
>>>>>>> e3a066e (Work, work...)


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudString interface...
  //

<<<<<<< HEAD
  public function get_string() : string { return $this->value; }

  public function get_hash() : string { return self::hash( $this->get_string() ); }

  public function get_length_min() : int { return 0; }

  public function get_length_max() : int { return PHP_INT_MAX; }

  public function get_regex_valid() : array { return []; }

  public function get_regex_invalid() : array { return []; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public static methods...
=======
  public function get_hash() : string { return self::hash( $this->to_string() ); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public staic methods...
>>>>>>> e3a066e (Work, work...)
  //

  public static function hash( $string ) { return hash( MUD_STRING_HASH_FUNCTION, $string ); }

}
