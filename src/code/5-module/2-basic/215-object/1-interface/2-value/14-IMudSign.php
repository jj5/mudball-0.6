<?php

interface IMudSign extends IMudInteger {

  public function is_positive() : bool;

  public function is_negative() : bool;

  public function get_factor() : int;

  public function get_sign_char() : string;

}
