<?php

// 2024-06-29 jj5 - NOTE: this class is shit, it needs to be fixed up quite a bit...

class MudUrlBuilder extends MudService {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-04 jj5 - protected fields...
  //

  protected $rel_base, $abs_base, $cdn;


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-04 jj5 - constructor...
  //
  /*
  public function __construct( $request, $cdn = null ) {

    parent::__construct( APP_SERVICE_URL );

    if ( $cdn === null ) {

      if ( defined( 'APP_CDN' ) ) { $cdn = APP_CDN; }

    }

    $rel_base = $request->get_controller_path();
    $abs_base = $request->get_controller_url();

    $this->rel_base = $rel_base;
    $this->abs_base = $abs_base;
    $this->cdn = $cdn;

  }
  */

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudUrl|null $previous = null ) {

    parent::__construct( $previous );

    $cdn = defined( 'APP_CDN' ) ? APP_CDN : null;

    $rel_base = $request->get_controller_path();
    $abs_base = $request->get_controller_url();

    $this->rel_base = $rel_base;
    $this->abs_base = $abs_base;
    $this->cdn = $cdn;

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-04 jj5 - public methods...
  //

  public function get_rel( $path, $query = null, $fragment = null ) {

    return $this->format( $this->rel_base, $path, $query, $fragment );

  }

  public function get_abs( $path, $query = null, $fragment = null ) {

    return $this->format( $this->abs_base, $path, $query, $fragment );

  }

  public function res( $path, $query = null, $file = 'global' ) {

    static $ext_map = [
      'res/script' => 'js',
      'res/style' => 'css',
    ];

    $path = ltrim( $path, '/' );

    if ( strpos( $path, '..' ) !== false ) {

      mud_fail( MUD_ERR_URL_INVALID_PATH, [ 'path' => $path ] );

    }

    $check = [
      MUDBALL_PATH . "/src/web/$path",
      APP_PATH . "/src/web/$path",
    ];

    if ( array_key_exists( $path, $ext_map ) ) {

      $ext = $ext_map[ $path ];

      $path = "$path/$file.$ext";

      $query[ 'v' ] = $this->get_cache_buster();

    }
    else {

      foreach ( $check as $file ) {

        if ( ! is_file( $file ) ) { continue; }

        if ( $query === null ) { $query = []; }

        // 2022-02-17 jj5 - last in wins...
        //
        $query[ 'v' ] = filemtime( $file );

      }
    }

    return $this->cdn( $path, $query );

  }

  public function cdn( $path, $query = null ) {

    if ( $this->cdn ) {

      $base = $this->cdn . $this->rel_base;

    }
    else {

      $base = $this->rel_base;

    }

    return $this->format( $base, $path, $query );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-04 jj5 - protected methods...
  //

  protected function format( $base, $path, $query, $fragment = null ) {

    $path = $this->read_path( $path );

    array_unshift( $path, '' );

    $result = [ $base, implode( '/', $path ) ];

    if ( $query !== null ) {

      $result[] = '?' . http_build_query( $query );

    }

    if ( $fragment !== null ) {

      $result[] = '#' . $fragment;

    }

    return implode( '', $result );

  }

  protected function read_path( $path ) {

    if ( ! is_array( $path ) ) {

      $path = explode( '/', $path );

    }

    $result = [];

    foreach ( $path as $item ) {

      $item = trim( $item );

      if ( $item ) { $result[] = $item; }

    }

    return $result;

  }

  protected function get_cache_buster() {

    return MUDBALL_VERSION . '-' . APP_VERSION;

  }
}
