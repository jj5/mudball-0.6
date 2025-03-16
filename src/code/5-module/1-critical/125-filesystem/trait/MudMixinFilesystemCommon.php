<?php

trait MudMixinFilesystemCommon {

  protected static function attempt_function( $function, $callback ) {

    $limit = mud_get_const( 'FILESYSTEM_ATTEMPT_LIMIT' );

    assert( is_int( $limit ) && $limit > 0 );

    for ( $attempt = 1; $attempt < $limit; $attempt++ ) {

      $result = $callback();

      if ( $result !== false ) { return $result; }

      $delay = mud_get_const( 'FILESYSTEM_ATTEMPT_DELAY' );

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
