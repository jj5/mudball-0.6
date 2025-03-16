<?php

trait MudMixinFilesystemCommon {

  protected static function get_attempt_limit() : int {

    static $limit = null;

    if ( $limit === null ) {

      $limit = mud_get_const( 'FILESYSTEM_ATTEMPT_LIMIT' );

      assert( is_int( $limit ) && $limit > 0 );

    }

    return $limit;

  }

  protected static function get_attempt_delay() : int {

    static $delay = null;

    if ( $delay === null ) {

      $delay = mud_get_const( 'FILESYSTEM_ATTEMPT_DELAY' );

      assert( is_int( $delay ) && $delay >= 0 );

    }

    return $delay;

  }

  protected static function attempt_function( $function, $callback ) {

    $limit = self::get_attempt_limit();

    for ( $attempt = 1; $attempt < $limit; $attempt++ ) {

      $result = $callback();

      if ( $result !== false ) { return $result; }

      $delay = self::get_attempt_delay();

      usleep( $delay );

      mud_log_4_warning( "failed to '$function', attempt $attempt." );

    }

    mud_fail(
      MUD_ERR_FILESYSTEM_ATTEMPT_FAILED,
      [
        'function' => $function,
        'attempt' => $attempt,
        'result' => $result,
      ]
    );

  }
}
