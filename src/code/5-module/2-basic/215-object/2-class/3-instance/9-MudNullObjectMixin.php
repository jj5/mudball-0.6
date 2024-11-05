<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - traits definition...
//

trait MudNullObjectMixin {

  // 2020-04-17 jj5 - NOTE: it was a tough call to decide between returning
  // $this or 'null' for method invocations, either can be problematic.
  // I decided that returning null was probably the least worst option. It
  // would have been good if PHP had an interface which could be used to
  // signal 'null' e.g. __isNull, and also maybe __isTrue, __toBool, __toInt,
  // etc.


  //
  // 2020-03-24 jj5 - public methods...
  //

  public function is_null() : bool { return true; }

  // 2024-07-01 jj5 - NOTE: I don't remember what is_missing() is supposed to mean so I've commented out for now...
  //
  //public function is_missing() { return true; }


  //
  // 2020-03-24 jj5 - magic methods...
  //

  public function __set( string $name, $value ) { ; }

  public function __get( string $name ) { return $this->get_prop( $name ); }

  public function __isset( string $name ) : bool { return false; }

  public function __unset( string $name ) { ; }

  public function __call( string $name, array $arguments ) { $this->get_prop( $name ); }

  public function __invoke() { return null; }

  public static function __callStatic( string $name, array $arguments ) { return null; }

  public function __toString() { return ''; }


  //
  // 2019-10-20 jj5 - ArrayAccess interface:
  //

  public function offsetExists( mixed $name ): bool { return false; }

  public function offsetGet( mixed $name ): mixed { return $this->get_prop( $name ); }

  public function offsetSet( mixed $name, mixed $value ): void { ; }

  public function offsetUnset( mixed $name ): void { ; }


  //
  // 2020-03-24 jj5 - JsonSerialize interface...
  //

  public function jsonSerialize(): mixed { return null; }


  //
  // 2020-03-22 jj5 - protected methods...
  //

  protected function get_prop( string $name ) {

    if ( mud_is_bool_name( $name ) ) { return false; }

    return null;

  }
}
