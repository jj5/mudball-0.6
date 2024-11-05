<?php

class MudSettings extends MudGadget implements ArrayAccess {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - protected fields...
  //

  protected $settings, $defaults;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return array_merge( parent::jsonSerialize(), [
      'settings' => $this->settings,
      'defaults' => $this->defaults,
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - constructor...
  //

  public function __construct( array $settings, array $defaults = [] ) {

    $this->settings = $settings;
    $this->defaults = $defaults;

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public static methods...
  //

  /*
  public static function Create(
    array $settings,
    array $defaults = []
  ) : MudSettings {

    return new_mud_settings( $settings, $defaults );

  }
  */


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - magic methods...
  //

  public function __get( $setting ) {

    if ( array_key_exists( $setting, $this->settings ) ) {

      return $this->read_value( $this->settings, $setting );

    }

    if ( array_key_exists( $setting, $this->defaults ) ) {

      return $this->read_value( $this->defaults, $setting );

    }

    $this->warn( 'missing value for setting.', [ 'setting' => $setting ] );

    return null;

  }

  public function __set( $setting, $value ) {

    $this->settings[ $setting ] = $value;

  }


  //j///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-07-08 jj5 - ArrayAccess interface:
  //

  public function offsetExists( mixed $offset ): bool {

    return array_key_exists( $offset, $this->settings );

  }

  public function offsetGet( mixed $offset ): mixed {

    return $this->read_value( $this->settings, $offset );

  }

  public function offsetSet( mixed $offset, mixed $value ): void {

    $this->settings[ $offset ] = $value;

  }

  public function offsetUnset( mixed $offset ): void {

    unset( $this->settings[ $offset ] );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-05 jj5 - abstract method implementations...
  //

  protected function assert_invariants() {

    if ( ! DEBUG ) { return; }

    $this->assert(
      '$this->settings is an array.',
      is_array( $this->settings )
    );

    $this->assert(
      '$this->defaults is an array.',
      is_array( $this->defaults )
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2019-08-04 jj5 - protected methods...
  //

  protected function read_value( array $container, string $key ) {

    if ( ! array_key_exists( $key, $container ) ) { return null; }

    $value = $container[ $key ];

    if ( ! is_object( $value ) ) { return $value; }

    if ( is_a( $value, 'IMudValueProvider' ) ) {

      return $value->get_value();

    }

    return $value;

  }
}
