<?php


define( 'MUD_VALUE_NEGATIVE_FACTOR', -1 );
define( 'MUD_VALUE_NEGATIVE_STRING', '-' );
define( 'MUD_VALUE_NEGATIVE_CHAR', '-' );


class MudNegative extends MudSign implements IMudNegative {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - Stringable interface...
  //

  public function __toString() : string { return MUD_VALUE_NEGATIVE_STRING; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return false; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //

  public function is_valid( mixed $options = null ) : bool { return true; }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return false; }

  public function is_integer( int $n ) : bool { return $n === MUD_VALUE_NEGATIVE_FACTOR; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return false; }

  public function to_int() : int { return MUD_VALUE_NEGATIVE_FACTOR; }

  public function to_float() : float { return MUD_VALUE_NEGATIVE_FACTOR; }

  public function to_string() : string { return MUD_VALUE_NEGATIVE_STRING; }

  public function get_value() : int { return MUD_VALUE_NEGATIVE_FACTOR; }

  public function get_db_value() : int { return MUD_VALUE_NEGATIVE_FACTOR; }

  public function format( mixed $spec = null ) : string { return MUD_VALUE_NEGATIVE_STRING; }

  public function set_parent( IMudNode $parent ) : void { ; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNumber interface...
  //

  public function get_number() : float|int { return MUD_VALUE_NEGATIVE_FACTOR; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudSign interface...
  //

  public function is_positive() : bool { return false; }

  public function is_negative() : bool { return true; }

  public function get_factor() : int { return MUD_VALUE_NEGATIVE_FACTOR; }

  public function get_char() : string { return MUD_VALUE_NEGATIVE_CHAR; }

}
