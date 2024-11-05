<?php

class MudDateTimeZone extends MudAtom implements IMudDateTimeZone {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private DateTimeZone $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( DateTimeZone $value ) {

    parent::__construct();

    $this->value = $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - Stringable interface...
  //

  public function __toString() : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return false; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudValue interface...
  //

  public function is_valid( mixed $options = null ) : bool { return true; }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  //public function is_integer( int $n ) : bool { return $this->to_int() === $n; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return boolval( $this->get_offset() ); }

  public function to_int() : int { return intval( $this->get_offset() ); }

  public function to_float() : float { return floatval( $this->get_offset() ); }

  public function to_string() : string { return $this->value->getName(); }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : int|float|string|null { return $this->to_string(); }

  public function format( mixed $spec = null ) : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTimeZone interface...
  //

  public function get_offset( DateTimeInterface|null $datetime = null ) : int {

    if ( ! $datetime ) { $datetime = self::get_utc_now(); }

    return $this->value->getOffset( $datetime );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateInterval interface...
  //



  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public static methods
  //

  public static function get_utc() : DateTimeZone {

    static $result = null;

    if ( $result === null ) { $result = new DateTimeZone( 'UTC' ); }

    return $result;

  }

  public static function get_utc_now() : DateTimeImmutable {

    return new DateTimeImmutable( 'now', self::get_utc() );

  }
}
