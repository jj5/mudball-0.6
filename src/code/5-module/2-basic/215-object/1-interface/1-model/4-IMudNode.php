<?php

interface IMudNode extends IMudHost {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - these functions are for searching self and ancsestors...
  //

  public function get_parent() : IMudNode;

  public function get_grandparent() : IMudNode;

  public function get_ancestor( string $class ) : IMudNode;

  public function get_root() : IMudNode;

  // 2024-07-01 jj5 - THINK: get_next( string|null $class = null ) and get_prev( string|null $class = null )

}
