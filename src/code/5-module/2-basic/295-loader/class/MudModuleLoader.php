<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-05-23 jj5 - class definition...
//

class MudModuleLoader extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-23 jj5 - protected fields...
  //

  protected $facility_cache = [];
  protected $processor_cache = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-23 jj5 - public methods...
  //

  public function load_facility( $request_path_parts, &$selector ) {

    return $this->find_facility( $request_path_parts, $selector );

  }

  public function load_processor( string $action_input, &$action_code = null, &$action_args = null ) {

    return $this->find_processor( $action_input, $action_code, $action_args );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-23 jj5 - protected methods...
  //

  protected function find_facility( array $request_path_parts, &$selector ) {

    if ( ! self::IsValidSelector( $request_path_parts ) ) { return false; }

    $root = $request_path_parts[ 0 ] ?? null;

    if ( $root === 'res' ) { return new_mud_resource_facility(); }

    static $base_path_list = [
      APP_PATH . '/src/code/8-facility',
      MUDBALL_PATH . '/src/code/8-facility',
    ];

    $content_selector = array_merge( [ 'content' ], $request_path_parts );

    foreach ( $base_path_list as $base_path ) {

      $facility = $this->find_facility_for( $request_path_parts, $base_path, $selector );

      if ( $facility ) { return $facility; }

      $facility = $this->find_facility_for( $content_selector, $base_path, $selector );

      if ( $facility ) { return $facility; }

    }

    return mud_null_object();

  }

  protected function find_facility_for( array $request_path_parts, string $base_path, &$selector ) {

    $selector = [];

    $request_dir_parts = $request_path_parts;

    array_pop( $request_dir_parts );

    while ( $request_path_parts ) {

      $file_path = implode( '/', $request_dir_parts );
      $file_name = 'facility_' . implode( '_', $request_path_parts ) . '.php';

      $path = realpath( "$base_path/$file_path/$file_name" );

      if ( file_exists( $path ) ) {

        if ( array_key_exists( $path, $this->facility_cache ) ) {

          $facility = $this->facility_cache[ $path ];

        }
        else {

          $facility = require_once $path;

          $this->facility_cache[ $path ] = $facility;

        }

        if ( ! is_a( $facility, MudFacility::class ) ) {

          mud_fail( MUD_ERR_HOST_INCLUDE_NOT_A_FACILITY, [ 'path' => $path ] );

        }

        return $facility;

      }

      array_pop( $request_dir_parts );

      array_unshift( $selector, array_pop( $request_path_parts ) );

    }

    return false;

  }

  protected function find_processor( string $action_input, &$action_code = null, &$action_args = null ) {

    MudAction::Parse( $action_input, $action_code, $action_args );

    $action = str_replace( '.', '_', $action_code );
    $parts = explode( '_', $action );

    foreach ( $parts as $part ) {

      if ( ! preg_match( '/^[a-z][a-z0-9-]*$/', $part ) ) {

        mud_fail( MUD_ERR_ACTION_INVALID_PART, [ 'part' => $part ] );

      }
    }

    $dir = $parts;
    $file = $parts;

    array_pop( $dir );

    $file_path = implode( '/', $dir ) . '/action_' . implode( '_', $file ) . '.php';

    static $base_path_list = [
      APP_PATH . '/src/code/7-action',
      MUDBALL_PATH . '/src/code/7-action',
    ];

    foreach ( $base_path_list as $base_path ) {

      $path = realpath( "$base_path/$file_path" );

      if ( file_exists( $path ) ) {

        if ( array_key_exists( $path, $this->processor_cache ) ) {

          $processor = $this->processor_cache[ $path ];

        }
        else {

          $processor = require_once $path;

          $this->processor_cache[ $path ] = $processor;

        }

        if ( ! is_a( $processor, MudAction::class ) ) {

          mud_fail( MUD_ERR_ACTION_INVALID_PROCESSOR, [ 'path' => $path, 'processor' => $processor ] );

        }

        return $processor;

      }
    }

    return mud_null_object();

  }

  protected static function IsValidSelector( array $request_path_parts ) {

    // 2022-02-19 jj5 - we check for ASCII and multi-byte to try and catch junk input...

    foreach ( $request_path_parts as $part ) {

      if ( mb_strpos( $part, '..' ) !== false ) { return false; }

      if ( strpos( $part, '..' ) !== false ) { return false; }

      if ( mb_strpos( $part, '/'  ) !== false ) { return false; }

      if ( strpos( $part, '/'  ) !== false ) { return false; }

      if ( preg_match( '/^\s/', $part ) ) { return false; }

      if ( preg_match( '/\s$/', $part ) ) { return false; }

      if ( preg_match( '/[\x00-\x1f\x7f]/', $part ) ) { return false; }

    }

    return true;

  }
}
