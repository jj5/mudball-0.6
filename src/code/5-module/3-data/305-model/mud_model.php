<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - include dependencies...
//

require_once __DIR__ . '/../300-data/mud_data.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - module errors...
//

//mud_define_error( 'MUD_ERR_MODEL_WHATEVER', 'some error occurred.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - include components...
//

require_once __DIR__ . '/0-module/MudModuleModel.php';

mud_load_deep_breadth_first( __DIR__ . '/1-schema' );
mud_load_deep_breadth_first( __DIR__ . '/2-model' );
mud_load_deep_breadth_first( __DIR__ . '/3-specific' );
mud_load_deep_breadth_first( __DIR__ . '/5-load' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - functional interface...
//

function mud_model_load( string $model_namespace, string $model_name, string $path ) {

  return mud_module_model()->load( $model_namespace, $model_name, $path );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - service locator...
//
//

function mud_module_model() : MudModuleModel {

  return mud_locator()->get_module( MudModuleModel::class );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - global accessors...
//
//

function mud_model_version() : MudModelVersionBuilder {

  global $g_mud_model_version;

  return $g_mud_model_version;

}
