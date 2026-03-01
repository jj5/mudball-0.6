<?php

class MudSchemaAddition_ColumnReference extends MudSchemaAddition implements IMudSchemaColumn {

  protected IMudSchemaTable $table;
  protected string $column_name;
  protected string $ref_table_name;
  protected string $ref_column_name;

  protected bool $nullable = false;
  protected bool $has_default = false;
  protected $default = null;

  protected ?MudSchemaColumn $column = null;

  public function __construct(
    IMudSchemaTable $table,
    string $column_name,
    string $ref_table_name,
    string $ref_column_name
  ) {

    $this->table = $table;
    $this->column_name = $column_name;
    $this->ref_table_name = $ref_table_name;
    $this->ref_column_name = $ref_column_name;

  }

  public function get_ref_col() {

    return $this->get_database()->get_table( $this->ref_table_name )->get_column( $this->ref_column_name );

  }

  public function get_database() {

    return $this->get_schema()->get_database();

  }

  public function get_schema() {

    return $this->get_table()->get_schema();

  }

  public function get_table() {

    return $this->table;

  }

  public function get_column_name() : string {

    return $this->column_name;

  }

  public function get_ref_table_name() : string {

    return $this->ref_table_name;

  }

  public function get_ref_column_name() : string {

    return $this->ref_column_name;

  }

  public function get_column_type() : MudSchemaColumnType {

    $type = $this->get_ref_col()->get_column_type();

    switch ( $type ) {
      case DBT_AID8:
        $type = DBT_UINT8;
        break;
      case DBT_AID16:
        $type = DBT_UINT16;
        break;
      case DBT_AID24:
        $type = DBT_UINT24;
        break;
      case DBT_AID32:
        $type = DBT_UINT32;
        break;
      case DBT_AID64:
        $type = DBT_INT64;
        break;
    }

    return $type;

  }

  public function get_min_len() {

    return $this->get_ref_col()->get_min_len();

  }

  public function get_max_len() {

    return $this->get_ref_col()->get_max_len();

  }

  public function is_nullable() {

    return $this->nullable;

  }

  public function has_default() {

    return $this->has_default;

  }

  public function get_default() {

    return $this->default;

  }

  public function is_ref() {

    return true;

  }

  public function nullable() {

    $this->nullable = true;

    return $this;

  }

  public function not_null() {

    $this->nullable = false;

    return $this;

  }

  public function default( $default ) {

    $this->has_default = true;

    $this->default = $default;

    return $this;

  }

  public function get_column() {

    if ( $this->column === null ) {

      $ref = $this->get_database()->get_table( $this->ref_table_name )->get_column( $this->ref_column_name );

      $table = $this->get_database()->get_table( $this->table->get_table_name() );

      $column = new MudSchemaColumn(
        $table,
        $this->get_column_name(),
        $this->get_column_type(),
        $ref->get_min_len(),
        $ref->get_max_len(),
        $this->nullable,
        $this->has_default,
        $this->default
      );

      $this->column = $column;

    }

    return $this->column;

  }

  public function get_sql( MudSchemaVendor $vendor ) : string {

    return $vendor->get_col_sql( $this );

  }

  public function get_ref_sql( MudSchemaVendor $vendor ) : string {

    return $vendor->get_ref_sql( $this );

  }
}