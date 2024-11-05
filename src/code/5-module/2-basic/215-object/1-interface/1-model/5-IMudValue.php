<?php

interface IMudValue extends IMudHost {

  public function is_empty() : bool;

  public function is_zero() : bool;

  //public function is_integer( int $compare ) : bool;

  public function is_nan() : bool;

  public function to_bool() : bool;

  public function to_int() : int;

  public function to_float() : float;

  public function get_value() : mixed;

  public function get_db_value() : int|float|string|null;

  public function get_sort_value() : int|float|string|null;

  public function get_key() : string;

  public function set_key( string $key ) : void;

}
