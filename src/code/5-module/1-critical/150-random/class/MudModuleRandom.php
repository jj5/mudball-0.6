<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleRandom extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleRandom|null $previous = null) {

    parent::__construct( $previous );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  public function new_token( int $length = MUD_TOKEN_LENGTH ) : string {

    assert( $length > 0 );

    // 2019-09-21 jj5 - SEE: StackOverflow:
    // https://stackoverflow.com/a/13733588

    static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $result = str_repeat( 'A', $length );

    $max = strlen( $alphabet ) - 1;

    for ( $i = 0; $i < $length; $i++ ) {

      $result[ $i ] = $alphabet[ random_int( 0, $max ) ];

    }

    return $result;


    // 2022-01-31 jj5 - the above is very slightly faster than this way:

    $result = '';

    $max = strlen( $alphabet ) - 1;

    for ( $i = 0; $i < $length; $i++ ) {

      $result .= $alphabet[ random_int( 0, $max ) ];

    }

    return $result;

  }

  public function new_seed() : int {

    return random_int( 1337, MUD_MAX_INT32 );

  }
}
