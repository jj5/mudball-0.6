<?php

trait MudMixinFilesystemPublic {

  use MudMixinFilesystemCommon;

  public function fopen( string $path, string $mode ) {

    return self::attempt_function( __FUNCTION__, function() use ( $path, $mode ) {

      return fopen( $path, $mode );

    } );

  }

  public function flock( $handle, int $operation ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $operation ) {

      return flock( $handle, $operation );

    } );

  }

  public function stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $length, $offset ) {

      return stream_get_contents( $handle, $length, $offset );

    } );

  }

  public function ftruncate( $handle, int $size ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $size ) {

      return ftruncate( $handle, $size );

    } );

  }

  public function rewind( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return rewind( $handle );

    } );

  }

  public function fwrite( $handle, string $data, ?int $length = null ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $data, $length ) {

      return fwrite( $handle, $data, $length );

    } );

  }

  public function fflush( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fflush( $handle );

    } );

  }

  public function fclose( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fclose( $handle );

    } );

  }
}
