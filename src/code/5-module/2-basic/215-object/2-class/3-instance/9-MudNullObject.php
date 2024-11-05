<?php

class MudNullValue implements IMudNullValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - mixins...
  //

  use MudNullObjectMixin;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - Stringable interface...
  //

  public function __toString() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return true; }

  public function get_null() : IMudNullObject { return $this; }

  public function add_to_list( array &$list ) : void { ; }

  public function add_to_map( mixed $key, array &$map ) : void { ; }



  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //

  public function is_empty() : bool { return true; }

  public function is_zero() : bool { return true; }

  public function is_integer( int $n ) : bool { return $n === 0; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return false; }

  public function to_int() : int { return 0; }

  public function to_float() : float { return 0.0; }

  public function to_string() : string { return ''; }

  public function get_value() : mixed { return null; }

  public function get_db_value() : int|float|string|null { return null; }

  public function get_sort_value() : int|float|string|null { return null; }

  public function get_child_list() : array { return []; }

  public function get( string $class, int $index = 0 ) : IMudObject { return $this; }

  public function get_first( string $class ) : IMudObject { return $this; }

  public function get_last( string $class ) : IMudObject { return $this; }

  public function get_closest( string $class ) : IMudObject { return $this; }

  public function get_descendent( string $class ) : IMudObject { return $this; }

  public function get_descendent_depth_first( string $class ) : IMudObject { return $this; }

  public function get_descendent_breadth_first( string $class ) : IMudObject { return $this; }

  public function get_list( string|null $class = null ) : array { return []; }

  public function get_any( array $class_list ) : IMudObject { return $this; }

  public function get_all( array $class_list ) : array { return []; }

  public function set_parent( IMudNode $parent ) : void { ; }

  public function format( mixed $spec = null ) : string { return ''; }

  public function render( mixed $format = null, array $attrs = [] ) : void { ; }

  public function validate( mixed $options = null ) : void { ; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudNumber interface...
  //

  public function get_number() : int|float { return 0; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudBoolean interface...
  //

  public function is_true() : bool { return false; }

  public function is_false() : bool { return true; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudSign interface...
  //

  public function is_positive() : bool { return true; }

  public function is_negative() : bool { return false; }

  public function get_factor() : int { return MUD_VALUE_POSITIVE_FACTOR; }

  public function get_char() : string { return MUD_VALUE_POSITIVE_CHAR; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudString interface...
  //

  public function get_hash() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudDateTime interface...
  //

  public function new_date_time() : DateTime { return new DateTime( 'now' ); }

  // 2024-06-30 jj5 - NOTE: by default null values are not valid...

  public function is_valid( mixed $options = null ) : bool { return false; }

  // 2024-06-30 jj5 - THINK: an argument could be made that these should be true... they do implement the interface...

  public function is_date() : bool { return false; }

  public function is_time() : bool { return false; }

  public function is_date_time() : bool { return false; }

  public function is_universal() : bool { return false; }

  public function is_local() : bool { return false; }

  public function is_zoned() : bool { return false; }

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

  public function get_microseconds(): int { return 0; }

  public function format_auto() : string { return ''; }

}
