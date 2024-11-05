<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - trait definition...
//

// 2024-02-06 jj5 - NOTE: if we can't inherit from MudGadget then we can include most of its functionality with this mixin.

trait MudMixin {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-10-21 jj5 - traits...
  //

  use MudCreationMixin;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-23 jj5 - private static fields...
  //

  private static int $counter = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-23 jj5 - private fields...
  //

  // 2024-07-23 jj5 - NOTE: object IDs are out until we have a specific use case for them.
  //
  //private int|false $oid = false;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-06 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [
      'class' => get_class( $this ),
    ];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-06 jj5 - null object support...
  //

  public function is_null() : bool { return false; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - Object ID...
  //

  protected function count_increment() : void {

    self::$counter++;

  }

  public static function new_oid() : int {

    mud_not_implemented();

    return 0;

  }

  public function get_oid() : int|false {

    mud_not_implemented();

    return false;

  }

  protected function set_oid( int $oid ) : void {

    mud_not_implemented();

  }


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

  protected static function get_constant_or_default( string $name, mixed $default = null ) : mixed {

    if ( defined( $name ) ) { return constant( $name ); }

    return $default;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - logging...
  //

  protected static function get_microtime_now() : float { return microtime( $as_float = true ); }

  protected function log_warning( string $message, mixed $context = null ) : void {

    $log_line = $this->format_log_string( $message, $context );

    if ( function_exists( 'mud_log_4_warning' ) ) {

      mud_log_4_warning( $log_line );

    }
    else {

      error_log( $log_line );

    }
  }

  protected function log_debug( string $message, mixed $context = null ) : void {

    $log_line = $this->format_log_string( $message, $context );

    if ( function_exists( 'mud_log_7_debug' ) ) {

      mud_log_7_debug( $log_line );

    }
    else {

      error_log( $log_line );

    }
  }

  protected function format_log_string( string $message, mixed $context = null, string|null $prefix = null ) : string {

    if ( $prefix === null ) {

      $class = get_class( $this );

      $oid = $this->get_oid();

      $result = "[$class:$oid] $message";

    }
    else {

      $result = "{$prefix}{$message}";

    }

    if ( $context !== null ) {

      $result .= ': ' . json_encode( $context, JSON_UNESCAPED_SLASHES );

    }

    return $result;

  }
}
