<?php

class MudFalse extends MudBoolean implements IMudFalse {


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

  public function is_zero() : bool { return true; }

<<<<<<< HEAD
  //public function is_integer( int $n ) : bool { return $n === 0; }
=======
  public function is_integer( int $n ) : bool { return $n === 0; }
>>>>>>> e3a066e (Work, work...)

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return false; }

  public function to_int() : int { return 0; }

  public function to_float() : float { return 0.0; }

  public function to_string() : string { return $this->format(); }

<<<<<<< HEAD
  public function get_value() : mixed { return 0; }

=======
>>>>>>> e3a066e (Work, work...)
  public function get_db_value() : int { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudNumber interface...
  //


  public function get_number() : float|int { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudBoolean interface...
  //

<<<<<<< HEAD
  public function get_bool() : bool { return false; }
=======
  public function get_value() : bool|null { return false; }
>>>>>>> e3a066e (Work, work...)

  public function is_true() : bool { return false; }

  public function is_false() : bool { return true; }

}
