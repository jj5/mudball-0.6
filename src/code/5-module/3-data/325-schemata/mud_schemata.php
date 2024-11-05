<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - include dependencies...
//

require_once __DIR__ . '/../320-sqlite/mud_sqlite.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_INVALID', 'field is invalid.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NULL', 'field is null.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_INVALID_BOOLEAN', 'field is invalid boolean.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NOT_INTEGER', 'field is not integer.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NOT_FLOAT', 'field is not float.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NOT_STRING', 'field is not string.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NOT_VALID_UTF8', 'field is not valid UTF-8.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_VALUE', 'field is below minimum value.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_LENGTH', 'field is below minimum length.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_VALUE', 'field is above maximum value.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_LENGTH', 'field is above maximum length.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_NOT_IN_VALID_FORMAT', 'field is not in valid format.' );
mud_define_error( 'MUD_ERR_SCHEMATA_FIELD_IS_IN_AN_INVALID_FORMAT', 'field is in an invalid format.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/1-MudSchemata.php';
require_once __DIR__ . '/class/2-MudSchemaTab.php';
require_once __DIR__ . '/class/3-MudSchemaCol.php';
require_once __DIR__ . '/class/4-MudSchemaIdx.php';
require_once __DIR__ . '/class/8-MudSchema.php';
require_once __DIR__ . '/class/9-MudModuleSchemata.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_schemata( array $rev_map ) {

  return mud_module_schemata()->new_mud_schemata( $rev_map );

}

function new_mud_schema_tab(
  $schemata,
  $schema,
  $revision,
  $revision_number,
  $revision_file,
  $file,
  $line,
  $tab_name,
  $tab_type,
  $connection_type,
  $is_cacheable,
  $const,
) {

  return mud_module_schemata()->new_mud_schema_tab(
    $schemata,
    $schema,
    $revision,
    $revision_number,
    $revision_file,
    $file,
    $line,
    $tab_name,
    $tab_type,
    $connection_type,
    $is_cacheable,
    $const,
  );

}

function new_mud_schema_col(
  $schemata,
  $tab,
  $schema,
  $revision,
  $revision_number,
  $revision_file,
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
  $ref_col,
  $flag,
  $db_datatype,
  $app_datatype,
  $prop,
  $const,
  $cast_function,
  $is_ascii,
  $is_unicode,
  $is_binary,
  $string_type,
  $is_interaction_id,
  $is_auto_inc,
  $is_auto,
  $classes,
  $human_name,
) {

  return mud_module_schemata()->new_mud_schema_col(
    $schemata,
    $tab,
    $schema,
    $revision,
    $revision_number,
    $revision_file,
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
    $ref_col,
    $flag,
    $db_datatype,
    $app_datatype,
    $prop,
    $const,
    $cast_function,
    $is_ascii,
    $is_unicode,
    $is_binary,
    $string_type,
    $is_interaction_id,
    $is_auto_inc,
    $is_auto,
    $classes,
    $human_name,
  );

}

function new_mud_schema_idx(
  $schemata,
  $tab,
  $schema,
  $revision,
  $revision_number,
  $revision_file,
  $file,
  $line,
  $idx_name,
  $idx_type,
  $col_name_list,
) {

  return mud_module_schemata()->new_mud_schema_idx(
    $schemata,
    $tab,
    $schema,
    $revision,
    $revision_number,
    $revision_file,
    $file,
    $line,
    $idx_name,
    $idx_type,
    $col_name_list,
  );

}

function new_mud_schema( $schemata = null ) {

  return mud_module_schemata()->new_mud_schema( $schemata );

}


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-21 jj5 - functional interface...
//

function mud_validate( $col_name, $value ) {

  return mud_schemata()->validate( $col_name, $value );

}

function mud_get_db_value( $col_name, $value ) {

  return mud_schemata()->get_db_value( $col_name, $value );

}

function mud_schemata() {

  static $schemata = null;

  if ( $schemata === null ) {

    $schemata = MudSchemata::Load();

  }

  return $schemata;

}


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//

function mud_module_schemata() : MudModuleSchemata {

  return mud_locator()->get_module( MudModuleSchemata::class );

}
