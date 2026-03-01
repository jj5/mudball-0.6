<?php

class MudSchemaIdxDef extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public fields...
  //

  public $file_info;

  public $file;
  public $line;

  public $idx_name;
  public $idx_type;

  public $col_name_list;

  public $col_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - constructor...
  //

  public function __construct(
    $file_info,
    $file,
    $line,
    $idx_name,
    $idx_type,
    $col_name_list,
  ) {

    parent::__construct();

    $this->file_info = $file_info;

    $this->file = $file;
    $this->line = $line;

    $this->idx_name = $idx_name;
    $this->idx_type = $idx_type;

    $this->col_name_list = $col_name_list;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public methods...
  //

  public function get_name() { return $this->idx_name; }
  public function get_type() { return $this->idx_type; }

  public function create_idx( $tab ) {

    $schemata = $tab->schemata;

    $info = $this->file_info;

    $schema = $info[ 'schema' ];
    $revision = $info[ 'revision' ];
    $revision_number = $info[ 'revision_number' ];
    $revision_file = MudSchemata::GetRelativePath( $info[ 'path' ] );
    $file = MudSchemata::GetRelativePath( $this->file );

    $idx = new_mud_schema_idx(
      $schemata,
      $tab,
      $schema,
      $revision,
      $revision_number,
      $revision_file,
      $file,
      $this->line,
      $this->idx_name,
      $this->idx_type,
      $this->col_name_list
    );

    if ( array_key_exists( $idx->get_name(), $tab->idx_map ) ) {

      mud_fail( MUD_ERR_SCHEMADEF_DUPLICATE_INDEX, [ 'idx_name' => $idx->get_name() ] );

    }

    $tab->idx_map[ $idx->get_name() ] = $idx;

    /*
    if ( ! array_key_exists( $idx->get_name(), $schemata->idx_map ) ) {

      $schemata->idx_map[ $idx->get_name() ] = $idx;

    }
    */

    return $idx;

  }
}
