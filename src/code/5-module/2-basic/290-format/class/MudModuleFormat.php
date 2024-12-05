<?php

class MudModuleFormat extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  public function format_as_revision_code( $input ) {

    if ( $this->is_in_revision_code_format( $input ) ) { return $input; }

    if ( ! $this->is_in_revision_number_format( $input ) ) {

      $this->fail( MUD_ERR_FORMAT_INVALID_REVISION_FORMAT, [ 'input' => $input ] );

    }

    $string = strval( $input );

    $year = substr( $string, 0, 4 );
    $month = substr( $string, 4, 2 );
    $day = substr( $string, 6, 2 );
    $time = substr( $string, 8 );

    /*
    mud_dump([
      'input' => $input,
      'year' => $year,
      'month' => $month,
      'day' => $day,
      'time' => $time,
    ]);
    */

    return "$year-$month-$day-$time";

  }

  public function format_as_revision_number( $input ) {

    if ( $this->is_in_revision_number_format( $input ) ) { return intval( $input ); }

    if ( ! $this->is_in_revision_code_format( $input ) ) {

      $this->fail( MUD_ERR_FORMAT_INVALID_REVISION_FORMAT, [ 'input' => $input ] );

    }

    return intval( str_replace( '-', '', $input ) );

  }

  public function format_action( string $action, array $args = [] ) {

    if ( ! $args ) { return $action; }

    return $action . '?' . http_build_query( $args );

  }

  public function format_headers( array $header_map ) {

    $header_list = [];

    foreach ( $header_map as $key => $val ) {

      $header_list[] = "$key: $val";

    }

    $headers = implode( "\r\n", $header_list );

    return $headers;

  }

  public function is_in_revision_code_format( string $input ) {

    if ( preg_match( '/\d{4}-\d{2}-\d{2}-\d{6}/', $input ) ) { return true; }

    return false;

  }

  public function is_in_revision_number_format( string $input ) {

    if ( preg_match( '/^\d{14}$/', $input ) ) { return true; }

    return false;

  }
}
