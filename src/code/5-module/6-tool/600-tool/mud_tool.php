<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - include dependencies...
//

require_once __DIR__ . '/../../5-app/599-top/include.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - module constants...
//

// 2022-02-23 jj5 - TODO: these defines should use the mud exit facility

// 2021-03-22 jj5 - these are various error levels... add new levels at end to preserve the API...
//
define( 'MUD_TOOL_EXIT_WRONG_DIR',       1 );
define( 'MUD_TOOL_EXIT_UNKNOWN_ARG',     2 );
define( 'MUD_TOOL_EXIT_UNKNOWN_TEST',    3 );
define( 'MUD_TOOL_EXIT_INVALID_TARGET',  4 );
define( 'MUD_TOOL_EXIT_INVALID_CONFIG',  5 );
define( 'MUD_TOOL_EXIT_CANT_READ',       6 );
define( 'MUD_TOOL_EXIT_CANT_CLOSE',      7 );
define( 'MUD_TOOL_EXIT_EXCEPTION',       8 );
define( 'MUD_TOOL_EXIT_UNDEFINED',       9 );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleTool.php';
require_once __DIR__ . '/class/MudTool.php';
