<?php


/////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - include dependencies...
//

require_once __DIR__ . '/../115-exit/mud_exit.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleDebug.php';


/////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - functional interface...
//

function mud_dump( mixed $data ) : void {

  mud_module_debug()->dump( $data );

}

function mud_require( bool $assertion, string $statement, mixed $data = null ) : void {
  
  mud_module_debug()->require( $assertion, $statement, $data );

}


/////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - service locator...
//

function mud_module_debug() : MudModuleDebug {

  return mud_locator()->get_module( MudModuleDebug::class );

}
