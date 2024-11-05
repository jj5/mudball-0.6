<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - include dependencies...
//

require_once __DIR__ . '/../125-buffer/mud_buffer.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleInput.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - service locator...
//
//

function mud_module_input() : MudModuleInput {

  return mud_locator()->get_module( MudModuleInput::class );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - functional interface...
//
//

function mud_read_acord( mixed $input, string|null $default = '' ) : string|null {

  return mud_module_input()->read_acord( $input );

}

function mud_read_ucord( mixed $input, string|null $default = '' ) : string|null {

  return mud_module_input()->read_ucord( $input );

}

function mud_read_atext( mixed $input, string|null $default = '' ) : string|null {

  return mud_module_input()->read_atext( $input );

}

function mud_read_utext( mixed $input, string|null $default = '' ) : string|null {

  return mud_module_input()->read_utext( $input );

}
