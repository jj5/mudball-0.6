<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - class definition...
//

class MudModuleValue extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - protected fields...
  //

  protected array $atom_map = [];

  protected int $atom_count = 0;

  protected int $atom_size = 0;

  protected array $composite_map = [];

  protected int $composite_count = 0;

  protected int $composite_size = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private IMudTrue $true;

  private IMudFalse $false;

  private IMudPositive $positive;

  private IMudNegative $negative;

  private IMudNullObject $null_object;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->true = $this->get_atom( MudTrue::class, '1' );
    $this->false = $this->get_atom( MudFalse::class, '0' );

    $this->positive = $this->get_atom( MudPositive::class, '+' );
    $this->negative = $this->get_atom( MudNegative::class, '-' );

    $this->null_object = MudNullObject::Instance();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public functions...
  //

  public function get_boolean( mixed $value ) : IMudBoolean {

    return $value ? $this->get_true() : $this->get_false();

  }

  public function get_true() : IMudTrue {

    return $this->true;

  }

  public function get_false() : IMudFalse {

    return $this->false;

  }

  public function get_sign( mixed $value ) : IMudSign {

    if ( $value === MUD_NEGATIVE_CHAR ) { return $this->get_negative(); }

    if ( $value === MUD_NEGATIVE_FACTOR ) { return $this->get_negative(); }

    // 2024-06-30 jj5 - THINK: we could probably implement nullable support for sign, but there's not likely any real
    // use-case for it...

    return $this->get_positive();

  }

  public function get_positive() : IMudPositive {

    return $this->positive;

  }

  public function get_negative() : IMudNegative {

    return $this->negative;

  }

  public function get_integer( mixed $value ) : IMudInteger {

    return $this->get_atom( MudInteger::class, $value );

  }

  public function get_float( mixed $value ) : IMudFloat {

    return $this->get_atom( MudFloat::class, $value );

  }

  public function get_string( mixed $value ) : IMudString {

    return $this->get_atom( MudString::class, $value );

  }

  public function get_text( mixed $value ) : IMudText {

    return $this->get_atom( MudText::class, $value );

  }

  public function get_binary( mixed $value ) : IMudBinary {

    return $this->get_atom( MudBinary::class, $value );

  }

  public function get_date( mixed $value ) : IMudDate {

    return $this->get_atom( MudDate::class, $value );

  }

  public function get_time( mixed $value ) : IMudTime {

    return $this->get_atom( MudTime::class, $value );

  }

  public function get_date_time_universal( mixed $value ) : IMudDateTimeUniversal {

    return $this->get_atom( MudDateTimeUniversal::class, $value );

  }

  public function get_date_time_local( mixed $value ) : IMudDateTimeLocal {

    return $this->get_atom( MudDateTimeLocal::class, $value );

  }

  public function get_date_time_zoned( mixed $value ) : IMudDateTimeZoned {

    return $this->get_atom( MudDateTimeZoned::class, $value );

  }

  public function get_date_time_zone( mixed $value ) : IMudDateTimeZone {

    return $this->get_atom( MudDateTimeZone::class, $value );

  }

  public function get_date_interval( mixed $value ) : IMudDateInterval {

    return $this->get_atom( MudDateInterval::class, $value );

  }

  public function get_currency( IMudCurrency|string|null $currency ) : IMudCurrency {

    if ( ! $currency ) { return $this->get_null(); }

    if ( is_string( $currency ) ) {

      $class = 'MudCurrency_' . $currency;

      return $this->get_atom( $class, $currency );

    }

    return $currency;

  }

  public function get_money( int $amount, IMudCurrency|string $currency ) : IMudMoney {

    $class = 'MudMoney_' . mud_get_currency( $currency )->get_currency_code();

    return $this->get_atom( $class, $amount );

  }

  public function parse_money( string $value ) : IMudMoney {

    return MudMoney::parse( $value );

  }



/*
  public function get_dollars( mixed $value ) : IMudDollars {

    return $this->get_atom( MudDollars::class, $value );

  }

  public function get_cents( mixed $value ) : IMudCents {

    return $this->get_atom( MudCents::class, $value );

  }
*/

  public function get_url( mixed $value ) : IMudUrl {

    return $this->get_atom( MudUrl::class, $value );

  }

  public function get_url_scheme( mixed $value ) : IMudUrlScheme {

    return $this->get_atom( MudUrlScheme::class, $value );

  }

  public function get_url_user( mixed $value ) : IMudUrlUser {

    return $this->get_atom( MudUrlUser::class, $value );

  }

  public function get_url_pass( mixed $value ) : IMudUrlPass {

    return $this->get_atom( MudUrlPass::class, $value );

  }

  public function get_url_host( mixed $value ) : IMudUrlHost {

    return $this->get_atom( MudUrlHost::class, $value );

  }

  public function get_url_port( mixed $value ) : IMudUrlPort {

    return $this->get_atom( MudUrlPort::class, $value );

  }

  public function get_url_path( mixed $value ) : IMudUrlPath {

    return $this->get_atom( MudUrlPath::class, $value );

  }

  public function get_url_query( mixed $value ) : IMudUrlQuery {

    return $this->get_atom( MudUrlQuery::class, $value );

  }

  public function get_url_fragment( mixed $value ) : IMudUrlFragment {

    return $this->get_atom( MudUrlFragment::class, $value );

  }

  public function get_value( string $class, mixed $argument ) : IMudAtom {

    if ( is_a( $class, IMudAtom::class ) ) {

      if ( is_array( $argument ) ) { $argument = $argument[ 0 ] ?? null;}

      return $this->get_atom( $class, $argument );

    }

    assert( is_a( $class, IMudComposite::class ) );

    if ( ! is_array( $argument ) ) { $argument = [ $argument ];}

    return $this->get_atom( $class, $argument );

  }

  public function get_atom( string $class, mixed $value ) : IMudAtom {

    if ( $value === null ) { return $this->get_null(); }

    $key = $this->get_atom_key( $value );

    if ( ! isset( $this->atom_map[ $class ][ $key ] ) ) {

      $new_value = new $class( $value );

      $new_value->set_key( $key );

      $this->atom_count += 1;

      if ( DEBUG ) { $this->atom_size += $this->get_size( $new_value ); }

      $this->atom_map[ $class ][ $key ] = $new_value;

      $this->add_object( $new_value );

    }

    return $this->atom_map[ $class ][ $key ];

  }

  public function get_composite( string $class, array $value_list ) : IMudComposite {

    // 2024-06-30 jj5 - THINK: do we want a null value if only some of the values are null?

    $is_null = false;

    foreach ( $value_list as $value ) { if ( $value === null ) { $is_null = true; break; } }

    if ( $is_null ) { return $this->get_null(); }

    $key = $this->get_composite_key( $value_list );

    if ( ! isset( $this->composite_map[ $class ][ $key ] ) ) {

      $new_value = new $class( $value_list );

      $new_value->set_key( $key );

      $this->composite_count += 1;

      if ( DEBUG ) { $this->composite_size += $this->get_size( $new_value ); }

      $this->composite_map[ $class ][ $key ] = $new_value;

      $this->add_object( $new_value );

    }

    return $this->composite_map[ $class ][ $key ];

  }

  public function get_null() : IMudNullObject {

    return $this->null_object;

  }

  public function set_null( IMudNullObject $null_object ) : void {

    $this->null_object = $null_object;

  }

  public function get_primitive( mixed $value ) : bool|int|float|string|object|null {

    // 2024-06-30 jj5 - I listed these roughly in order of how common I think they are...

    if ( is_string( $value ) ) { return $value; }
    if ( is_int( $value ) ) { return $value; }
    if ( is_bool( $value ) ) { return $value; }
    if ( is_float( $value ) ) { return $value; }
    if ( is_null( $value ) ) { return null; }

    if ( is_a( IMudValue::class, $value ) ) { return $value->get_value(); }

    // 2024-06-30 jj5 - THINK: do we want to just return this object, or maybe convert it to a string?

    return $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - protected instance methods...
  //

  protected function new_null_object() : IMudNullObject {

    return MudNullObject::Create();

  }

  protected function get_atom_key( mixed $value ) {

    $key = strval( $value );

    return $this->get_key( $key );

  }

  protected function get_composite_key( array $value_list ) {

    $key = implode( "\x1f", $value_list );

    return $this->get_key( $key );

  }

  protected function get_key( string $candidate_key ) {

    if ( strlen( $candidate_key ) > 224 ) { return $this->get_hash( $candidate_key ); }

    return $candidate_key;

  }

  protected function get_hash( string $value ) : string {

    return hash( 'sha512/224', $value );

  }

  protected function get_size( mixed $value ) {

    return strlen( serialize( $value ) );

  }

  protected function add_object( IMudObject $obj ) : void { ; }

}
