<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleDefine extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function get_constants( string $prefix = '' ) : array {

    $result = [];
    $constants = get_defined_constants();

    foreach ( $constants as $name => $value ) {

      if ( $prefix === '' || strpos( $name, $prefix ) === 0 ) {

        $result[ $name ] = $value;

      }
    }

    return $result;

  }

  public function define_version( string $const_prefix ) {

    if ( defined( $const_prefix . '_VERSION' ) ) {

      $code_constant = $const_prefix . '_CODE';

      $code = defined( $code_constant ) ? constant( $code_constant ) : null;

      mud_fail( MUD_ERR_DEFINE_CONSTANTS_ALREADY_DEFINED, [ 'code' => $code ] );

    }

    define(
      $const_prefix . '_VERSION_BASE',
      constant( $const_prefix . '_VERSION_MAJOR' ) . '.' .
      constant( $const_prefix . '_VERSION_MINOR' ) . '.' .
      constant( $const_prefix . '_VERSION_PATCH' )
    );

    $component = constant( $const_prefix . '_CODE' );
    $path = constant( $const_prefix . '_PATH' );
    $version_base = constant( $const_prefix . '_VERSION_BASE' );

    $namespace = $component === MUDBALL_CODE ? 'mud' : 'app';

    $build_constant = $component === MUDBALL_CODE ? 'MUD_BUILD' : 'APP_BUILD';

    global $config;

    if ( defined( $build_constant ) ) {

      $build = constant( $build_constant );

      if ( isset( $config[ $namespace ][ 'version' ][ 'build' ] ) ) {

        mud_require(
          $config[ $namespace ][ 'version' ][ 'build' ] === $build,
          'build types must agree.',
          [
            'build_const' => $build,
            'build_config' => $config[ $namespace ][ 'version' ][ 'build' ],
          ]
        );

      }
    }
    else if ( isset( $config[ $namespace ][ 'version' ][ 'build' ] ) ) {

      $build = $config[ $namespace ][ 'version' ][ 'build' ];

      define( $build_constant, $build );

    }
    else {

      $build = 'prod';

      $config[ $namespace ][ 'version' ][ 'build' ] = $build;

      define( $build_constant, $build );

    }

    mud_require(
      in_array( $build, MUD_BUILD_TYPES ),
      'valid build required.',
      [ 'build' => $build ]
    );

    $version = $version_base;

    $vcs_revision = null;
    $vcs_date = null;

    if ( isset( $config[ $namespace ][ 'version' ][ 'vcs_revision' ] ) ) {

      $vcs_revision = intval( $config[ $namespace ][ 'version' ][ 'vcs_revision' ] );

    }
    else {

      $vcs_revision = $this->parse_svn_revision( $path, $vcs_date );

      $config[ $namespace ][ 'version' ][ 'revision' ] = $vcs_revision;
      $config[ $namespace ][ 'version' ][ 'date' ] = $vcs_date;

    }

    // 2024-08-12 jj5 - OLD: we don't do this any more because we're on git now...
    /*
    if ( defined( 'DEV' ) && DEV && $vcs_revision ) {

      $version .= "-$vcs_revision";

    }
    */

    if ( $build !== 'prod' ) {

      $version .= "-$build";

    }

    $this->define_default( $const_prefix . '_VERSION_BUILD', $build );
    $this->define_default( $const_prefix . '_VERSION_VCS_REVISION', $vcs_revision );
    $this->define_default( $const_prefix . '_VERSION_VCS_DATE', $vcs_date );

    $this->define_default( $const_prefix . '_VERSION', $version );
    $this->define_default( $const_prefix . '_VERSION_BASIC', $version_base );

    $slug =
      constant( $const_prefix . '_CODE' ) .
      '-' .
      constant( $const_prefix . '_VERSION' );

    $this->define_default( $const_prefix . '_SLUG', $slug );
    $this->define_default( $const_prefix . '_CONST', $const_prefix );

    $this->define_default( $const_prefix, $slug );

    if ( $const_prefix === 'MUDBALL' ) {

      return $this->define_list( $const_prefix, 'MUD' );

    }

    return $this;

  }

  public function define_app( string $const_prefix ) {

    return $this->define_list( $const_prefix, 'APP' );

  }

  protected function define_list( $const_prefix, $short_prefix ) {

    static $const_list = [
      'NAME', 'CODE', 'PATH', 'CONFIG_FILE', 'CONFIG_PATH',
      /*'HOST', 'CONFIG_HOST', */
      'VERSION_MAJOR', 'VERSION_MINOR', 'VERSION_PATCH',
      'VERSION_BASE', 'VERSION_BUILD', 'VERSION_VCS_REVISION', 'VERSION_VCS_DATE',
      'VERSION', 'VERSION_BASIC', 'SLUG', 'CONST',
      'MAINTAINER_USERNAME', 'MAINTAINER_EMAIL', 'MAINTAINER_NAME',
      'MAINTAINER',
    ];

    if ( $const_prefix === 'APP' ) {

      mud_fail( MUD_ERR_DEFINE_APP_CONSTANTS_CANNOT_BE_REDEFINED );

    }

    if ( $const_prefix === $short_prefix ) {

      mud_fail( MUD_ERR_DEFINE_APP_CONSTANTS_CANNOT_BE_REDEFINED );

    }

    foreach ( $const_list as $const ) {

      $real_const = $const_prefix . '_' . $const;
      $short_const = $short_prefix . '_' . $const;

      if ( defined( $short_const ) ) {

        mud_fail( MUD_ERR_DEFINE_APP_CONSTANT_IS_ALREADY_DEFINED, [ 'const' => $short_const ] );

      }

      if ( ! defined( $real_const ) ) {

        mud_fail( MUD_ERR_DEFINE_VERSION_CONSTANT_IS_UNDEFINED, [ 'const' => $real_const ] );

      }

      define( $short_const, constant( $real_const ) );

    }

    return $this;

  }

  public function define_default( string $name, $value ) {

    if ( defined( $name ) ) { return $this; }

    define( $name, $value );

    return $this;

  }

  public function require_define( string $name, $value ) {

    if ( ! defined( $name ) ) {

      mud_fail(
        MUD_ERR_DEFINE_CONSTANT_DEFINITION_IS_REQUIRED,
        [ 'name' => $name, 'value' => $value ]
      );

    }

    if ( $value !== constant( $name ) ) {

      mud_fail(
        MUD_ERR_DEFINE_CONSTANT_VALUE_IS_INVALID,
        [ 'name' => $name, 'value' => $value ]
      );

    }

    return $this;

  }

  protected function parse_svn_revision( string $path, &$date = null ) : int {

    $lines = file( __DIR__ . '/../../../../../../inc/version.php' );

    foreach ( $lines as $line ) {

      if ( preg_match( '/Date: ([^ ]*) ([^ ]*)([^ ]*)/', $line, $matches ) ) {

        $iso_date = $matches[ 1 ] . ' ' . $matches[ 2 ] . ' ' . $matches[ 3 ];

        $date = date( "D, j M y H:i:s O", strtotime( $iso_date ) );

      }

      if ( preg_match( '/Revision: ([^ ]*)/', $line, $matches ) ) {

        return intval( $matches[ 1 ] );

      }
    }

    mud_not_supported();

    // 2024-07-01 jj5 - we used to load this info from svn, but now we're on git.

    $cmd = 'svn info ' . addslashes( $path );

    $info = trim( shell_exec( $cmd ) );

    $lines = explode( "\n", $info );

    $revision = 0;
    $date = null;

    foreach ( $lines as $line ) {

      $parts = explode( ':', $line, 2 );

      if ( trim( $parts[ 0 ] ) === 'Revision' ) {

        $revision = intval( trim( $parts[ 1 ] ) );

      }
      else if ( trim( $parts[ 0 ] ) === 'Last Changed Date' ) {

        $date_parts = explode( ' ', $parts[ 1 ] );

        $iso_date = $date_parts[ 0 ] . ' ' . $date_parts[ 1 ] . ' ' .
          $date_parts[ 2 ];

        $date = date( "D, j M y H:i:s O", strtotime( $iso_date ) );

      }
    }

    return $revision;

  }
}
