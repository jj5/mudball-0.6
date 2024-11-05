<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-09 jj5 - class definition...
//

class MudModuleExit extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - private fields...
  //

  private array $exit_map = [];

  private array $name_map = [];

  private int|null $error_level = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - destructor...
  //

  public function __destrcut() {

    if ( mud_is_dev() ) {

      $this->save_exit_constants();

    }

    if ( method_exists( parent::class, '__destruct' ) ) {

      parent::__destruct();

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - public methods...
  //

  public function define_exit( string $name, int $code, string $category, string $description, string|null $hint = null ) {

    if ( ! $name ) {

      mud_fail( MUD_ERR_EXIT_NAME_IS_REQUIRED );

    }

    if ( array_key_exists( $name, $this->name_map ) ) {

      mud_fail( MUD_ERR_EXIT_NAME_IS_DUPLICATE, [ 'name' => $name ] );

    }

    if ( $code > 255 ) {

      mud_fail(
        MUD_ERR_EXIT_LIMIT_EXCEEDED,
        [
          'code' => $code,
        ]
      );

    }

    $this->add_exit( $name, $code, $category, $description, $hint );

  }

  public function abort( string $message ) {

    try {

      error_reporting( 0 );

      mud_stderr( "$message\n" );

    }
    catch ( Throwable $ex ) { ; }

    mud_exit( MUD_EXIT_ABORT );

  }

  public function exit( $code_or_name ) {

    $this->read_exit_info( $code_or_name, $code, $name );

    $this->error_level = $code;

    exit( $code );

  }

  public function get_exit_error_level() {

    return $this->error_level;

  }

  public function get_code( $code_or_name ) {

    $this->read_exit_info( $code_or_name, $code, $name );

    return $code;

  }

  public function get_name( $code_or_name ) {

    $this->read_exit_info( $code_or_name, $code, $name );

    return $name;

  }


  public function generate_bash() {

    $map = [];
    $max_len = 0;

    foreach ( $this->exit_map as $code => $spec ) {

      $const = preg_replace( '/^MUD_/', 'LX_', $spec[ 'name' ] );

      $map[ $const ] = $code;

      $max_len = max( strlen( $const ), $max_len );

    }

    $pad = $max_len + 5;

    echo "#!/bin/bash\n";
    echo "# 2024-02-09 jj5 - SEE: https://www.jj5.net/wiki/error_levels\n";
    foreach ( $map as $const => $code ) {

      $category = $this->exit_map[ $code ][ 'category' ];
      $description = $this->exit_map[ $code ]['description'];
      $hint = $this->exit_map[ $code ][ 'hint' ];

      if ( $code === 0 ) {

        echo str_pad( "$const=$code", $pad," ", STR_PAD_RIGHT ) . " # success!\n";

      }
      else {

        echo str_pad( "$const=$code", $pad," ", STR_PAD_RIGHT ) . " # $category: $description";

        if ( $hint ) { echo ": $hint"; }

        echo "\n";

      }
    }
  }

  public function generate_php() {

    echo "<?php\n\n";
    echo "// 2024-02-09 jj5 - SEE: https://www.jj5.net/wiki/error_levels\n\n";

    foreach ( $this->exit_map as $code => $spec ) {

      $name = preg_replace( '/^MUD_/', 'LX_', $spec[ 'name' ] );

      echo "define( '$name', $code );\n";

    }
?>

function my_exit( int|string|Throwable $argument = EXIT_SUCCESS, bool $print_error = true, bool|null $print_hint = null ) {

  // if $argument is an int it is treated as an error code

  // if $argument is a string it is treated as an error message and EXIT_ABORT is used

  // if $argument is some type of Throwable an appropriate error level is determined

  // if $print_error is true an error message is logged

  // if $print_hint is true a hint for the programmer concerning other possibly related codes is printed

  // the DEBUG constant can influence the behaviour of this function, see the code for details

  if (
    $argument === EXIT_SUCCESS          ||
    $argument === EXIT_SPECIAL_SUCCESS  ||
    $argument === EXIT_OPTIONS_LISTED   ||
    $argument === EXIT_HELP
  ) {

    // shortcircuit the "success" cases which don't need an error message

    exit( $argument );

  }

  $is_debug = defined( 'DEBUG' ) && DEBUG;

  if ( $print_hint === null ) {

    $print_hint = $is_debug;

  }

  static $map = [
<?php

    foreach ( $this->exit_map as $code => $spec ) {

      $const = preg_replace( '/^MUD_/', '', $spec[ 'name' ] );

      $name = json_encode( $const, JSON_UNESCAPED_SLASHES );
      $category = json_encode( $spec[ 'category' ], JSON_UNESCAPED_SLASHES );
      $description = json_encode( $spec[ 'description' ], JSON_UNESCAPED_SLASHES );
      $hint = json_encode( $spec[ 'hint' ], JSON_UNESCAPED_SLASHES );

      echo "     $const => [\n";
      echo "       'code'         => $code,\n";
      echo "       'name'         => $name,\n";
      echo "       'category'     => $category,\n";
      echo "       'description'  => $description,\n";

      if ( $spec[ 'hint' ] ) {

        echo "       'hint'         => $hint,\n";

      }

      echo "     ],\n";

    }
?>
  ];

  if ( is_int( $argument ) ) {

    $spec = $map[ $argument ] ?? $map[ EXIT_INVALID ];

  }
  elseif ( is_string( $argument ) ) {

    error_log( $argument );

    $spec = $map[ EXIT_ABORT ];

  }
  elseif ( $argument instanceof ErrorException ) {

    $spec = $map[ EXIT_ERROR ];

  }
  elseif ( $argument instanceof AssertionError ) {

    $spec = $map[ EXIT_ASSERT ];

  }
  elseif ( $argument instanceof Throwable ) {

    $spec = $map[ EXIT_EXCEPTION ];

  }
  else {

    $spec = $map[ EXIT_INVALID ];

  }

  $code = $spec[ 'code' ];

  if ( $print_error ) {

    $name = $spec[ 'name' ];
    $category = $spec[ 'category' ];
    $description = $spec[ 'description' ];
    $hint = $spec[ 'hint' ] ?? null;

    if ( $hint && $print_hint ) {

      error_log( "hint: $hint" );

    }

    if ( $is_debug ) {

      error_log( "$category: $description ($name)" );

    }
    else {

      error_log( "$category: $description" );

    }
  }

  exit( $code );

}
<?php

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - protected methods...
  //

  protected function save_exit_constants() {

    $this->save_constant_map( $this->exit_map );

  }

  protected function add_exit( string $name, int $code, string $category, string $description, string|null $hint ) {

    define( $name, $code );

    $this->exit_map[ $code ] = [
      'code' => $code,
      'name' => $name,
      'category'=> $category,
      'description' => $description,
      'hint' => $hint,
    ];

    $this->name_map[ $name ] = $code;

  }

  protected function read_exit_info(
    $code_or_name,
    &$code,
    &$name,
    &$message = null
  ) {

    if ( isset( $this->exit_map[ $code_or_name ] ) ) {

      $code = intval( $code_or_name );
      $name = $this->exit_map[ $code ][ 'name' ];
      $message = "exit while processing: {$name}";

    }
    else {

      $code = MUD_EXIT_ABORT;
      $name = 'MUD_EXIT_ABORT';
      $message = strval( $code_or_name );

    }
  }
}
