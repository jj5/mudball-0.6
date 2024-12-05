<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_basic.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - enum tests
  //

  'enum tests' => function() {

    $enum_dir = __DIR__ . '/../../../2-enum';

    foreach ( scandir( $enum_dir ) as $enum_file ) {

      $path = "$enum_dir/$enum_file";

      if ( ! is_file( $path ) ) { continue; }

      $parts = explode( '.', $enum_file, 2 );

      $class = $parts[ 0 ];

      $data = array_flip( $class::GetData() );

      $ref = app_factory()->new_php_reflection_class( $class );

      $constants = array_flip( $ref->getConstants() );

      foreach ( $data as $enum => $code ) {

        unset( $data[ $enum ] );
        unset( $constants[ $enum ] );

      }

      assert( $data === [] );
      assert( $constants === [] );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - app enum test
  //

  'app enum test' => function() {

    // 2021-03-19 jj5 - here we just make sure that we can GetData on an app enum that doesn't
    // inherit from a particular mud enum.

    class AppExampleEnum extends MudEnum {

      use AppEnumTraits;

      const A = 1;
      const B = 2;

      static $map = [
        'A' => self::A,
        'B' => self::B,
      ];

    }

    assert( AppExampleEnum::GetData() === [ 'A' => 1, 'B' => 2 ] );

    return 0;

  },

]);
