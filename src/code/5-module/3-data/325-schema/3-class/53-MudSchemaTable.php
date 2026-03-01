<?php

class MudSchemaTable implements IMudSchemaTable {

  protected MudSchemaDefinition $schema;
  protected string $table_name;
  protected MudSchemaTableType $table_type;

  protected array $col_map = [];

  public function __construct( MudSchemaDefinition $schema, string $table_name, MudSchemaTableType $table_type ) {

    $this->schema = $schema;
    $this->table_name = $table_name;
    $this->table_type = $table_type;

  }

  public function get_database() : MudSchemaDatabase {

    return $this->schema->get_database();

  }

  public function get_schema() : MudSchemaDefinition {

    return $this->schema;

  }

  public function get_table_name() : string {

    return $this->table_name;

  }

  public function get_table_type() : MudSchemaTableType {

    return $this->table_type;

  }

  public function add_column( MudSchemaColumn $column ) {

    assert( ! isset( $this->col_map[ $column->get_column_name() ] ) );

    $this->col_map[ $column->get_column_name() ] = $column;

    return $column;

  }

  public function get_column( string $column_name ) : MudSchemaColumn {

    assert( isset( $this->col_map[ $column_name ] ) );

    return $this->col_map[ $column_name ];

  }
}
