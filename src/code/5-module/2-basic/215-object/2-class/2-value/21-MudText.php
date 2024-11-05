<?php

// 2024-06-29 jj5 - NOTE: 'text' is a 'string' which precomputes its hash function and stores it, whereas 'string' will
// compute its hash function on demand.

class MudText extends MudString implements IMudText {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private string $hash;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( string $value, int $max_length = PHP_INT_MAX, int $min_length = 0 ) {

    parent::__construct( $value, $max_length, $min_length );

    $this->hash = self::hash( $value );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public functions...
  //

  public function get_hash() : string { return $this->hash; }

}
