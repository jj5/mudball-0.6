<?php

// 2022-02-22 jj5 - TODO: this tool needs to be reviewed.

// 2022-02-23 jj5 - this tool is to check for things which probably shouldn't be in the code and
// report on them.

// 2022-02-23 jj5 - TODO: find constructors which don't call their parents.

// 2022-02-23 jj5 - TODO: find comment banners which aren't 98 slashes long.

// 2022-02-23 jj5 - TODO: find two consecutive '//' lines

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-22 jj5 - include dependencies...
//

require_once __DIR__ . '/../600-tool/mud_tool.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudLinter.php';
