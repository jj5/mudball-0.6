<?php

interface IMudNullObject extends IMudNullThing, ArrayAccess, JsonSerializable {

  public function __get( string $setting );

  public function __set( string $setting, $value );

<<<<<<< HEAD
  public function get_null() : IMudNullObject;

=======
>>>>>>> e3a066e (Work, work...)
}
