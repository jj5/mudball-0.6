<?php

// 2022-03-06 jj5 - this module loads all the 'action' and 'facility' PHP code into a single
// process just to make sure that it all works together as expected without conflicts.


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - include dependencies...
//

require_once __DIR__ . '/../610-tool/mud_tool.php';

require_once __DIR__ . '/../../../../../../../src/code/1-bootstrap/9-keystone.php';

require_once __DIR__ . '/../615-codegen/mud_codegen.php';
require_once __DIR__ . '/../620-linter/mud_linter.php';
require_once __DIR__ . '/../625-dbadmin/mud_dbadmin.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_TESTLOAD_INVALID_CLASS', 'object must be of appropriate class.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - module constants...
//

define( 'APP_OBJECT_TYPE_ACTION', 0 );
define( 'APP_OBJECT_TYPE_FACILITY', 1 );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudTestload.php';
