<?php


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2024-02-07 jj5 - class definition...
//

class MudModuleDebug extends MudModule {


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleDebug|null $previous = null) {

    parent::__construct( $previous );

  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2021-10-19 jj5 - public interface...
  //

  public static function dump( mixed $input ) : void {

    while ( ob_get_level() ) { ob_end_clean(); }

    var_dump( $input );
<<<<<<< HEAD

=======
    
>>>>>>> e3a066e (Work, work...)
    mud_exit( 1 );

  }

  public function require( bool $assertion, string $statement, mixed $data = null ) : void {

<<<<<<< HEAD
    if ( $assertion )  return;
=======
    if ( $assertion )  return; 
>>>>>>> e3a066e (Work, work...)

    $context = [
      'statement' => $statement,
      'data' => $data,
    ];

    mud_fail( MUD_ERR_REQUIREMENT_VIOLATED, $context );

  }
}
