<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - class definition...
//

class MudModuleTemp extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - protected fields...
  //

  private bool $initialized = false;

  private array|null $file_list = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - public methods...
  //

  public function get_temp_file( bool $manage = true ) : string {

    static $default_prefix = null;

    if ( $default_prefix === null ) {

      if ( defined( 'APP_SLUG' ) ) {

        $default_prefix = APP_SLUG . '-';

      }
      elseif ( defined( 'MUDBALL_SLUG' ) ) {

        $default_prefix = MUDBALL_SLUG . '-';

      }
      else {

        $default_prefix = 'mudball-';

      }
    }

    $directory = mud_get_config( [ 'mud', 'temp', 'directory' ], '/dev/shm'      );
    $prefix    = mud_get_config( [ 'mud', 'temp', 'prefix'    ], $default_prefix );

    $result = tempnam( $directory, $prefix );

    if ( $manage ) {

      $this->init();

      $this->file_list[] = $result;

    }

    return $result;

  }

  public function shutdown() {

    try {

      if ( ! $this->initialized ) { return; }

      $file_list = $this->file_list;

      $this->initialized = false;
      $this->file_list = [];

      foreach ( $file_list as $path ) {

        mud_retry( function() use ( $path ) {

          @unlink( $path );

          return ! file_exists( $path );

        });

      }
    }
    catch ( Throwable $ex ) {

      mud_log_exception_shutdown( $ex );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - protected methods...
  //

  protected function init() {

    if ( $this->initialized ) { return; }

    $this->initialized = true;
    $this->file_list = [];

    register_shutdown_function( [ $this, 'shutdown' ] );

  }
}
