<?php

interface IMudFloat extends IMudNumber {

  public function get_float() : float;

  public function get_value_min_float() : float;

  public function get_value_max_float() : float;

}
