<?php

class MudSchemaAddition_Table extends MudSchemaAddition implements IMudSchemaTable {

  protected MudSchemaMigration $migration;
  protected string $table_name;
  protected MudSchemaTableType $table_type;

  protected MudSchemaTable $table;
  protected array $col_list = [];

  public function __construct( MudSchemaMigration $migration, string $table_name ) {

    $this->migration = $migration;
    $this->table_name = $table_name;
    $this->table_type = $this->find_table_type( $table_name );

    $this->table = new MudSchemaTable( $this->get_schema(), $table_name, $this->table_type );

    $this->get_database()->add_table( $this->table );

  }

  public function get_database() {

    return $this->get_schema()->get_database();

  }

  public function get_schema() : MudSchemaDefinition {

    return $this->get_migration()->get_schema();

  }

  public function get_migration() : MudSchemaMigration {

    return $this->migration;

  }

  public function get_table_name() : string {

    return $this->table_name;

  }

  public function get_table_type() : MudSchemaTableType {

    return $this->table_type;

  }

  public function add_key( string $column_name, MudSchemaColumnType $column_type ) : MudSchemaAddition_ColumnKey {

    $key = new MudSchemaAddition_ColumnKey( $this, $column_name, $column_type );

    $this->col_list[] = $key;

    $this->table->add_column( $key->get_column() );

    return $key;

  }

  public function add_col( string $column_name, MudSchemaColumnType $column_type ) : MudSchemaAddition_Column {

    $col = new MudSchemaAddition_Column( $this, $column_name, $column_type );

    $this->col_list[] = $col;

    $this->table->add_column( $col->get_column() );

    return $col;

  }

  public function add_ref(
    string $column_name,
    string $ref_table,
    string $ref_col
  )
  : MudSchemaAddition_ColumnReference {

    $ref = new MudSchemaAddition_ColumnReference( $this, $column_name, $ref_table, $ref_col );

    $this->col_list[] = $ref;

    $this->table->add_column( $ref->get_column() );

    return $ref;

  }

  public function apply( $work, $vendor ) {

    $sql = $this->get_sql( $vendor );

    $work->create_table( $sql );

  }

  public function get_sql( $vendor ) {

    $key_col = null;

    $spec_list = [];

    foreach ( $this->col_list as $col ) {

      if ( $key_col === null ) { $key_col = $col; }

      $spec_list[] = $col->get_sql( $vendor );

    }

    $spec_list[] = "primary key ( {$key_col->get_column_name()} )";

    foreach ( $this->col_list as $col ) {

      if ( ! $col->is_ref() ) { continue; }

      $spec_list[] = $col->get_ref_sql( $vendor );

    }

    $sql = "create table {$this->table_name} (";

    $sql .= "\n  " . implode( ",\n  ", $spec_list );

    $sql .= "\n);";

    return $sql;

  }

  protected function find_table_type( $table_name ) : MudSchemaTableType {

    $parts = explode( '_', $table_name );

    if ( count( $parts ) > 2 ) {

      $table_type = $parts[ 1 ];

      foreach ( MudSchemaTableType::cases() as $case ) {

        if ( $case->value === $table_type ) {

          return $case;

        }
      }
    }

    throw new Exception( "Unable to determine table type for '{$table_name}'" );

  }
}
