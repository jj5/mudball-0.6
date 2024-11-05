<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-08 jj5 - include dependencies...
//

require_once __DIR__ . '/../500-app/mud_app.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_ACTION_INVALID_PART', 'invalid action part.' );
mud_define_error( 'MUD_ERR_ACTION_INVALID_PROCESSOR', 'invalid action processor.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudAction.php';

require_once __DIR__ . '/class/MudModuleAction.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-10 jj5 - functional interface...
//

function mud_get_action_category( $action ) {

  return mud_module_action()->get_action_category( $action );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_action() : MudModuleAction {

  return mud_locator()->get_module( MudModuleAction::class );

}
