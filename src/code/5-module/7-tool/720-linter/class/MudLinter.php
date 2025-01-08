<?php

class MudLinter extends MudTool {

  protected $verbose = true, $debug = false, $script_path = null;

  function run( $argv ) {

    //
    // 2021-03-29 jj5 - set up and check our environemnt...
    //

    if ( $argv === null ) {

      die( 'This is a command-line app, not a web app.' );

    }

    //
    // 2021-03-29 jj5 - parse our command-line...
    //

    if ( ! file_exists( basename( $this->script_path = array_shift( $argv ) ) ) ) {

      error( 'not in script directory.', MUD_TOOL_EXIT_WRONG_DIR );

    }

    $this->script_path = realpath( $this->script_path );

    while ( $arg = array_shift( $argv ) ) {

      switch ( $arg ) {

        case '--debug'    : $this->debug    = true;   break;
        case '--verbose'  : $this->verbose  = true;   break;
        case '--quiet'    : $this->verbose  = false;  break;

        default :

          $this->value_error( 'unsupported argument', $arg, MUD_TOOL_EXIT_UNKNOWN_ARG );

      }
    }

    $module_const_list = mud_get_module_const_list();

    mud_chdir( '../../..' );

    $this->process_errors( $module_const_list );

    $this->check_mud_fail();

    $this->check_constructor();

  }

  function check_mud_fail() {

    $file_list = mud_get_file_list( '.', '/^.+\.php$/' );

    foreach ( $file_list as $file ) {

      if ( $this->is_file_ignored( $file ) ) { continue; }

      if ( $file->getFilename() === 'mud_error_test.php' ) { continue; }

      $code = file_get_contents( $file );

      if ( ! preg_match( '/mud_fail\(\s*[\'"]/', $code ) ) { continue; }

      mud_stderr( "WARNING: improper mud_fail() in file '$file'.\n" );

    }
  }

  function check_constructor() {

    $file_list = mud_get_file_list( '.', '/^.+\.php$/' );

    foreach ( $file_list as $file ) {

      if ( $this->is_file_ignored( $file ) ) { continue; }

      //echo "processing '$file'...\n";

      $code = file_get_contents( $file );

      if ( ! preg_match( '/function __construct/', $code ) ) { continue; }

      if ( preg_match( '/parent::__construct/', $code ) ) { continue; }

      mud_stderr( "WARNING: parent constructor not called '$file'.\n" );

    }
  }

  function process_errors( $module_const_list ) {

    $const_map = [];

    $file_list = mud_get_file_list( '.', '/^.+\.php$/' );

    foreach ( $file_list as $file ) {

      if ( $this->is_file_ignored( $file ) ) { continue; }

      $code = file_get_contents( $file );

      if ( ! preg_match_all( "/mud_define_error\(\s*'([^']+)/", $code, $matches ) ) { continue; }

      $module_const = $this->get_module_const_from_path( $file );

      foreach ( $matches[ 1 ] as $error_const ) {

        if ( $this->is_error_const_ignored( $error_const ) ) { continue; }

        if ( array_key_exists( $error_const, $const_map ) ) {

          $file_a = $const_map[ $error_const ];
          $file_b = $file;

          mud_stderr( "WARNING: const '$error_const' declared twice:\n" );
          mud_stderr( "  file A: $file_a\n" );
          mud_stderr( "  file B: $file_b\n" );

        }
        else {

          $expected_error_const_prefix = "MUD_ERR_{$module_const}_";

          if ( strpos( $error_const, $expected_error_const_prefix ) !== 0 ) {

            mud_stderr( "WARNING: invalid prefix for '$error_const' expected '$module_const'.\n" );

          }

          $const_map[ $error_const ] = $file;

        }
      }
    }

    $const_count = [];

    foreach ( $const_map as $error_const => $file ) {

      $const_count[ $error_const ] = 0;

    }

    foreach ( $file_list as $file ) {

      if ( $this->is_file_ignored( $file ) ) { continue; }

      $code = file_get_contents( $file );

      if ( ! preg_match_all( '/[^\'"](MUD_ERR_[A-Z0-9_]+)/', $code, $matches ) ) { continue; }

      foreach ( $matches[ 1 ] as $error_const ) {

        if ( $this->is_error_const_ignored( $error_const ) ) { continue; }

        if ( ! array_key_exists( $error_const, $const_count ) ) {

          $this->error( "undefined error const '$error_const' used in '$file'.\n", MUD_TOOL_EXIT_UNDEFINED );

        }

        $const_count[ $error_const ]++;

      }
    }

    foreach ( $const_count as $error_const => $count ) {

      if ( $this->is_error_const_ignored( $error_const ) ) { continue; }

      if ( $count !== 0 ) { continue; }

      $file = $const_map[ $error_const ];

      mud_stderr( "WARNING: unused error const defined in '$file' for '$error_const' seen $count.\n" );

    }
  }

  function is_file_ignored( $file ) {

    if ( preg_match( '|/archive/|', $file ) ) { return true; }

    if ( preg_match( '|/class-old/|', $file ) ) { return true; }

    return false;

  }

  function is_error_const_ignored( $error_const ) {

    // 2021-04-12 jj5 - these are special case things which we can ignore...

    static $ignore_list = [
      'MUD_ERR_SUCCESS',
      'MUD_ERR_GENERAL', 'MUD_ERR_NOT_IMPLEMENTED', 'MUD_ERR_NOT_SUPPORTED', 'MUD_ERR_REQUIREMENT_VIOLATED',
      'MUD_ERR_EXAMPLE',
    ];

    foreach ( $ignore_list as $ignore ) {

      if ( strpos( $error_const, $ignore ) === 0 ) { return true; }

    }

    return false;

  }

  function get_module_const_from_path( $path ) {

    if ( preg_match( '%module/\d-(critical|basic|data|web|app|tool)/\d\d\d-([^/]+)/%', $path, $matches ) ) {

      return strtoupper( $matches[ 2 ] );

    }

    return false;

  }
}
