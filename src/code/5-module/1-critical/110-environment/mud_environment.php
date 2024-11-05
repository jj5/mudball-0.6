<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../100-critical/mud_critical.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleEnvironment.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - functional interface...
//

function mud_is_cli() : bool {

  return mud_module_environment()->is_cli();

}

function mud_is_web() : bool {

  return mud_module_environment()->is_web();

}

function mud_is_posix() : bool {

  return mud_module_environment()->is_posix();

}

function mud_is_windows() : bool {

  return mud_module_environment()->is_windows();

}

function mud_get_username() : string|null {

  return mud_module_environment()->get_username();

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locator...
//

function mud_module_environment( MudModuleEnvironment|false $set = false ) : MudModuleEnvironment {

  return mud_locator()->manage_module( MudModuleEnvironment::class, $set );

}
