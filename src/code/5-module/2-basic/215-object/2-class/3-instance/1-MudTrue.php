<?php

class MudTrue extends MudBoolean implements IMudTrue {


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

  public function is_valid( mixed $options = null ) : bool { return true; }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return false; }

  //public function is_integer( int $n ) : bool { return $n === 1; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return true; }

  public function to_int() : int { return 1; }

  public function to_float() : float { return 1.0; }

  public function to_string() : string { return $this->format(); }

  public function get_value() : mixed { return 1; }

  public function get_db_value() : int { return 1; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudNumber interface...
  //


  public function get_number() : float|int { return 1; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudBoolean interface...
  //

  public function get_bool() : bool { return true; }

  public function is_true() : bool { return true; }

  public function is_false() : bool { return false; }

}
