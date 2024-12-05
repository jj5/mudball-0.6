<?php

class MudTime extends MudDateTime {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - constructor...
  //

  public function __construct( DateTimeInterface $value ) {

    static $max_value = new DateTimeImmutable( '23:59:59' );
    static $min_value = new DateTimeImmutable( '00:00:00' );

    parent::__construct( $value, $max_value, $min_value );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTime interface...
  //

  public function is_date() : bool { return false; }

  public function is_time() : bool { return true; }

  public function is_date_time() : bool { return false; }

  public function is_universal() : bool { return false; }

  public function is_local() : bool { return true; }

  public function is_zoned() : bool { return false; }

  public function get_db_value() : int|float|string|null { return $this->format( 'H:i:s' ); }

}
