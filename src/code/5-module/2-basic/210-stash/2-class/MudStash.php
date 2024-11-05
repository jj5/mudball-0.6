<?php

define( 'MUD_STASH_RETRY', 10 );
define( 'MUD_STASH_USLEEP_MIN', 10 );
define( 'MUD_STASH_USLEEP_MAX', 100 );

class MudStash extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - private fields...
  //

  private string $dir_path;

  private string $file_path;

  private mixed $data;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - constructor...
  //

  public function __construct( string $name ) {

    parent::__construct();

    $this->dir_path = '/var/state/' . APP_CODE . '/stash/' . date( 'Y/m/d' );

    $this->file_path = $this->dir_path . '/' . $name . '.json';

    $this->data = null;

    $this->read_data();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public instance methods...
  //

  public function get_data() : mixed {

    if ( ! $this->data ) {

      $this->read_data();

    }

    return $this->data;
    
  }

  public function set_data( mixed $data ) : bool {

    if ( $this->do_set_data( $data ) ) {

      $this->data = $data;

      return true;

    }

    $this->error_log( 'failed to set data for: ' . $this->file_path );

    return false;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - protected instance methods...
  //

  protected function read_data() : void {

    $this->do_read_data();

  }
  
  protected function do_read_data() : bool {

    for ( $try = 1; $try < MUD_STASH_RETRY; $try++ ) {

      if ( ! file_exists( $this->file_path ) ) {

        $this->error_log( 'file not found: ' . $this->file_path );

        continue;

      }

      $json = file_get_contents( $this->file_path );

      if ( $json === false ) {

        $this->error_log( 'failed to get contents: ' . $this->file_path );

        continue;

      }

      $data = json_decode( $json, true );

      if ( json_last_error() ) {

        $this->error_log( 'failed to decode json for: ' . $this->file_path . ': ' . json_last_error_msg() );

        continue;

      }

      $this->data = $data;

      return true;

    }

    $this->error_log( 'retries exhausted reading stash: ' . $this->file_path );

    return false;

  }

  protected function do_set_data( mixed $data ) : bool {

    static $flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    $json = json_encode( $data, $flags );

    if ( is_string( $json ) && ! json_last_error() ) {

      for ( $try = 1; $try < MUD_STASH_RETRY; $try++ ) {

        if ( is_dir( $this->dir_path ) ) { break; }

        if ( ! mkdir( $this->dir_path, 0755, true ) ) {

          $this->error_log( 'failed to create directory: ' . $this->dir_path );

        }
      }

      for ( $try = 1; $try < MUD_STASH_RETRY; $try++ ) {

        if ( file_put_contents( $this->file_path, $json ) ) {

          return true;

        }

        $this->error_log( 'failed to put contents: ' . $this->file_path );

      }
    }

    $this->error_log( 'failed to encode json for: ' . $this->file_path );

    return false;

  }

  protected function error_log( $message ) {

    error_log( $message );

    usleep( random_int( MUD_STASH_USLEEP_MIN, MUD_STASH_USLEEP_MAX ) );

  }
}
