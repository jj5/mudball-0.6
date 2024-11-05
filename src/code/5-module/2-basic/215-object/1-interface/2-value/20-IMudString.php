<?php

interface IMudString extends IMudAtom {

  public function get_string() : string;

  public function get_hash() : string;

  public function get_length_min() : int;

  public function get_length_max() : int;

  public function get_regex_valid() : array;

  public function get_regex_invalid() : array;

}
