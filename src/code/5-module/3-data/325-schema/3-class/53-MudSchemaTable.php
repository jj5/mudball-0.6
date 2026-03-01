<?php

class MudSchemaTable {

  protected $database;
  protected $name;
  protected $type;

  protected $col_map = [];

  public function __construct( $database, $name, $type ) {

    $this->database = $database;
    $this->name = $name;
    $this->type = $type;

  }

  public function get_database() {

    return $this->database;

  }

  public function get_name() {

    return $this->name;

  }

  public function get_type() {

    return $this->type;

  }

  public function add_column( $column ) {

    assert( ! isset( $this->col_map[ $column->get_name() ] ) );

    $this->col_map[ $column->get_name() ] = $column;

    return $column;

  }

  public function get_column( $name ) {

    assert( isset( $this->col_map[ $name ] ) );

    return $this->col_map[ $name ];

  }
}
