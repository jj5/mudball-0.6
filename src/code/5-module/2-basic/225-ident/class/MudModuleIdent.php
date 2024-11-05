<?php

class MudModuleIdent extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2023-02-22 jj5 - public instance methods...
  //

  public function new_external_id() {

    // 2023-03-13 jj5 - during debugging we generate duplicates occoassionally to make sure those
    // are handled properly...
    //
    if ( defined( 'DEBUG' ) && DEBUG && random_int( 1, 100 ) === 37 ) {

      return MUD_EXTERNAL_ID_MAX;

    }

    $new_id = strval( random_int( MUD_EXTERNAL_ID_MIN, MUD_EXTERNAL_ID_MAX ) );
    $new_id = $this->remove_unlucky( $new_id );
    $new_id = $this->remove_runs( $new_id );

    if ( defined( 'DEBUG' ) && DEBUG ) { $this->assert_valid( $new_id ); }

    return intval( $new_id );

  }

  public function format_external_id( int $external_id, $type = null ) {

    assert( $external_id >= MUD_EXTERNAL_ID_MIN );
    assert( $external_id <= MUD_EXTERNAL_ID_MAX );

    $str = rtrim( chunk_split( $external_id, 3, '-' ), '-' );

    if ( $type ) { return "$type-$str"; }

    return $str;

  }

  public function parse_external_id( string $external_id_string ) {

    if ( $this->try_parse_external_id( $external_id_string, $external_id ) ) {

      return $external_id;

    }

    mud_fail( MUD_ERR_IDENT_INVALID_EXTERNAL_ID, [ 'external_id_string' => $external_id_string ] );

  }

  public function try_parse_external_id( string $external_id_string, &$external_id = null ) {

    $external_id = null;

    $str = preg_replace( '/[^\d]/', '', $external_id_string );

    //$str = str_replace( '-', '', $external_id_string );

    $result = intval( $str );

    if ( $result < MUD_EXTERNAL_ID_MIN ) { return false; }

    if ( $result > MUD_EXTERNAL_ID_MAX ) { return false; }

    $external_id = $result;

    return true;

  }

  protected function remove_unlucky( string $new_id ) {

    $max = strlen( $new_id );

    // 2023-03-13 jj5 - note that we need to process the replacements in the order that they are
    // in so as to avoid recreating situations which we've already fixed.
    //
    foreach ( MUD_UNLUCKY_REPLACEMENT as $key => $digits ) {

      $find = strval( $key );
      $end = count( $digits ) - 1;
      $counter = 0;

      while ( false !== $i = strpos( $new_id, $find ) ) {

        if ( $counter++ >= $max ) { throw new Exception( 'algorithm failure.' ); }

        $index = $i + ( strlen( $find ) - 1 );
        $new_id[ $index ] = $digits[ random_int( 0, $end ) ];

      }
    }

    return $new_id;

  }

  protected function remove_runs( string $new_id ) {

    // 2023-03-13 jj5 - this loop removes runs of digits that exceed three repetitions...
    //
    foreach ( [ 0, 1, 2, 3, 5, 6, 7, 8 ] as $digit ) {

      $run = str_repeat( strval( $digit ), 4 );

      for ( ;; ) {

        $i = strpos( $new_id, $run );

        if ( $i === false ) { break; }

        // 2023-03-13 jj5 - we can replace any digit in the run to break it, we pick the third
        // so only two digits will repeat... 2 and 5 are special, they are the only numbers that
        // never appear in an unlucky number...
        //
        $new_id[ $i + 2 ] = str_replace( $digit, '', '25' )[ 0 ];

      }
    }

    return $new_id;

  }

  protected function assert_valid( string $new_id ) {

    foreach ( array_keys( MUD_UNLUCKY_REPLACEMENT ) as $key ) {

      assert( false === strpos( $new_id, strval( $key ) ) );

    }

    foreach ( range( 0, 9 ) as $digit ) {

      assert( false === strpos( $new_id, str_repeat( strval( $digit ), 4 ) ) );

    }
  }
}
