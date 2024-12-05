<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - class definition...
//

class MudModuleSchemadef extends MudModuleData {


<<<<<<< HEAD
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleSchemadef|null $previous = null) {

    parent::__construct( $previous );

  }


>>>>>>> e3a066e (Work, work...)
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_schema_def() {

<<<<<<< HEAD
    return MudSchemaDef::Create();
=======
    return new MudSchemaDef();
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_schema_tab_def( $file_info, $file, $line, $tab_name, $tab_type ) {

<<<<<<< HEAD
    return MudSchemaTabDef::Create( $file_info, $file, $line, $tab_name, $tab_type );
=======
    return new MudSchemaTabDef( $file_info, $file, $line, $tab_name, $tab_type );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_schema_col_def(
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

<<<<<<< HEAD
    return MudSchemaColDef::Create(
=======
    return new MudSchemaColDef(
>>>>>>> e3a066e (Work, work...)
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

  public function new_mud_schema_idx_def(
    $file_info,
    $file,
    $line,
    $idx_name,
    $idx_type,
    $col_name_list,
  ) {

<<<<<<< HEAD
    return MudSchemaIdxDef::Create(
=======
    return new MudSchemaIdxDef(
>>>>>>> e3a066e (Work, work...)
      $file_info,
      $file,
      $line,
      $idx_name,
      $idx_type,
      $col_name_list,
    );

  }
}
