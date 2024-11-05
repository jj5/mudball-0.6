<?php

trait MudHostMixin {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - private fields...
  //

  private array $child_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public static methods...
  //

  public static function get_null_object( $class_or_object ) {
  
    $class = is_string( $class_or_object ) ? $class_or_object : get_class( $class_or_object );

    $null_class = 'Null' . $class;

    return $null_class::Instance();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public instance methods...
  //

  public function get( string $class, int $index = 0 ) : IMudObject {

    if ( $index === 0 ) { return $this->get_first( $class ); }

    return $this->get_list( $class )[ $index ] ?? self::get_null_object( $class );

  }

  public function get_first( string $class ) : IMudObject {

    $this->build_map( $class );

    return $this->child_map[ $class ][ 0 ] ?? self::get_null_object( $class );  

  }

  public function get_last( string $class ) : IMudObject {

    $this->build_map( $class );

    $list = $this->child_map[ $class ];

    return $list[ count( $list ) - 1 ] ?? self::get_null_object( $class );  

  }

  public function get_descendent( string $class ) : IMudObject {

    return $this->get_descendent_depth_first( $class );

  }

  public function get_descendent_depth_first( string $class ) : IMudObject {

    $this->build_map( $class );

    $list = $this->child_map[ $class ] ?? [];

    if ( $list ) { return $list[ 0 ]; }

    foreach ( $this->get_child_list() as $child ) {

      $result = $child->get_descendent_depth_first( $class );

      if ( ! $result->is_null() ) { return $result; }

    }

    return self::get_null_object( $class );

  }

  public function get_descendent_breadth_first( string $class ) : IMudObject {

    $queue = $this->get_child_list();

    while ( $queue ) {

      $child = array_shift( $queue );

      if ( $child instanceof $class ) { return $child; }

      $queue = array_merge( $queue, $child->get_child_list() );

    }

    return self::get_null_object( $class );

  }

  public function get_list( string|null $class = null ) : array {

    if ( $class === null ) { return $this->get_child_list(); }

    $this->build_map( $class );

    return $this->child_map[ $class ];

  }

  public function get_any( array $class_list ) : IMudObject {

    foreach ( $class_list as $class ) {

      $this->build_map( $class );

      if ( isset( $this->child_map[ $class ] ) ) { return $this->child_map[ $class ][ 0 ]; }

    }

    return self::get_null_object( $class_list[ 0 ] );

  }

  public function get_all( array $class_list ) : array {

    $result = [];

    foreach ( $class_list as $class ) {

      $this->build_map( $class );

      foreach ( $this->child_map[ $class ] as $child ) {
        
        $result[] = $child;

      }
    }

    return $result;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - protected instance methods...
  //

  protected function build_map( string $class ) {

    if ( isset( $this->child_map[ $class ] ) ) { return; }

    $this->child_map[ $class ] = [];

    foreach ( $this->get_child_list() as $child ) {

      if ( $child instanceof $class ) { $this->child_map[ $class ][] = $child; }

    }
  }
}
