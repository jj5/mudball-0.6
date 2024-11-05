<?php

interface IMudInteger extends IMudNumber {

  public function get_int() : int;

  public function get_value_min_integer() : int;

  public function get_value_max_integer() : int;

}
