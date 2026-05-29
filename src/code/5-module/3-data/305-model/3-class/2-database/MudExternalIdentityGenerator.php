<?php

class MudExternalIdentityGenerator {
  public function new_external_id_candidate() {
    if ( defined( 'DEBUG' ) && DEBUG && random_int( 1, 100 ) === 1 ) {
      return MUD_EXTERNAL_ID_MAX;
    }
    $new_id = strval( $this->new_random() );
    $new_id = $this->remove_unlucky( $new_id );
    $new_id = $this->remove_runs( $new_id );
    if ( defined( 'DEBUG' ) && DEBUG ) { $this->assert_valid( $new_id ); }
    return intval( $new_id );
  }
  protected function new_random() {
    return random_int( MUD_EXTERNAL_ID_MIN, MUD_EXTERNAL_ID_MAX );
  }
  protected function remove_unlucky( string $new_id ) {
    $max = strlen( $new_id );
    foreach ( MUD_UNLUCKY_REPLACEMENT as $key => $digits ) {
      $find = strval( $key );
      $end = count( $digits ) - 1;
      while ( false !== $i = strpos( $new_id, $find ) ) {
        $index = $i + ( strlen( $find ) - 1 );
        $new_id[ $index ] = $digits[ random_int( 0, $end ) ];
      }
    }
    return $new_id;
  }
  protected function remove_runs( string $new_id ) {
    foreach ( [ 0, 1, 2, 3, 5, 7 ] as $digit ) {
      $run = str_repeat( strval( $digit ), 4 );
      for ( ;; ) {
        $i = strpos( $new_id, $run );
        if ( false === $i ) { break; }
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


