<?php

interface IMudConstant extends IMudValueProvider, JsonSerializable {

  public function get_constant_name() : string;
  public function get_default_value();

}
