<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_enum.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - declare tests...
//

declare_tests([


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-19 jj5 - test
  //

  'test' => function() {

    class MudEnumExample extends MudEnum {

      use MudEnumTraits;

      const A = 1;
      const B = 2;

      static $map = [
        'A' => self::A,
        'B' => self::B,
      ];

    }

    class AppEnumExample extends MudEnumExample {

      use AppEnumTraits;

      const Z = 255;
      const Y = 254;

      static $map = [
        'Z' => self::Z,
        'Y' => self::Y,
      ];

    }

    assert( MudEnumExample::GetEnum( 'A' ) === 1 );
    assert( MudEnumExample::GetEnum( 'B' ) === 2 );

    assert( AppEnumExample::GetEnum( 'Z' ) === 255 );
    assert( AppEnumExample::GetEnum( 'Y' ) === 254 );

    assert( MudEnumExample::GetCode( 1 ) === 'A' );
    assert( MudEnumExample::GetCode( 2 ) === 'B' );

    assert( AppEnumExample::GetCode( 255 ) === 'Z' );
    assert( AppEnumExample::GetCode( 254 ) === 'Y' );

    assert( MudEnumExample::GetData() === [ 'A' => 1, 'B' => 2 ] );
    assert( AppEnumExample::GetData() === [ 'A' => 1, 'B' => 2, 'Z' => 255, 'Y' => 254 ] );

    return 0;

  },

]);
