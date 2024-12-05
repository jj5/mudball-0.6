<?php

require_once __DIR__ . '/3-flags.php';

global $config;

if ( file_exists( MUDBALL_CONFIG_PATH ) ) {

  require_once MUDBALL_CONFIG_PATH;

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-19 jj5 - we sneak this module loader function in here... we use it to load our
// modules...
//

function mud_load_modules( $dir, $scope = 'mud' ) {

  $realpath = realpath( $dir );

  if ( ! is_dir( $realpath ) ) {

    mud_fail( 'invalid directory.', [ 'dir' => $dir ] );

  }

  foreach ( scandir( $realpath, SCANDIR_SORT_ASCENDING ) as $module_dir ) {

    $parts = explode( '-', $module_dir, 2 );

    $code = $parts[ 0 ] ?? '';
    $name = $parts[ 1 ] ?? '';

    $name = str_replace( '-', '_', $name );

    $path = "{$realpath}/{$code}-{$name}/{$scope}_{$name}.php";

    if ( is_file( $path ) ) { require_once $path; }

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
