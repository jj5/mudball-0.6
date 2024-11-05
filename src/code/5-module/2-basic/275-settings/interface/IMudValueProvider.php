<?php

interface IMudValueProvider {

  public function has_value() : bool;
  public function get_value();

}
