<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - class definition...
//

class MudModuleDebug extends MudModule {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-19 jj5 - public interface...
  //

  public static function dump( mixed $input ) : void {

    while ( ob_get_level() ) { ob_end_clean(); }

    var_dump( $input );

    mud_exit( 1 );

  }

  public function require( bool $assertion, string $statement, mixed $data = null ) : void {

    if ( $assertion )  return;

    $context = [
      'statement' => $statement,
      'data' => $data,
    ];

    mud_fail( MUD_ERR_REQUIREMENT_VIOLATED, $context );

  }
}
