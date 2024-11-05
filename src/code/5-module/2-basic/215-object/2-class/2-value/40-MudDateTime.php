<?php


define( 'MUD_DATETIME_FORMAT_FOR_WEB', 'format-for-web' );
define( 'MUD_DATETIME_FORMAT_FOR_SITEMAP', 'format-for-sitemap' );

define( 'MUD_DATETIME_FORMAT_WEB', 'r' );
define( 'MUD_DATETIME_FORMAT_SITEMAP', 'Y-m-d\TH:i:sP' );


abstract class MudDateTime extends MudAtom implements IMudDateTime {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private DateTimeImmutable $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( DateTimeInterface|int $value = 0 ) {

    parent::__construct();

    if ( is_int( $value ) ) {

      $value = new DateTimeImmutable( '@' . $value );

    }

    $this->value = $value instanceof DateTimeImmutable ?
      $value :
      new DateTimeImmutable( $value->format( 'Y-m-d H:i:s' ), $value->getTimezone() );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - public static methods...
  //

  public static function min_value() {

    static $min_value = new DateTimeImmutable( '0001-01-01 00:00:00' );

    return $min_value;

  }

  public static function max_value() {

    static $max_value = new DateTimeImmutable( '9999-12-31 23:59:59' );

    return $max_value;

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

  public function is_valid( mixed $options = null ) : bool {

    if ( $this->get_value_min_datetime() && $this->value < $this->get_value_min_datetime() ) { return false; }

    if ( $this->get_value_max_datetime() && $this->value > $this->get_value_max_datetime() ) { return false; }

    return true;

  }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return boolval( $this->get_timestamp() ); }

  public function to_int() : int { return intval( $this->get_timestamp() ); }

  public function to_float() : float { return floatval( $this->get_timestamp() ); }

  public function to_string() : string { return $this->format( 'Y-m-d H:i:s' ); }

  public function get_value() : mixed { return $this->get_datetime(); }

  public function get_db_value() : int|float|string|null { return $this->format( 'Y-m-d H:i:s' ); }

  public function format( mixed $spec = null ) : string {

    // 2024-06-30 jj5 - NOTE: it would probably be easy to make this mistake so check for it...

    assert( $spec !== MUD_DATETIME_FORMAT_WEB );
    assert( $spec !== MUD_DATETIME_FORMAT_SITEMAP );

    switch ( $spec ) {

      case MUD_DATETIME_FORMAT_FOR_WEB :

        return $this->format_for_web();

      case MUD_DATETIME_FORMAT_FOR_SITEMAP :

        return $this->format_for_sitemap();

      default :

        return $this->get_datetime()->format( $spec ?? 'Y-m-d H:i:s' );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTime interface...
  //

  public function new_date_time() : DateTime {
    
    return new DateTime( $this->get_value()->format( 'r' ), $this->get_value()->getTimezone() );

  }

  public function get_datetime() : DateTimeInterface { return $this->value; }

  public function get_value_min_datetime() : DateTimeInterface {

    static $min_value = new DateTimeImmutable( '0001-01-01 00:00:00' );

    return $min_value;

  }

  public function get_value_max_datetime() : DateTimeInterface {

    static $max_value = new DateTimeImmutable( '9999-12-31 23:59:59' );

    return $max_value;

  }

  public function get_timestamp() : int { return $this->value->getTimestamp(); }

  public function get_for_utc() : DateTimeInterface {

    static $utc = new DateTimeZone( 'UTC' );

    $datetime = $this->get_value();

    if ( $datetime->getTimezone()->getName() !== 'UTC' ) {

      $datetime = $this->new_date_time();

      $datetime->setTimezone( $utc );

    }

    return $datetime;

  }

  public function format_for_web() : string {

    return $this->get_for_utc()->format( MUD_DATETIME_FORMAT_WEB );

  }

  public function format_for_sitemap() : string {

    return $this->get_for_utc()->format( MUD_DATETIME_FORMAT_SITEMAP );

  }

}
