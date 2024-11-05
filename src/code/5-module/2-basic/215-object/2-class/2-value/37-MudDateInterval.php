<?php


define( 'MUD_INTERVAL_FORMAT_AUTO', 'format-auto' );


class MudDateInterval extends MudAtom implements IMudDateInterval {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private DateInterval $value;

  private int|null $microseconds = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( DateInterval $value ) {

    assert( ! $value->from_string );

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

  public function is_integer( int $n ) : bool { return $this->to_int() === $n; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return boolval( $this->to_int() ); }

  public function to_int() : int { return $this->get_microseconds(); }

  public function to_float() : float { return floatval( $this->to_int() ); }

  public function to_string() : string {

    return isset( $this->value->date_string ) ? strval( $this->value->date_string ) : strval( $this->get_microseconds() );
    
  }

  public function get_value() : mixed { return $this->value; }

  public function get_db_value() : string { return $this->to_string(); }

  public function format( mixed $spec = null ) : string {
    
    if ( $spec === MUD_INTERVAL_FORMAT_AUTO ) { return $this->format_auto(); }

    return $this->value->format( strval( $spec ) );
    
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateInterval interface...
  //

  public function get_microseconds(): int {

    if ( $this->microseconds === null ) {

      $R = $this->format( '%R' );

      assert( $R === '' || $R === '-' );

      $Y = $this->get_part( 'Y', 2 );
      $M = $this->get_part( 'M', 2 );
      $D = $this->get_part( 'D', 2 );
      $H = $this->get_part( 'H', 2 );
      $I = $this->get_part( 'I', 2 );
      $S = $this->get_part( 'S', 2 );
      $F = $this->get_part( 'F', 6 );

      $this->microseconds = intval( "$R$Y$M$D$H$I$S$F" );

    }

    return $this->microseconds;

  }

  public function format_auto() : string {

    $interval = $this->get_value();

    // 2024-06-30 jj5 - TODO: I'm not sure when 'f' is set, so I'm not sure if this is correct...

    if ( $interval->f ) {

      if ( $interval->y ) { return $interval->format( '%R%Y:%M:%D:%H:%I:%S:%F' ); }

      if ( $interval->m ) { return $interval->format( '%R:%M:%D:%H:%I:%S:%F' ); }

      if ( $interval->d ) { return $interval->format( '%R%D:%H:%I:%S:%F' ); }

      if ( $interval->h ) { return $interval->format( '%R%H:%I:%S:%F' ); }

      if ( $interval->i ) { return $interval->format( '%R%I:%S:%F' ); }

      if ( $interval->s ) { return $interval->format( '%R%S:%F' ); }

      $interval->format( '%R%F' );

    }

    if ( $interval->y ) { return $interval->format( '%R%Y:%M:%D:%H:%I:%S' ); }

    if ( $interval->m ) { return $interval->format( '%R:%M:%D:%H:%I:%S' ); }

    if ( $interval->d ) { return $interval->format( '%R%D:%H:%I:%S' ); }

    if ( $interval->h ) { return $interval->format( '%R%H:%I:%S' ); }

    if ( $interval->i ) { return $interval->format( '%R%I:%S' ); }

    return $interval->format( '%R%S' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - protected instance methods...
  //

  protected function get_part( string $format_character, int $expected_length ) {

    $result = $this->value->format( '%' . $format_character );

    if ( strlen( $result ) === $expected_length ) { return $result; }

    // 2024-06-30 jj5 - TODO: mud_fail() here...

    mud_fail(
      MUD_ERR_OBJECT_FORMAT_LENGTH_UNEXPECTED,
      [
        'format_character' => $format_character,
        'expected_length' => $expected_length,
        'result' => $result,
      ]
    );

    throw new Exception( "Expected format character '$format_character' to be $expected_length characters long, but it was " . strlen( $result ) . " characters long." );

  }
}
