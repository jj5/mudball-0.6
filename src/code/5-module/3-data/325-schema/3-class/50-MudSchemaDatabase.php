<?php

class MudSchemaDatabase {

  protected $name;
  protected $schema_map = [];
  protected $namespace_map = [];
  protected $migration_map = [];

  protected $table_map = [];

  public function __construct( $name ) {

    $this->name = $name;

  }

  public function get_name() : string {

    return $this->name;

  }

  public function get_table( string $name ) : MudSchemaTable {

    assert( isset( $this->table_map[ $name ] ) );

    return $this->table_map[ $name ];

  }

  public function add_table( MudSchemaTable $table ) {

    assert( ! isset( $this->table_map[ $table->get_table_name() ] ) );

    $this->table_map[ $table->get_table_name() ] = $table;

    return $table;

  }

  public function add_schema( string $namespace, string $path ) : self {

    $name = basename( $path );

    assert( ! isset( $this->schema_map[ $name ] ) );
    assert( ! isset( $this->namespace_map[ $namespace ] ) );

    $count = count( $this->schema_map );

    $code = sprintf( '%05d', $count + 1 );

    $schema = new MudSchemaDefinition( $this, $code, $name, $path, $namespace );

    $this->schema_map[ $name ] = $schema;
    $this->namespace_map[ $namespace ] = $schema;

    return $this;

  }

  public function add_migration( MudSchemaMigration $migration ) : self {

    $code = $migration->get_code();

    assert( ! isset( $this->migration_map[ $code ] ) );

    $this->migration_map[ $code ] = $migration;

    return $this;

  }

  public function load() {

    global $migration;

    ksort( $this->migration_map );

    foreach ( $this->migration_map as $migration ) {

      echo 'Loading migration: ' . $migration->get_code() . ' for ' .
        $migration->get_schema()->get_label() . PHP_EOL;

      require $migration->get_path();

    }
  }

  public function migrate() {

    $vendor = new MudSchemaVendor_MySQL();

    $migration = mud_get_migration();

    $connector = new MudDatabaseConnector();

    $dba = $connector->get_connection( MudDatabaseConnectionType::DBA );

    $log = null;

    foreach ( $this->migration_map as $migration ) {

      if ( $migration->is_done( $dba ) ) {
        continue;
      }

      echo 'Migrating: ' . $migration->get_code() . ' for ' .
        $migration->get_schema()->get_label() . PHP_EOL;

      $migration->apply( $dba, $vendor );

      if ( $log === null ) {

        $dba->exec( 'call sp_std_new_interaction' );

        $log = $dba->prepare("
          insert into t_about_std_migration (
            a_std_migration_schema,
            a_std_migration_revision,
            a_std_migration_created_in
          )
          values (
            :a_std_migration_schema,
            :a_std_migration_revision,
            :a_std_migration_created_in
          )
        ");

      }

      $log->execute([
        ':a_std_migration_schema' => $migration->get_schema()->get_name(),
        ':a_std_migration_revision' => $migration->get_revision(),
        ':a_std_migration_created_in' => $dba->get_a_std_interaction_aid(),
      ]);

    }
  }
}
