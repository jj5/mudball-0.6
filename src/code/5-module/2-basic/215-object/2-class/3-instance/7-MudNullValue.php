<?php

abstract class MudNullValue implements IMudNullValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-10-21 jj5 - traits...
  //

  use MudCreationMixin;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - Stringable interface...
  //

  public function __toString() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudObject interface...
  //

  // 2024-06-30 jj5 - NOTE: by default null values are not valid...
  //
  public function is_valid( mixed $options = null ) : bool { return false; }

  public function to_string() : string { return ''; }

  public function to_html( mixed $format = null ) : string { return ''; }

  public function to_nbsp( mixed $format = null ) : string { return ''; }

  public function set_parent( IMudNode $parent ) : void { ; }

  public function format( mixed $spec = null ) : string { return ''; }

  public function get_format( mixed $spec = null ) : mixed { return null; }

  public function get_format_default() : mixed { return null; }

  public function render( mixed $format = null, array $attrs = [] ) : void { ; }

  public function validate( mixed $options = null ) : void { ; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return true; }

  public function add_to_list( array &$list ) : void { ; }

  public function add_to_map( mixed $key, array &$map ) : void { ; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudHost interface...
  //

  public function get_child_list() : array { return []; }

  public function get( string $class, int $index = 0 ) : IMudObject { return $this; }

  public function get_first( string $class ) : IMudObject { return $this; }

  public function get_last( string $class ) : IMudObject { return $this; }

  public function get_descendent( string $class ) : IMudObject { return $this; }

  public function get_descendent_depth_first( string $class ) : IMudObject { return $this; }

  public function get_descendent_breadth_first( string $class ) : IMudObject { return $this; }

  public function get_list( string|null $class = null ) : array { return []; }

  public function get_any( array $class_list ) : IMudObject { return $this; }

  public function get_all( array $class_list ) : array { return []; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //

  public function is_empty() : bool { return true; }

  public function is_zero() : bool { return true; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return false; }

  public function to_int() : int { return 0; }

  public function to_float() : float { return 0.0; }

  public function get_value() : mixed { return $this; }

  public function get_db_value() : int|float|string|null { return null; }

  public function get_sort_value() : int|float|string|null { return null; }

  public function get_key() : string { return ''; }

  public function set_key( string $key ) : void { ; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNumber interface...
  //

  public function get_number() : int|float { return 0; }

  public function get_value_min_numeric() : int|float { return 0; }

  public function get_value_max_numeric() : int|float { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - IMudInteger interface...
  //

  public function get_int() : int { return 0; }

  public function get_value_min_integer() : int { return 0; }

  public function get_value_max_integer() : int { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudBoolean interface...
  //

  public function get_bool() : bool { return false; }

  public function is_true() : bool { return false; }

  public function is_false() : bool { return true; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-29 jj5 - IMudFloat interface...
  //

  public function get_float() : float { return 0.0; }

  public function get_value_min_float() : float { return 0.0; }

  public function get_value_max_float() : float { return 0.0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudSign interface...
  //

  public function is_positive() : bool { return true; }

  public function is_negative() : bool { return false; }

  public function get_factor() : int { return MUD_VALUE_POSITIVE_FACTOR; }

  public function get_sign_char() : string { return MUD_VALUE_POSITIVE_CHAR; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudString interface...
  //

  public function get_string() : string { return ''; }

  public function get_hash() : string { return ''; }

  public function get_length_min() : int { return 0; }

  public function get_length_max() : int { return 0; }

  public function get_regex_valid() : array { return []; }

  public function get_regex_invalid() : array { return []; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateTime interface...
  //

  public function new_date_time() : DateTime { return new DateTime( 'now' ); }

  public function get_datetime() : DateTimeImmutable {

    static $result = new DateTimeImmutable( '@0' );

    return $result;

  }

  // 2024-06-30 jj5 - THINK: an argument could be made that these should be true... they do implement the interface...

  public function is_date() : bool { return false; }

  public function is_time() : bool { return false; }

  public function is_date_time() : bool { return false; }

  public function is_universal() : bool { return false; }

  public function is_local() : bool { return false; }

  public function is_zoned() : bool { return false; }

  public function get_value_min_datetime() : DateTimeInterface { return MudDateTime::min_value(); }

  public function get_value_max_datetime() : DateTimeInterface { return MudDateTime::max_value(); }

  public function get_timestamp() : int { return 0; }

  public function get_for_utc() : DateTimeInterface {

    static $utc = new DateTimeZone( 'UTC' );

    return new DateTime( 'now', $utc );

  }

  public function format_for_web() : string { return ''; }

  public function format_for_sitemap() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateTimeZoned interface...
  //

  public function get_time_zone() : IMudDateTimeZone { return $this; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateTimeZone interface...
  //

  public function get_offset() : int { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateInterval interface...
  //

  public function get_interval() : DateInterval {

    static $result = new DateInterval( 'PT0S' );

    return $result;

  }

  public function get_microseconds(): int { return 0; }

  public function format_auto() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudCurrency interface...
  //

  public function get_currency_code() : string { return ''; }

  public function get_currency_code_numeric() : int { return 0; }

  public function get_currency_name() : string { return ''; }

  public function get_currency_minor_unit() : int { return 0; }

  public function get_default_currency() : IMudCurrency { return $this; }

  public function get_currency_rates() : array { return []; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudMoney interface...
  //


  public function is_less_than( IMudMoney $money ) : bool { return false; }

  public function is_greater_than( IMudMoney $money ) : bool { return false; }

  public function to_currency( IMudCurrency|string $currency ): IMudMoney { return $this; }

  public function get_sign() : IMudSign { return $this; }

  public function get_currency() : IMudCurrency { return $this; }

  public function get_amount() : int { return 0; }

  public function add_money( IMudMoney|null $money ) : IMudMoney { return $this; }

  public function subtract_money( IMudMoney|null $money ) : IMudMoney { return $this; }

  public function invert_money() : IMudMoney { return $this; }

  public function multiply_money( int|float $factor ) : IMudMoney { return $this; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudPrice interface...
  //

  public function get_money() : IMudMoney { return $this; }

  public function get_value_min_money() : IMudMoney|null { return $this; }

  public function get_value_max_money() : IMudMoney|null { return $this; }

  public function get_price_in_currency( IMudCurrency|string $currency ) : IMudPrice { return $this; }

  public function add_price( IMudPrice|null $price ) : IMudPrice { return $this; }

  public function subtract_price( IMudPrice|null $price ) : IMudPrice { return $this; }

  public function invert_price() : IMudPrice { return $this; }

  public function multiply_price( int|float $factor ) : IMudPrice{ return $this;  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudUrl interface...
  //

  public function get_url_scheme() : IMudUrlScheme { return $this; }

  public function get_url_user() : IMudUrlUser { return $this; }

  public function get_url_pass() : IMudUrlPass { return $this; }

  public function get_url_host() : IMudUrlHost { return $this; }

  public function get_url_port() : IMudUrlPort { return $this; }

  public function get_url_path() : IMudUrlPath { return $this; }

  public function get_url_query() : IMudUrlQuery { return $this; }

  public function get_url_fragment() : IMudUrlFragment { return $this; }

  public function format_relative() : string { return ''; }

  public function format_absolute() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudUrlEncoded interface...
  //

  public function decode() : string { return ''; }

}
