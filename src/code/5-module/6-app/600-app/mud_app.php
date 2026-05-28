<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - include dependencies...
//

require_once __DIR__ . '/../../5-api/599-top/include.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/AppModule.php';
require_once __DIR__ . '/class/AppModuleView.php';
require_once __DIR__ . '/class/AppRequest.php';


function app_declare_database() {

  $std = mud_declare_schema( 'std', 'mudballdb', __DIR__ . '/../../../../code/6-schema/mudballdb' );
  $bus = mud_declare_schema( 'bus', 'demodb', __DIR__ . '/../../../../code/6-schema/demodb' );

  $db = mud_declare_database( [ $std, $bus ] );

  mud_set_database( $db );

  return $db;

}
