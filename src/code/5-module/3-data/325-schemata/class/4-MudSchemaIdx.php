<?php

class MudSchemaIdx extends MudGadget {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public fields...
  //

  public $schemata;
  public $tab;
  public $schema;
  public $revision;
  public $revision_number;
  public $revision_file;
  public $file;
  public $line;

  public $tab_name;
  public $tab_type;

  public $idx_name;
  public $idx_type;

  public $col_name_list;

  public $col_map = [];


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - JsonSerializable interface...
  //

  public function jsonSerialize(): mixed {

    return [
      //'schemata', => $this->schemata,
      //'tab' => $this->tab,
      'schema' => $this->schema,
      'revision' => $this->revision,
      'revision_number' => $this->revision_number,
      'revision_file' => $this->revision_file,
      'file' => $this->file,
      'line' => $this->line,
      'tab_name' => $this->tab_name,
      'tab_type' => $this->tab_type,
      'idx_name' => $this->idx_name,
      'idx_type' => $this->idx_type,
      'col_name_list' => $this->col_name_list,
      'col_map' => $this->col_map,
    ];

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - constructor...
  //

  public function __construct(
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
    $col_name_list
  ) {

    parent::__construct();

    $this->schemata = $schemata;
    $this->tab = $tab;
    $this->schema = $schema;
    $this->revision = $revision;
    $this->revision_number = $revision_number;
    $this->revision_file = $revision_file;
    $this->file = $file;
    $this->line = $line;

    $this->tab_name = $tab->tab_name;
    $this->tab_type = $tab->tab_type;

    $this->idx_name = $idx_name;
    $this->idx_type = $idx_type;

    $this->col_name_list = $col_name_list;

    foreach ( $col_name_list as $col_name ) {

      $this->col_map[ $col_name ] = $tab->col_map[ $col_name ];

    }
  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public methods...
  //

  public function get_schemata() { return $this->schemata; }
  public function get_tab() { return $this->tab; }
  public function get_schema() { return $this->schema; }
  public function get_revision() { return $this->revision; }
  public function get_revision_number() { return $this->revision_number; }
  public function get_revision_file() { return $this->revision_file; }
  public function get_file() { return $this->file; }
  public function get_line() { return $this->line; }

  public function get_tab_name() { return $this->tab_name; }
  public function get_tab_type() { return $this->tab_type; }

  public function get_name() { return $this->idx_name; }
  public function get_type() { return $this->idx_type; }

  public function get_idx_name() { return $this->idx_name; }
  public function get_idx_type() { return $this->idx_type; }

  public function get_col_name_list() { return $this->col_name_list; }

}
