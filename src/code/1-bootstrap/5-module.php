<?php

require_once __DIR__ . '/4-config.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - load main modules...
//

mud_load_modules( __DIR__ . '/../5-module/1-critical' );

mud_load_modules( __DIR__ . '/../5-module/2-basic' );

mud_load_modules( __DIR__ . '/../5-module/3-data' );

mud_load_modules( __DIR__ . '/../5-module/4-web' );

mud_load_modules( __DIR__ . '/../5-module/5-app' );
