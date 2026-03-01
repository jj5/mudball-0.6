<?php

class MudIdentityGeneratorExternal {

  public function new_external_id_candidate() {
    // during debugging we generate duplicates occasionally to test those are handled properly...
    if ( defined( 'DEBUG' ) && DEBUG && random_int( 1, 100 ) === 1 ) {
      return [ KICKASS_EXTERNAL_ID_MIN, KICKASS_EXTERNAL_ID_MAX ][ random_int( 0, 1 ) ];
    }
    $candidate_id = strval( $this->new_random() );
    $candidate_id = $this->remove_unlucky( $candidate_id );
    $candidate_id = $this->remove_runs( $candidate_id );
    if ( defined( 'DEBUG' ) && DEBUG ) { $this->assert_valid( $candidate_id ); }
    return intval( $candidate_id );
  }

  protected function new_random() {
    return random_int( KICKASS_EXTERNAL_ID_MIN, KICKASS_EXTERNAL_ID_MAX );
  }

  protected function remove_unlucky( string $candidate_id ) {
    // note that we need to process the replacements in the order that they are in so as to avoid
    // recreating situations which we've already fixed.
    foreach ( KICKASS_UNLUCKY_REPLACEMENT as $key => $digits ) {
      $find = strval( $key );
      $end = count( $digits ) - 1;
      while ( false !== ( $i = strpos( $candidate_id, $find ) ) ) {
        // the $index is the last digit (rightmost digit) of the match
        $index = $i + ( strlen( $find ) - 1 );
        $candidate_id[ $index ] = $digits[ random_int( 0, $end ) ];
      }
    }
    return $candidate_id;
  }

  protected function remove_runs( string $candidate_id ) {
    // this loop removes runs of digits that exceed three repetitions... we don't need to check
    // for runs which can't occur, such as 444, 666, 888, and 999.
    foreach ( [ 0, 1, 2, 3, 5, 7 ] as $digit ) {
      $run = str_repeat( strval( $digit ), 4 );
      for ( ;; ) {
        $i = strpos( $candidate_id, $run );
        if ( false === $i ) { break; }
        // we can replace any digit in the run to break it, we pick the third so only two digits
        // will repeat... 2 and 5 are special, they are the only non-zero numbers that never
        // appear in an unlucky number.
        $candidate_id[ $i + 2 ] = '25'[ random_int( 0, 1 ) ];
      }
    }
    return $candidate_id;
  }

  protected function assert_valid( string $candidate_id ) {
    foreach ( array_keys( KICKASS_UNLUCKY_REPLACEMENT ) as $key ) {
      assert( false === strpos( $candidate_id, strval( $key ) ) );
    }
    foreach ( range( 0, 9 ) as $digit ) {
      assert( false === strpos( $candidate_id, str_repeat( strval( $digit ), 4 ) ) );
    }
  }
}
