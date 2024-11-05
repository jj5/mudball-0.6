<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - include dependencies...
//

require_once __DIR__ . '/../1-bootstrap/4-config.php';

require_once __DIR__ . '/base/class/MudEnum.php';
require_once __DIR__ . '/base/class/MudFlags.php';

require_once __DIR__ . '/base/trait/MudEnumTraits.php';
require_once __DIR__ . '/base/trait/AppEnumTraits.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - load library enums...
//

mud_load_enums( __DIR__ . '/enum' );

mud_load_enums( __DIR__ . '/flags' );

function mud_load_enums( $dir ) {

  $dir = realpath( $dir );

  assert( is_dir( $dir ) );

  foreach ( scandir( $dir, SCANDIR_SORT_ASCENDING ) as $enum_definition ) {

    $path = "$dir/$enum_definition";

    if ( is_file( $path ) ) { require_once $path; }

  }
}
