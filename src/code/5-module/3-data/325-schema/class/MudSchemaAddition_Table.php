<?php

class MudSchemaAddition_Table {

  protected $migration;
  protected $name;
  protected $type;

  protected MudSchemaTable $table;
  protected $col_list = [];

  public function __construct( $migration, $name ) {

    $this->migration = $migration;
    $this->name = $name;
    $this->type = 'todo';

    $this->table = new MudSchemaTable( $this->get_database(), $name, $this->type );

    $this->get_database()->add_table( $this->table );

  }

  public function get_database() {

    return $this->get_schema()->get_database();

  }

  public function get_schema() {

    return $this->get_migration()->get_schema();

  }

  public function get_migration() {

    return $this->migration;

  }

  public function get_name() {

    return $this->name;

  }

  public function get_type() {

    return $this->type;

  }

  public function add_key( $name, $type ) {

    $key = new MudSchemaAddition_ColumnKey( $this, $name, $type );

    $this->col_list[] = $key;

    $this->table->add_column( $key->get_column() );

    return $key;

  }

  public function add_col( $name, $type ) {

    $col = new MudSchemaAddition_Column( $this, $name, $type );

    $this->col_list[] = $col;

    $this->table->add_column( $col->get_column() );

    return $col;

  }

  public function add_ref( $name, $ref_table, $ref_col ) {

    $ref = new MudSchemaAddition_ColumnReference( $this, $name, $ref_table, $ref_col );

    $this->col_list[] = $ref;

    $this->table->add_column( $ref->get_column() );

    return $ref;

  }

  public function apply( $work ) {

    $sql = $this->get_sql();

    $work->create_table( $sql );

  }

  public function get_sql() {

    $key_col = null;

    $spec_list = [];


    foreach ( $this->col_list as $col ) {

      if ( $key_col === null ) { $key_col = $col; }

      $spec_list[] = $col->get_sql();

    }

    $spec_list[] = "primary key ( {$key_col->get_name()} )";

    foreach ( $this->col_list as $col ) {

      if ( ! $col->is_ref() ) { continue; }

      $spec_list[] = $col->get_ref_sql();

    }

    $sql = "create table {$this->name} (";

    $sql .= "\n  " . implode( ",\n  ", $spec_list );

    $sql .= "\n);";

    return $sql;

  }
}
