<?php

class MudSchemaMigration {

  protected $schema;
  protected $revision;
  protected $path;
  protected $code;

  protected $current_table;

  protected $op_list = [];

  public function __construct( $schema, $revision, $path ) {

    $this->schema = $schema;
    $this->revision = $revision;
    $this->path = $path;
    $this->code = $revision . '-' . $schema->get_code();

  }

  public function get_schema() {

    return $this->schema;

  }

  public function get_revision() {

    return $this->revision;

  }

  public function get_path() {

    return $this->path;

  }

  public function get_code() {

    return $this->code;

  }

  public function add_tab( $name ) : MudSchemaAddition_Table {

    $this->current_table = new MudSchemaAddition_Table( $this, $name );

    $this->op_list[] = $this->current_table;

    return $this->current_table;

  }

  public function curr_tab() {

    return $this->current_table;

  }

  public function add_sproc( $sproc_sql ) : MudSchemaAddition_Sproc {

    $result = new MudSchemaAddition_Sproc( $this, $sproc_sql );

    $this->op_list[] = $result;

    return $result;

  }

  public function del_sproc( $sproc_name ) : MudSchemaDeletion_Sproc {

    $result = new MudSchemaDeletion_Sproc( $this, $sproc_name );

    $this->op_list[] = $result;

    return $result;

  }

  public function is_done( $dba ) {

    // 2026-03-01 jj5 - returns true if this migration has already been applied to the database

    if ( ! $this->has_t_about_std_migration( $dba ) ) {

      return false;

    }

    $sql = "
      select count(*) as count
      from t_about_std_migration
      where a_std_migration_schema = :a_std_migration_schema
      and a_std_migration_revision = :a_std_migration_revision
    ";

    $args = [
      ':a_std_migration_schema' => $this->get_schema()->get_name(),
      ':a_std_migration_revision' => $this->get_revision(),
    ];

    return $dba->fetch( $sql, $args )[ 0 ][ 'count' ] > 0;

  }

  public function has_t_about_std_migration( $dba ) {

    $sql = "
      select count(*) as count
      from information_schema.tables
      where table_schema = database()
      and table_name = 't_about_std_migration'
    ";

    return $dba->query( $sql )[ 0 ][ 'count' ] > 0;

  }

  public function apply( $dba ) {

    $work = $dba->schema_work();

    foreach ( $this->op_list as $op ) {

      $op->apply( $work );

    }

    $work->process();

  }
}
