<?php

trait MudMixinFilesystemProtected {

  use MudMixinFilesystemCommon;

  protected static function fopen( string $path, string $mode ) {

    //mud_log_trace( __FUNCTION__, [ 'path' => $path, 'mode' => $mode ] );

    return self::attempt_function( __FUNCTION__, function() use ( $path, $mode ) {

      return fopen( $path, $mode );

    } );

  }

  protected static function flock( $handle, int $operation ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $operation ) {

      return flock( $handle, $operation );

    } );

  }

  protected static function stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $length, $offset ) {

      return stream_get_contents( $handle, $length, $offset );

    } );

  }

  protected static function ftruncate( $handle, int $size ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $size ) {

      return ftruncate( $handle, $size );

    } );

  }

  protected static function rewind( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return rewind( $handle );

    } );

  }

  protected static function fwrite( $handle, string $data, ?int $length = null ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle, $data, $length ) {

      return fwrite( $handle, $data, $length );

    } );

  }

  protected static function fflush( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fflush( $handle );

    } );

  }

  protected static function fclose( $handle ) {

    return self::attempt_function( __FUNCTION__, function() use ( $handle ) {

      return fclose( $handle );

    } );

  }
}
