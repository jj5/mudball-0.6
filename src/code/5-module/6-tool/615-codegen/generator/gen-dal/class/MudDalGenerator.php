<?php

class MudDalGenerator extends MudGenerator {


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-02-22 jj5 - protected fields...
  //

  protected $verbose = true;
  protected $debug = false;
  protected $script_path = null;
  protected $target = null;


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-02-22 jj5 - public methods...
  //

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

    $this->script_path = array_shift( $argv );

    $this->script_path = realpath( $this->script_path );

    $this->target = array_shift( $argv );

    if ( ! is_dir( $this->target ) ) {

      $this->error( 'invalid target.', MUD_TOOL_EXIT_INVALID_TARGET );

    }

    chdir( $this->target );

    echo getcwd() . "\n";

    while ( $arg = array_shift( $argv ) ) {

      switch ( $arg ) {

        case '--debug'    : $this->debug    = true;   break;
        case '--verbose'  : $this->verbose  = true;   break;
        case '--quiet'    : $this->verbose  = false;  break;

        default :

          $this->value_error( 'unsupported argument', $arg, MUD_TOOL_EXIT_UNKNOWN_ARG );

      }
    }

    $schemata = MudSchemata::Load( $use_cache = false );

    //
    // 2021-03-29 jj5 - do our code generation...
    //

    $file_list = [];

    $this->gen_consts( $schemata, $file_list );

    $this->gen_validation( $schemata, $file_list );

    $traits_list = [];

    $this->gen_traits( $schemata, $traits_list, $file_list );

    $this->gen_class( $traits_list, $file_list );

    $this->gen_include( $file_list );

  }

  public function print_header() {

    static $path = null;

    if ( $path === null ) {

      $path = preg_replace( '|.*/bin/|', 'bin/', $this->script_path );

    }

    echo "<?php\n";

?>

  //
  // this file generated by <?= "$path\n" ?>
  //

<?php

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-02-22 jj5 - public methods...
  //

  public function get_path( $file_name ) {

    return $this->target . '/' . $file_name;

  }

  public function get_generated_by( $path, $line ) {

    $base = realpath( __DIR__ . '/../../../../../../../../../../' );

    $file = substr( $path, strlen( $base ) + 1 );

    return "$file:$line\n";

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-02-22 jj5 - protected methods...
  //

  protected function gen_consts( $schemata, &$file_list ) {

    static $generator = null;

    if ( $generator === null ) { $generator = new MudDalConstGenerator( $this ); }

    return $generator->gen_consts( $schemata, $file_list );

  }

  protected function gen_validation( $schemata, &$file_list ) {

    static $generator = null;

    if ( $generator === null ) { $generator = new MudDalValidationGenerator( $this ); }

    return $generator->gen_validation( $schemata, $file_list );

  }

  protected function gen_traits( $schemata, &$traits_list, &$file_list ) {

    static $generator = null;

    if ( $generator === null ) { $generator = new MudDalTraitsGenerator( $this ); }

    return $generator->gen_traits( $schemata, $traits_list, $file_list );

  }

  protected function gen_class( $traits_list, &$file_list ) {

    static $generator = null;

    if ( $generator === null ) { $generator = new MudDalClassGenerator( $this ); }

    return $generator->gen_class( $traits_list, $file_list );

  }

  protected function gen_include( $file_list ) {

    static $generator = null;

    if ( $generator === null ) { $generator = new MudDalIncludeGenerator( $this ); }

    return $generator->gen_include( $file_list );

  }
}
