<?php

class MudSchemaDefinition {

  protected $database;
  protected $code;
  protected $name;
  protected $path;
  protected $namespace;

  protected $table_map = [];

  public function __construct( $database, $code, $name, $path, $namespace ) {

    $this->database = $database;
    $this->code = $code;
    $this->name = $name;
    $this->path = $path;
    $this->namespace = $namespace;

    foreach ( glob( $this->path . '/????-??-??-??????.php' ) as $migration_path ) {

      $version = explode( '.', basename( $migration_path ) )[ 0 ];

      $migration = new MudSchemaMigration( $this, $version, $migration_path );

      $database->add_migration( $migration );

    }
  }

  public function get_database() {

    return $this->database;

  }

  public function get_code() {

    return $this->code;

  }

  public function get_name() {

    return $this->name;

  }

  public function get_path() {

    return $this->path;

  }

  public function get_namespace() {

    return $this->namespace;

  }

  public function get_label() {

    return $this->name . ' (' . $this->namespace . ')';

  }

  public function add_table( $table ) {

    assert( ! isset( $this->table_map[ $table->get_name() ] ) );

    $this->table_map[ $table->get_name() ] = $table;

  }

  public function get_table( $name ) {

    return $this->table_map[ $name ] ?? null;

  }
}
