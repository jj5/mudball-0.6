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

  private DateTimeInterface|null $max_value;

  private DateTimeInterface|null $min_value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct(
    DateTimeInterface $value,
    DateTimeInterface|null $max_value = null,
    DateTimeInterface|null $min_value = null
  ) {

    $this->value = $value instanceof DateTimeImmutable ?
      $value :
      new DateTimeImmutable( $value->format( 'Y-m-d H:i:s' ), $value->getTimezone() );

    $this->max_value = $max_value;
    $this->min_value = $min_value;

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

  public function new_date_time() : DateTime { return new DateTime( $this->get_value(), $this->get_value()->getTimezone() ); }

  public function is_valid( mixed $options = null ) : bool {

    if ( $this->min_value && $this->value < $this->min_value ) { return false; }

    if ( $this->max_value && $this->value > $this->max_value ) { return false; }

    return true;

  }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  public function is_integer( int $n ) : bool { return $this->to_int() === $n; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return boolval( $this->get_timestamp() ); }

  public function to_int() : int { return intval( $this->get_timestamp() ); }

  public function to_float() : float { return floatval( $this->get_timestamp() ); }

  public function to_string() : string { return $this->format( 'Y-m-d H:i:s' ); }

  public function get_value() : mixed { return $this->value; }

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

        return $this->value->format( $spec );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTime interface...
  //

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
