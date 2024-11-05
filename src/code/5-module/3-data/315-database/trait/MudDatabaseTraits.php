<?php

trait MudDatabaseTraits {

  public function read_table_name(
    string $prefix,
    string $any_table_name,
    &$a_rectangle_type_code,
    &$a_table_pattern_code,
    &$a_table_name,
    &$a_table_full_name,
    &$a_table_short_name
  ) {

    $a_table_pattern_code = null;
    $a_table_name = null;
    $a_table_short_name = null;

    if ( $prefix === '' || strpos( $any_table_name, $prefix ) === 0 ) {

      $a_table_full_name = $any_table_name;
      $a_table_name = substr( $a_table_full_name, strlen( $prefix ) );

    }
    else if ( strpos( $any_table_name, 't_' ) === 0 ) {

      $a_table_name = $any_table_name;
      $a_table_full_name = "{$prefix}{$a_table_name}";

    }
    else {

      $a_rectangle_type_code = 'other';
      $a_table_pattern_code = 'other';

      $a_table_name = $any_table_name;
      $a_table_full_name = $any_table_name;
      $a_table_short_name = $any_table_name;

      return;

    }

    $parts = explode( '_', $a_table_name, 3 );

    assert( count( $parts ) === 3 );

    $a_rectangle_type_code = $this->get_rectangle_type_code( $parts[ 0 ] );
    $a_table_pattern_code = $parts[ 1 ];
    $a_table_short_name = $parts[ 2 ];

  }

  /*
  // 2020-03-18 jj5 - the $table_name is the table name without the $prefix
  //
  public function read_table_name(
    string $a_table_name,
    &$a_rectangle_type_code,
    &$a_table_pattern_code,
    &$a_table_short_name
  ) {

    $parts = explode( "_", $a_table_name, 3 );

    assert( count( $parts ) === 3 );

    $a_rectangle_type_code = $this->get_rectangle_type_code( $parts[ 0 ] );
    $a_table_pattern_code = $parts[ 1 ];
    $a_table_short_name  = $parts[ 2 ];

  }

  // 2020-03-18 jj5 - the $table_full_name is the full table name, including
  // the $prefix...
  //
  public function read_table_full_name(
    string $prefix,
    string $any_table_name,
    &$a_rectangle_type_code,
    &$a_table_pattern_code,
    &$a_table_name,
    &$a_table_full_name,
    &$a_table_short_name
  ) {

    $a_table_pattern_code = null;
    $a_table_name = null;
    $a_table_short_name = null;

    if ( strpos( $a_table_full_name, $prefix ) !== 0 ) {

      $a_rectangle_type_code = 'other';
      $a_table_pattern_code = 'other';
      $a_table_name = $a_table_full_name;
      $a_table_short_name = $a_table_full_name;

    }
    else {

      $a_table_name = substr( $a_table_full_name, strlen( $prefix ) );

      $parts = explode( '_', $a_table_name, 3 );

      assert( count( $parts ) === 3 );

      $a_rectangle_type_code = $this->get_rectangle_type_code( $parts[ 0 ] );
      $a_table_pattern_code = $parts[ 1 ];
      $a_table_short_name = $parts[ 2 ];

    }
  }
  */

  public function get_rectangle_type_code( string $a_rectangle_type_char ) {

    switch ( $a_rectangle_type_char ) {

      case 't' : return MUD_RECTANGLE_TYPE_TABLE;
      case 'v' : return MUD_RECTANGLE_TYPE_VIEW;
      case 'p' : return MUD_RECTANGLE_TYPE_PRETTY;

      default : return MUD_RECTANGLE_TYPE_OTHER;

    }
  }

  public function get_rectangle_type(
    string $prefix,
    string $any_table_name
  ) : int {

    $this->read_table_name(
      $prefix,
      $any_table_name,
      $a_rectangle_type_code,
      $a_table_pattern_code,
      $a_table_name,
      $a_table_full_name,
      $a_table_short_name
    );

    return MudRectangleType::GetEnum( $a_rectangle_type_code );

  }

  public function get_table_pattern(
    string $prefix,
    string $any_table_name
  ) : int {

    $this->read_table_name(
      $prefix,
      $any_table_name,
      $a_rectangle_type_code,
      $a_table_pattern_code,
      $a_table_name,
      $a_table_full_name,
      $a_table_short_name
    );

    return MudTablePattern::GetEnum( $a_table_pattern_code );

  }

  public function paramify( array $map ) {

    $result = [];

    foreach ( $map as $key => $val ) {

      $result[ ":$key" ] = $val;

    }

    return $result;

  }
}
