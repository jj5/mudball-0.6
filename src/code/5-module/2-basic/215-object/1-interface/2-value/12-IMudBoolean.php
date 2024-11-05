<?php

interface IMudBoolean extends IMudInteger {

  public function get_bool() : bool;

  public function is_true() : bool;

  public function is_false() : bool;

}
