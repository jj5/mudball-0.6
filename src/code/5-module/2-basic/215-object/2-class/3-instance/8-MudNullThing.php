<?php

abstract class MudNullThing extends MudNullValue implements IMudNullThing {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudNode interface...
  //

  public function get_parent() : IMudNode { return $this; }

  public function get_grandparent() : IMudNode { return $this; }

  public function get_ancestor( string $class ) : IMudNode { return $this; }

  public function get_root() : IMudNode { return $this; }

}
