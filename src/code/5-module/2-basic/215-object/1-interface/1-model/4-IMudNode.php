<?php

interface IMudNode extends IMudHost {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - these functions are for searching self and ancsestors...
  //

  public function get_closest( string $class ) : IMudNode;

  public function get_parent( string|null $class = null ) : IMudNode;

  public function get_grandparent( string|null $class = null ) : IMudNode;

  public function get_ancestor( string|null $class = null ) : IMudNode;

  public function get_root( string|null $class = null ) : IMudNode;

  // 2024-07-01 jj5 - THINK: get_next( string|null $class = null ) and get_prev( string|null $class = null )

}
