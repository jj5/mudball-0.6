<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - include dependencies...
//

require_once __DIR__ . '/../325-schemata/mud_schemata.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_SCHEMADEF_DUPLICATE_COLUMN', 'duplicate column.' );
mud_define_error( 'MUD_ERR_SCHEMADEF_DUPLICATE_INDEX', 'duplicate index.' );
mud_define_error( 'MUD_ERR_SCHEMADEF_INVALID_NAME', 'invalid name.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/1-MudSchemaDef.php';
require_once __DIR__ . '/class/2-MudSchemaTabDef.php';
require_once __DIR__ . '/class/3-MudSchemaColDef.php';
require_once __DIR__ . '/class/4-MudSchemaIdxDef.php';
require_once __DIR__ . '/class/9-MudModuleSchemadef.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_schema_def() {

  return mud_module_schemadef()->new_mud_schema_def();

}

function new_mud_schema_tab_def( $file_info, $file, $line, $tab_name, $tab_type ) {

  return mud_module_schemadef()->new_mud_schema_tab_def( $file_info, $file, $line, $tab_name, $tab_type );

}

function new_mud_schema_col_def(
  $file_info,
  $file,
  $line,
  $col_name,
  $col_type,
  $is_key,
  $is_vrt,
  $is_ref,
  $is_flg,
  $is_dup,
  $is_unique,
  $is_fk,
  $min,
  $max,
  $nullable,
  $default,
  $valid,
  $invalid,
  $ref_tab_name,
  $ref_col_name,
  $flag,
  $is_interaction_id,
) {

  return mud_module_schemadef()->new_mud_schema_col_def(
    $file_info,
    $file,
    $line,
    $col_name,
    $col_type,
    $is_key,
    $is_vrt,
    $is_ref,
    $is_flg,
    $is_dup,
    $is_unique,
    $is_fk,
    $min,
    $max,
    $nullable,
    $default,
    $valid,
    $invalid,
    $ref_tab_name,
    $ref_col_name,
    $flag,
    $is_interaction_id,
  );

}

function new_mud_schema_idx_def(
  $file_info,
  $file,
  $line,
  $idx_name,
  $idx_type,
  $col_name_list,
) {

  return mud_module_schemadef()->new_mud_schema_idx_def(
    $file_info,
    $file,
    $line,
    $idx_name,
    $idx_type,
    $col_name_list,
  );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//

function mud_module_schemadef() : MudModuleSchemadef {

  return mud_locator()->get_module( MudModuleSchemadef::class );

}
