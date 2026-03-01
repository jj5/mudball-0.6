<?php

class MudSchemaAddition_Column extends MudSchemaAddition {

  protected IMudSchemaTable $table;
  protected string $column_name;
  protected $type;

  protected int $min_len = 0;
  protected int $max_len = 255;

  protected bool $nullable = false;
  protected bool $has_default = false;
  protected $default = null;

  protected ?MudSchemaColumn $column = null;

  public function __construct( IMudSchemaTable $table, string $column_name, $type ) {

    $this->table = $table;
    $this->column_name = $column_name;
    $this->type = $type;

    switch ( $type ) {

      case DBT_CREATED_ON:
        $this->default( 'current_timestamp' );
        break;

      case DBT_UPDATED_ON:
        $this->default( 'current_timestamp on update current_timestamp' );
        break;

    }
  }

  public function get_column() {

    if ( $this->column === null ) {

      $table = $this->get_database()->get_table( $this->table->get_table_name() );

      $column = new MudSchemaColumn(
        $table,
        $this->column_name,
        $this->type,
        $this->min_len,
        $this->max_len,
        $this->nullable,
        $this->has_default,
        $this->default
      );

      $this->column = $column;

    }

    return $this->column;

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

  public function get_name() : string {

    return $this->column_name;

  }

  public function get_type() {

    return $this->type;

  }

  public function get_min_len() {

    return $this->min_len;

  }

  public function get_max_len() {

    return $this->max_len;

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

    return false;

  }

  public function nullable() {

    $this->nullable = true;

    return $this;

  }

  public function not_null() {

    $this->nullable = false;

    return $this;

  }

  public function min_len( $len ) {

    $this->min_len = $len;

    return $this;

  }

  public function max_len( $len ) {

    $this->max_len = $len;

    return $this;

  }

  public function len( $len ) {

    $this->min_len = $len;
    $this->max_len = $len;

    return $this;

  }

  public function default( $default ) {

    $this->has_default = true;

    $this->default = $default;

    return $this;

  }

  public function get_sql( MudSchemaVendor $vendor ) : string {

    return $vendor->get_col_sql( $this );

  }
}
