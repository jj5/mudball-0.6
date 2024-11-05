<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - trait definition...
//

// 2024-02-06 jj5 - NOTE: if we can't inherit from MudGadget then we can include most of its functionality with this mixin.

trait MudMixin {


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

  private int|false $oid = false;

  public function get_oid() : int|false { return $this->oid; }

  protected function set_oid( int $oid ) : void {

    $this->oid = $oid;

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
