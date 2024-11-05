<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - class definition...
//

class MudModuleRetry extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleRetry|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public functions...
  //

  public function retry(
    callable $fn,
    array $args = [],
    int $try_count = MUD_DEFAULT_TRY_COUNT,
    int $try_delay = MUD_DEFAULT_TRY_DELAY
  ) {

    $errors = error_reporting( 0 );

    try {

      for ( $try = 1; $try <= $try_count; $try++ ) {

        $result = call_user_func_array( $fn, $args );

        if ( $result !== false ) { return $result; }

        usleep( $try_delay );

      }
    }
    finally {

      error_reporting( $errors );

    }

    return false;

  }

  public function ensure(
    callable $fn,
    array $args = [],
    int $try_count = MUD_DEFAULT_TRY_COUNT,
    int $try_delay = MUD_DEFAULT_TRY_DELAY
  ) {

    $result = $this->retry( $fn, $args, $try_count, $try_delay );

    if ( $result === false ) {

      $data = [
        'function' => is_string( $fn ) ? $fn : ( is_array( $fn ) ? $fn[ 1 ] ?? null : null ),
        'arg_list' => $args,
        'try_count' => $try_count,
        'try_delay' => $try_delay,
      ];

      mud_fail( MUD_ERR_RETRY_LIMIT_EXCEEDED, $data );

    }

    return $result;

  }
}
