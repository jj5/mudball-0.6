<?php

// 2022-05-23 jj5 - NOTE: this is a bit of a hack job, technically this module relies on the
// 'facility' and 'action' modules which aren't loaded until much later, but if you don't use
// this module until after they're loaded you won't have a problem. :P

// 2024-02-07 jj5 - TODO: this module needs to be relocated somewhere better, see above.


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-05-23 jj5 - include dependencies...
//

require_once __DIR__ . '/../290-format/mud_format.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-05-23 jj5 - module errors...
//

//mud_define_error( 'MUD_ERR_LOADER_...', '...' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-05-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleLoader.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-05-23 jj5 - functional interface...
//

function mud_load_facility( $request_path_parts, &$selector ) {

  return mud_module_loader()->load_facility( $request_path_parts, $selector );

}

function mud_load_processor( string $action_input, &$action_code = null, &$action_args = null ) {

  return mud_module_loader()->load_processor( $action_input, $action_code, $action_args );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_loader() : MudModuleLoader {

  return mud_locator()->get_module( MudModuleLoader::class );

}
