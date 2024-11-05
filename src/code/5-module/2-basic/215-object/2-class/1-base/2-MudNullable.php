<?php

abstract class MudNullable extends MudObject implements IMudNullable {

  public function is_null() : bool { return false; }

  public function get_null() : IMudNullObject { return mud_null_object(); }

  public function add_to_list( array &$list ) : void { $list[] = $this; }

  public function add_to_map( mixed $key, array &$map ) : void { $map[ $key ] = $this; }

}
