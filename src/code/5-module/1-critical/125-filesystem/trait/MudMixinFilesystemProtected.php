<?php

trait MudMixinFilesystemProtected {

  use MudMixinFilesystemCommon;

  /**
  * @return resource Returns a file handle resource on success or throws an exception on failure.
  */
  protected static function fopen( string $path, string $mode ) : mixed {

    return self::attempt_function( __FUNCTION__, function() use ( $path, $mode ) {

      return fopen( $path, $mode );

    } );

  }

  protected static function flock( $handle, int $operation ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle, $operation ) {

      return flock( $handle, $operation );

    } );

  }

  protected static function stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) : string {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $length, $offset ) {

      return stream_get_contents( $handle, $length, $offset );

    } );

  }

  protected static function ftruncate( $handle, int $size ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle, $size ) {

      return ftruncate( $handle, $size );

    } );

  }

  protected static function rewind( $handle ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return rewind( $handle );

    } );

  }

  protected static function fwrite( $handle, string $data, ?int $length = null ) : int {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $data, $length ) {

      return fwrite( $handle, $data, $length );

    } );

  }

  protected static function fflush( $handle ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fflush( $handle );

    } );

  }

  protected static function fclose( $handle ) : void {

    self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fclose( $handle );

    } );

  }
}
