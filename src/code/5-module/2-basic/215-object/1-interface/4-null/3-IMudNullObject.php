<?php

interface IMudNullObject extends IMudNullThing, ArrayAccess, JsonSerializable {

  public function __get( string $setting );

  public function __set( string $setting, $value );

}
