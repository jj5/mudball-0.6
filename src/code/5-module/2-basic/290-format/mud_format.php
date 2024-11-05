<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - include dependencies...
//

// 2024-07-01 jj5 - FIXME: we skip over the 'null' module here because it has been moved into the 'object' module...
require_once __DIR__ . '/../280-stats/mud_stats.php';
//require_once __DIR__ . '/../285-null/mud_null.php';

/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_FORMAT_INVALID_REVISION_FORMAT', 'revision format is invalid.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleFormat.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - functional interface...
//

function mud_format_as_revision_code( $input ) {

  return mud_module_format()->format_as_revision_code( $input );

}

function mud_format_as_revision_number( $input ) {

  return mud_module_format()->format_as_revision_number( $input );

}

function mud_format_action( string $action, array $args = [] ) {

  return mud_module_format()->format_action( $action, $args );

}

function mud_format_headers( array $header_map ) {

  return mud_module_format()->format_headers( $header_map );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_format() : MudModuleFormat {

  return mud_locator()->get_module( MudModuleFormat::class );

}
