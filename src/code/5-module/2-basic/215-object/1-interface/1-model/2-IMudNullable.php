<?php

interface IMudNullable {

  public function is_null() : bool;

  public function get_null() : IMudNullObject;

  // 2024-07-01 jj5 - these will add the instance to the array so long as the instance is not a null object...
  //
  public function add_to_list( array &$list ) : void;

  public function add_to_map( mixed $key, array &$map ) : void;

}
