<?php

class MudConstant extends MudGadget implements IMudConstant {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - protected fields...
  //

  protected $constant_name, $default_value;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return array_merge( parent::jsonSerialize(), [
      'constant_name' => $this->get_constant_name(),
      'default_value' => $this->get_default_value(),
      'has_value' => $this->has_value(),
      'value' => $this->get_value(),
    ]);

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - constructor...
  //

  public function __construct( string $constant_name, $default_value ) {

    $this->constant_name = $constant_name;
    $this->default_value = $default_value;

    parent::__construct();

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public static methods...
  //

  public static function Declare(
    string $constant_name,
    $default_value = null
  ) : IMudConstant {

    static $cache = [];

    // 2019-08-04 jj5 - so we cache constant objects if their default value
    // is null... this should be safe because MudConstant objects are
    // immutable...

    if ( $default_value === null ) {

      if ( array_key_exists( $constant_name, $cache ) ) {

        return $cache[ $constant_name ];

      }

      $const = self::Create( $constant_name, null );

      $cache[ $constant_name ] = $const;

      return $const;

    }

    return self::Create( $constant_name, $default_value );

  }

  public static function Create( $constant_name, $default_value ) {

    return new_mud_constant( $constant_name, $default_value );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  //
  // 2019-08-04 jj5 - IMudConstant interface...
  //

  public function get_constant_name() : string { return $this->constant_name; }

  public function get_default_value() { return $this->default_value; }

  //
  // 2019-08-04 jj5 - IMudValueProvider interface...
  //

  public function has_value() : bool {

    return defined( $this->constant_name );

  }

  public function get_value() {

    if ( $this->has_value() ) { return constant( $this->constant_name ); }

    return $this->default_value;

  }
}
