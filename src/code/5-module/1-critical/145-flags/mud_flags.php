<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../140-directory/mud_directory.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleFlags.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//
//

function mud_has_flag( $flags, int $flag ) : bool {

  return mud_module_flags()->has_flag( $flags, $flag );

}

function mud_set_flag( $flags, int $flag, bool $set = true ) : int {

  return mud_module_flags()->set_flag( $flags, $flag, $set );

}


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_flags() : MudModuleFlags {

  return mud_locator()->get_module( MudModuleFlags::class );

}
