<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-05 jj5 - include dependencies...
//

require_once __DIR__ . '/../615-action/mud_action.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-09-05 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_HOST_INCLUDE_NOT_A_FACILITY', 'include is not a facility.' );
mud_define_error( 'MUD_ERR_HOST_UNAUTHORIZED', 'unauthorized access.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudController.php';

require_once __DIR__ . '/class/MudController.php';
require_once __DIR__ . '/class/MudControllerWeb.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-10-21 jj5 - service locator...
//

function mud_controller( MudController|false $set = false ) : MudController {

  return mud_locator()->manage_service( MudController::class, $set );

}
