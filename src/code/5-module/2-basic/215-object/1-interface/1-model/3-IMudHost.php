<?php

interface IMudHost extends IMudNullable {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - these functions are for searching self and children
  //

  public function get_child_list() : array;

  public function get( string $class, int $index = 0 ) : IMudObject;

  public function get_first( string $class ) : IMudObject;

  public function get_last( string $class ) : IMudObject;

  public function get_descendent( string $class ) : IMudObject;

  public function get_descendent_depth_first( string $class ) : IMudObject;

  public function get_descendent_breadth_first( string $class ) : IMudObject;

  public function get_list( string|null $class = null ) : array;

  public function get_any( array $class_list ) : IMudObject;

  public function get_all( array $class_list ) : array;

}
