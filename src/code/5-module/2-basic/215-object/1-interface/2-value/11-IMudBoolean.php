<?php

interface IMudBoolean extends IMudNumber {

  public function is_true() : bool;

  public function is_false() : bool;

}
