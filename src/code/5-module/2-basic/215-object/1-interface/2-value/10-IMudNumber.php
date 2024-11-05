<?php

interface IMudNumber extends IMudAtom {

  public function get_number() : int|float;

  public function get_value_min_numeric() : int|float;

  public function get_value_max_numeric() : int|float;

}
