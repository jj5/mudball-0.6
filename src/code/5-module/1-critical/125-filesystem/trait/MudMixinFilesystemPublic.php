<?php

trait MudMixinFilesystemPublic {

  use MudMixinFilesystemCommon;

  /**
  * @return resource Returns a file handle resource on success or throws an exception on failure.
  */
  public function fopen( string $path, string $mode ) : mixed {

    return self::attempt_function( __FUNCTION__, function() use ( $path, $mode ) {

      return fopen( $path, $mode );

    } );

  }

  public function flock( $handle, int $operation ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle, $operation ) {

      return flock( $handle, $operation );

    } );

  }

  public function stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) : string {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $length, $offset ) {

      return stream_get_contents( $handle, $length, $offset );

    } );

  }

  public function ftruncate( $handle, int $size ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle, $size ) {

      return ftruncate( $handle, $size );

    } );

  }

  public function rewind( $handle ) : void{

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return rewind( $handle );

    } );

  }

  public function fwrite( $handle, string $data, ?int $length = null ) : int {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $data, $length ) {

      return fwrite( $handle, $data, $length );

    } );

  }

  public function fflush( $handle ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fflush( $handle );

    } );

  }

  public function fclose( $handle ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fclose( $handle );

    } );

  }
}
