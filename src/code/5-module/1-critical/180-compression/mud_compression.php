<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../170-temp/mud_temp.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleCompression.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//
//

function mud_zlob_encode( $data, int $level = 9 ) {

  return mud_module_compression()->zlob_encode( $data, $level );

}

function mud_zlob_decode( string $zlob ) {

  return mud_module_compression()->zlob_decode( $zlob );

}


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_compression() : MudModuleCompression {

  return mud_locator()->get_module( MudModuleCompression::class );

}
