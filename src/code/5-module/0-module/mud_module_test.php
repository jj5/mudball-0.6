<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../host/dev/test-early.php';
require_once __DIR__ . '/mud_module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - declare tests...
//

declare_tests([


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - funcitonal interface...
  //

  'is-debug' => function() {

    assert( mud_is_debug() );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - PHP factory methods...
  //

  'new_php_std_class' => function() {

    assert( is_a( new_php_std_class(), stdClass::class ) );

    return 0;

  },

  'new_php_exception' => function() {

    $tests = [
      // message    code    previous
      [ 'message',  123,    new ExampleException  ],
      [ 'message',  123,    new ExampleError      ],
      [ 'message',  -123,   new ErrorException    ],
      [ '',         0,      new Exception         ],
      [ '',         0,      null                  ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_exception( $t[0], $t[1], $t[2] ), Exception::class ) );

    }

    return 0;

  },

  'new_php_error_exception' => function() {

    $tests = [
      // message    code    severity  filename  lineno    previous
      [ 'message',  123,    E_ERROR,  __FILE__, __LINE__, new ExampleException  ],
      [ 'message',  123,    E_ERROR,  __FILE__, __LINE__, new ExampleError      ],
      [ '',         0,      E_ALL,    null,     null,     null                  ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_error_exception( $t[0], $t[1], $t[2], $t[3], $t[4], $t[5] ), Exception::class ) );

    }

    return 0;

  },

  'new_php_reflection_class' => function() {

    $tests = [
      // objectOrClass
      [ 'stdClass'      ],
      [ stdClass::class ],
      [ new stdClass    ],
      [ 'DateTime'      ],
      [ DateTime::class ],
      [ new DateTime    ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_reflection_class( $t[0] ), ReflectionClass::class ) );

    }

    return 0;

  },

  'new_php_date_time_immutable' => function() {

    $tests = [
      // datetime               timezone
      [ 'now',                  new DateTimeZone( 'UTC' ) ],
      [ '2024-02-08 12:00:00',  new DateTimeZone( 'UTC' ) ],
      [ 'now',                  null                      ],
      [ '',                     null                      ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_date_time_immutable( $t[0], $t[1] ), DateTimeImmutable::class ) );

    }

    return 0;

  },

  'new_php_date_time' => function() {

    $tests = [
      // datetime               timezone
      [ 'now',                  new DateTimeZone( 'UTC' )               ],
      [ 'now',                  new DateTimeZone( 'Australia/Sydney' )  ],
      [ '2024-02-08 12:00:00',  new DateTimeZone( 'UTC' )               ],
      [ '2024-02-08 12:00:00',  new DateTimeZone( 'Australia/Sydney' )  ],
      [ 'now',                  null                                    ],
      [ '',                     null                                    ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_date_time( $t[0], $t[1] ), DateTime::class ) );

    }

    $tests = [
      // datetime     timezone  expect
      [ null,         null,     'DateTime::__construct(): Passing null to parameter #1 ($datetime) of type string is deprecated' ],
      [ 'invalid',    null,     'Failed to parse time string (invalid) at position 0 (i): The timezone could not be found in the database' ],
    ];

    foreach ( $tests as $t ) {

      try {
          
        new_php_date_time( $t[0], $t[1] );

        assert( false );

      }
      catch ( Exception $ex ) {

        $expect = $t[ 2 ];

        var_dump( $ex->getMessage() );

        assert( $ex->getMessage() === $expect );

        continue;

      }

      assert( false );

    }

    return 0;

  },

  'new_php_date_time_zone' => function() {

    $tests = [
      // timezone
      [ 'UTC'               ],
      [ 'Australia/Sydney'  ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_date_time_zone( $t[0] ), DateTimeZone::class ) );

    }

    $tests = [
      // timezone
      [ ''          ],
      [ 'not null'  ],
    ];

    foreach ( $tests as $t ) {

      try {
          
        new_php_date_time_zone( $t[0] );

        assert( false );

      }
      catch ( Exception $ex ) {

        $string = $t[ 0 ];

        assert( $ex->getMessage() === "DateTimeZone::__construct(): Unknown or bad timezone ($string)" );

        continue;

      }

      assert( false );

    }

    return 0;

  },

  'new_php_recursive_directory_iterator' => function() {

    $tests = [
      // path                 flags
      [ __DIR__,              FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS ],
      [ __DIR__,              FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS ],
      [ __DIR__,              FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS ],
      [ __DIR__,              FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS | FilesystemIterator::UNIX_PATHS ],
      [ __DIR__ . '/../../',  FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_recursive_directory_iterator( $t[0], $t[1] ), RecursiveDirectoryIterator::class ) );

    }

    return 0;

  },

  'new_php_recursive_iterator_iterator' => function() {

    $tests = [
      // path                 mode                                    flags
      [ __DIR__,              RecursiveIteratorIterator::LEAVES_ONLY, 0 ],
      [ __DIR__ . '/../../',  RecursiveIteratorIterator::LEAVES_ONLY, 0 ],
    ];

    foreach ( $tests as $t ) {

      $iterator = new_php_recursive_directory_iterator( $t[0] );

      assert( is_a( new_php_recursive_iterator_iterator( $iterator, $t[1], $t[2] ), RecursiveIteratorIterator::class ) );

    }

    return 0;

  },

  'new_php_spl_object_storage' => function() {

    assert( is_a( new_php_spl_object_storage(), SplObjectStorage::class ) );

    return 0;

  },

  'new_php_pdo' => function() {

    $tests = [
      // dsn        user      password  options
      [ 'sqlite::memory:', null,     null,     null ],
      [ 'sqlite::memory:', null,     null,     [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ] ],
    ];

    foreach ( $tests as $t ) {

      assert( is_a( new_php_pdo( $t[0], $t[1], $t[2], $t[3] ), PDO::class ) );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - service locators...
  //

  'mud_factory' => function() {

    class ExampleFactory extends MudFactory {}

    $factory = new ExampleFactory();

    assert( mud_factory( $factory ) === $factory );

    return 0;

  },

  'mud_locator' => function() {

    class ExampleLocator extends MudLocator {}

    $locator = new ExampleLocator();

    assert( mud_locator( $locator ) === $locator );

    return 0;

  },

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudGadget...
  //

  'oid' => function() {

    class MudOidExample extends MudGadget {}

    $example = new MudOidExample();

    $oid = $example->get_oid();

    var_dump( $oid );

    assert( $oid > 0 );

    return 0;

  },

  'object-constructor-missing' => function() {

    class MudNoConstrctor extends MudGadget {

      public function __construct() {

        // 2024-02-07 jj5 - NOTE: we don't call parent constructor here, we should catch this in the test.

      }
    }

    $example = new MudNoConstrctor();

    assert( $example->get_oid() === false );

    assert( mud_is_debug() );

    try {

      $example = null;

    }
    catch ( Throwable $ex ) {

      var_dump( $ex->getMessage() );

      assert( $ex->getMessage() === "constructor not called for object 'MudNoConstrctor'." );

      return 0;

    }

    return 1;

  },

  'new-oid' => function() {

    $int = MudGadget::new_oid();

    assert( MudGadget::new_oid() === $int + 1 );
    assert( MudGadget::new_oid() === $int + 2 );
    assert( MudGadget::new_oid() === $int + 3 );

    return 0;

  },

  'trace-indent' => function() {

    class MudIndentExample extends MudGadget {

      public function test_indent() {

        $this->trace( 1 );
        $this->trace( 2 );
        $this->trace( 3 );

        $this->trace_init( 'do something:' );

          $this->trace( 1 );
          $this->trace( 2 );
          $this->trace( 3 );

          $this->trace_init( 'do something more:' );

            $this->trace( 1, [ 'a', 'b', 'c' ] );
            $this->trace( 2 );
            $this->trace( 3 );

          $this->trace_done( 'do something more is complete.' );

        $this->trace_done( 'do something is complete.' );

      }
    }

    $example = new MudIndentExample();

    $example->test_indent();

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudModule...
  //

  'module-constructor-missing' => function() {

    class MudNoConstrctorModule extends MudModule {

      public function __construct() {

        // 2024-02-07 jj5 - NOTE: we don't call parent constructor here, we should catch this in the test.

      }
    }

    $example = new MudNoConstrctorModule();

    assert( $example->get_oid() === false );

    try {

      $example = null;

    }
    catch ( Throwable $ex ) {

      var_dump( $ex->getMessage() );

      assert( $ex->getMessage() === "constructor not called for object 'MudNoConstrctorModule'." );

      return 0;

    }

    return 1;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudService...
  //

  'service-constructor-missing' => function() {

    class MudNoConstrctorService extends MudService {

      public function __construct() {

        // 2024-02-07 jj5 - NOTE: we don't call parent constructor here, we should catch this in the test.

      }
    }

    $example = new MudNoConstrctorService();

    assert( $example->get_oid() === false );

    try {

      $example = null;

    }
    catch ( Throwable $ex ) {

      assert( $ex->getMessage() === "constructor not called for object 'MudNoConstrctorService'." );

      return 0;

    }

    return 1;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudFactory...
  //

  'mud-factory' => function() {

    $module_list = [ MudModuleStandard::class ];

    foreach ( $module_list as $class_name ) {

      $module_name = mud_locator()->get_module_name( $class_name );

      $module = mud_factory()->create_module( $module_name );

      assert( $module instanceof MudModule );

    }

    $sevice_list = [ MudFactory::class, MudLocator::class ];

    foreach ( $sevice_list as $class_name ) {

      $service_name = mud_locator()->get_service_name( $class_name );

      $module = mud_factory()->create_service( $service_name );

      assert( $module instanceof MudService );

    }

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudLocator...
  //

  'mud-locator'=> function() {

    assert( mud_factory() === mud_locator()->get_factory() );
    assert( mud_locator() === mud_locator()->get_locator() );

    return 0;

  },


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - MudMixin...
  //

  'json-serialize' => function() {

    class MudJsonExample extends MudGadget {}

    $example = new MudJsonExample();

    assert( json_encode( $example ) === '{"class":"MudJsonExample"}' );

    return 0;

  },

  'is-null-is-false' => function() {

    class MudNullExample extends MudGadget {}

    $example = new MudNullExample();

    assert( ! $example->is_null() );

    return 0;

  },

  'get_constant_or_default' => function() {

    class MudDefaultExample extends MudGadget {

      public function test_default() {

        $tests = [ 'DEBUG', 'DEV', 'TEST' ];

        foreach ( $tests as $constant ) {

          assert( $this->get_constant_or_default( $constant ) === constant( $constant ) );

        }

        $tests = [
          null,
          false,
          true,
          0,
          1,
          2,
          3.21,
          -0,
          -0.0,
          '',
          'default',
          new stdClass,
          new DateTime,
        ];

        foreach ( $tests as $default ) {

          assert( $this->get_constant_or_default( 'NON_EXISTANT', $default ) === $default );

        }
      }
    }

    $obj = new MudDefaultExample;

    $obj->test_default();

    return 0;

  },

  'microtime' => function() {

    class MudTimingExample extends MudGadget {

      public function test_timing() {

        $a = $this->get_microtime_now();

        usleep( 1337 );

        $b = $this->get_microtime_now();

        assert( $a < $b );

      }
    }

    $example = new MudTimingExample();

    $example->test_timing();

    return 0;

  },


  'log' => function() {

    class MudLogExample extends MudGadget {

      public function log_example() {

        $this->log_warning( 'warning' );
        $this->log_debug( 'debug' );

      }
    }

    $example = new MudLogExample();

    // 2024-02-07 jj5 - the log will be written to STDERR so we can't see it in the output buffer...

    ob_start();

    $example->log_example();

    $output = ob_get_clean();

    assert( trim( $output ) === "" );

    return 0;

  },

  'factory' => function() {

    assert( is_a( mud_factory(), MudFactory::class ) );

    return 0;

  },

  'locator' => function() {

    assert( is_a( mud_locator(), MudLocator::class ) );

    return 0;

  },

  'posix-timing' => function() {

    // 2024-02-07 jj5 - this test was a comparison of the performance of two different implementations of the same
    // function, it's not relevant to the current implementation of the library. The test showed that caching the result
    // of the function in a static variable increased performance.

    /*
    $count = 1_000_000;

    $start = microtime( true );

    for ( $i = 0; $i < $count; $i++ ) {

      assert( MudGadget::is_posix_a() );

    }

    $duration_a = microtime( true ) - $start;

    $start = microtime( true );

    for ( $i = 0; $i < $count; $i++ ) {

      assert( MudGadget::is_posix_b() );

    }

    $duration_b = microtime( true ) - $start;

    var_dump([
      'a' => $duration_a,
      'b' => $duration_b,
    ]);
    */

    return 0;

  },

]);
