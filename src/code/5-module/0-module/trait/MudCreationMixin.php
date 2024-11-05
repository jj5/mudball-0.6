<?php

trait MudCreationMixin {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-10-21 jj5 - public static methods...
  //

  public static function Create() : object {

    static $class_map = [];

    $class = get_called_class();

    if ( ! isset( $class_map[ $class ] ) ) {

      $class_map[ $class ] = new ReflectionClass( self::get_best_class( $class ) );

    }

    $result = $class_map[ $class ]->newInstanceArgs( func_get_args() );

    if ( ! $result ) {

      throw new Exception( "Failed to create instance of class '$class'." );

    }

    return $result;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-10-21 jj5 - protected static methods...
  //

  protected static function get_best_class( string $class ) : string {

    static $class_map = [];

    if ( ! isset( $class_map[ $class ] ) ) {

      if ( preg_match( '/^Mud[A-Z]/', $class ) ) {

        $indicator = substr( $class, 3 );

        $app_class = "App$indicator";

        if ( class_exists( $app_class ) ) {

          $class_map[ $class ] = $app_class;

        }
        else {

          $class_map[ $class ] = $class;

        }
      }
      else {

        $class_map[ $class ] = $class;

      }
    }

    return $class_map[ $class ];

  }
}
