<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

// 2018-07-20 jj5 - SEE: PHP and Enumerations discussion on Stack Overflow:
// https://stackoverflow.com/q/254514/868138

abstract class MudEnum {

  // 2020-03-26 jj5 - WARNING: if you extend standard lookups implemented by
  // PHPBOM (prefixed with 'Bom') then the static $map data defined on
  // the enum objects will not include your extensions. You should *not*
  // modify the $map (there isn't really any sensible way to do that), rather
  // you should override the static methods and use a switch statement for
  // your supplemental values and then defer to the base implementation for
  // everything else. In this way you can extend enums to suit yourself and
  // stay up-to-date with whatever the PHPBOM library does now and into the
  // future. Also, if you are adding enum values, you should insert them with
  // your schema definitions into the lookup table, and you should start your
  // values high (e.g. 255) and count backwards so that your lookups and
  // the PHPBOM lookups can peacefully co-exist (for codes include a
  // capital letter to ensure no conflict). If you find that PHPBOM is calling
  // static methods where your replacement static methods should be being
  // called instead please let us know because there should always be an
  // indirection which allows you to insert a call to your extensions.

  static public function GetEnum( string $code ) : int {

    $class = get_called_class();

    return $class::GetData()[ $code ] ??  0;

  }

  static public function IsValidCode( string $code ) {

    return self::GetEnum( $code ) !== 0;

  }

  static public function GetCode( int $enum, bool $fail_on_missing = false ) {

    $class = get_called_class();

    $map = $class::GetData();

    foreach ( $map as $code => $item ) {

      if ( $item === $enum ) { return $code; }

    }

    if ( $fail_on_missing ) {

      throw app_factory()->new_php_exception( "Missing enum '$enum' on class '$class'." );

    }

    return null;

  }
}
