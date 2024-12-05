<?php

interface IMudSign extends IMudInteger {

  public function is_positive() : bool;

  public function is_negative() : bool;

  public function get_factor() : int;

<<<<<<< HEAD
  public function get_sign_char() : string;
=======
  public function get_char() : string;
>>>>>>> e3a066e (Work, work...)

}
