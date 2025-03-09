<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/4-config.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - we use these functions to load our modules, other code can use them to load their modules too.
//

function mud_load_modules( $dir, $scope = 'mud' ) {

  $realpath = realpath( $dir );

  if ( ! is_dir( $realpath ) ) {

    mud_fail( 'invalid directory.', [ 'dir' => $dir ] );

  }

  foreach ( scandir( $realpath, SCANDIR_SORT_ASCENDING ) as $module_dir ) {

    if ( $module_dir === '.' || $module_dir === '..' ) { continue; }

    //error_log( "processing module directory: $module_dir" );

    $parts = explode( '-', $module_dir, 2 );

    $code = $parts[ 0 ] ?? '';
    $name = $parts[ 1 ] ?? '';

    $name = str_replace( '-', '_', $name );

    $path = "{$realpath}/{$code}-{$name}/{$scope}_{$name}.php";

    if ( is_file( $path ) ) {

      //error_log( "including file: $path" );

      require_once $path;

    }
    else {

      //error_log( "missing file: $path" );

    }
  }
}

function mud_load_files( $dir ) {

  $dir = realpath( $dir );

  assert( is_dir( $dir ) );

  foreach ( scandir( $dir, SCANDIR_SORT_ASCENDING ) as $file ) {

    if ( is_dir( $file ) ) { continue; }

    $path = "{$dir}/{$file}";

    assert( is_file( $path ) );

    require_once $path;

  }
}

function mud_load_deep( $dir ) {

  $dir = realpath( $dir );

  assert( is_dir( $dir ) );

  foreach ( scandir( $dir, SCANDIR_SORT_ASCENDING ) as $file ) {

    if ( $file === '.' || $file === '..' ) { continue; }

    $path = "{$dir}/{$file}";

    if ( is_dir( $path ) ) {

      mud_load_deep( $path );

    }
    else {

      assert( is_file( $path ) );

      require_once $path;

    }
  }
}

function mud_load_deep_breadth_first( $dir ) {

  $dir = realpath( $dir );

  assert( is_dir( $dir ) );

  $queue = [ $dir ];

  while ( $queue ) {

    $dir = array_shift( $queue );

    foreach ( scandir( $dir, SCANDIR_SORT_ASCENDING ) as $file ) {

      if ( $file === '.' || $file === '..' ) { continue; }

      $path = "{$dir}/{$file}";

      if ( is_dir( $path ) ) {

        $queue[] = $path;

      }
      else {

        assert( is_file( $path ) );

        try {

          require_once $path;

        }
        catch ( Throwable $ex ) {

          error_log( $ex->getMessage() );

          error_log( "Error loading file: $path" );

          throw $ex;

        }
      }
    }
  }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - load main modules...
//

mud_load_modules( __DIR__ . '/../5-module/1-critical' );

mud_load_modules( __DIR__ . '/../5-module/2-basic' );

mud_load_modules( __DIR__ . '/../5-module/3-data' );

mud_load_modules( __DIR__ . '/../5-module/4-web' );

mud_load_modules( __DIR__ . '/../5-module/5-api' );

mud_load_modules( __DIR__ . '/../5-module/6-app' );
