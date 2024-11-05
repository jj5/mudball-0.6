<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../160-array/mud_array.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleConfig.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - functional interface...
//
//

function mud_get_config( array $path, $default = null, &$result = null ) {

  return mud_module_config()->get_config( $path, $default, $result );

}


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - service locator...
//
//

function mud_module_config() : MudModuleConfig {

  return mud_locator()->get_module( MudModuleConfig::class );

}
