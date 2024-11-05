<?php

trait MudHostMixin {

  public function get_child_list() : array { return []; }

  public function get( string $class, int $index = 0 ) : IMudObject {

    if ( $index === 0 ) { return $this->get_first( $class ); }

    return $this->get_list( $class )[ $index ] ?? mud_get_null_object();

  }

  public function get_first( string $class ) : IMudObject {

    foreach ( $this->get_child_list() as $child ) {

      if ( $child instanceof $class ) { return $child; }

    }

    return mud_get_null_object();

  }

  public function get_last( string $class ) : IMudObject {

    $list = $this->get_list( $class );

    return $list[ count( $list ) - 1 ] ?? mud_get_null_object();

  }

  public function get_descendent( string $class ) : IMudObject {

    return $this->get_descendent_depth_first( $class );

  }

  public function get_descendent_depth_first( string $class ) : IMudObject {

    foreach ( $this->get_child_list() as $child ) {

      if ( $child instanceof $class ) { return $child; }

      $result = $child->get_descendent_depth_first( $class );

      if ( ! $result->is_null() ) { return $result; }

    }

    return mud_get_null_object();

  }

  public function get_descendent_breadth_first( string $class ) : IMudObject {

    $queue = $this->get_child_list();

    while ( $queue ) {

      $child = array_shift( $queue );

      if ( $child instanceof $class ) { return $child; }

      $queue = array_merge( $queue, $child->get_child_list() );

    }

    return mud_get_null_object();

  }

  public function get_list( string|null $class = null ) : array {

    if ( $class === null ) { return $this->get_child_list(); }

    $result = [];

    foreach ( $this->get_child_list() as $child ) {

      if ( $child instanceof $class ) { $result[] = $child; }

    }

    return $result;

  }

  public function get_any( array $class_list ) : IMudObject {

    foreach ( $class_list as $class ) {

      foreach ( $this->get_child_list() as $child ) {
        
        if ( $child instanceof $class ) { return $child; }

      }
    }

    return mud_get_null_object();

  }

  public function get_all( array $class_list ) : array {

    $result = [];

    foreach ( $class_list as $class ) {

      foreach ( $this->get_child_list() as $child ) {
        
        if ( $child instanceof $class ) { $result[] = $child; }

      }
    }

    return $result;

  }
}