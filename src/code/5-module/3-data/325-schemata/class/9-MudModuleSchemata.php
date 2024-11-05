<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - class definition...
//

class MudModuleSchemata extends MudModuleData {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleSchemata|null $previous = null) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_schemata( array $rev_map ) {

    return new MudSchemata( $rev_map );

  }

  public function new_mud_schema_tab(
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

    return new MudSchemaTab(
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

  public function new_mud_schema_col(
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

    return new MudSchemaCol(
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

  public function new_mud_schema_idx(
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

    return new MudSchemaIdx(
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

  public function new_mud_schema( $schemata = null ) {

    return new MudSchema( $schemata );

  }

}
