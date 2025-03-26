<?php

class MudSchemaBuilder {

  public string $namespace;

  public array $version_map = [];

  public function __construct( string $namespace ) {

    $this->namespace = $namespace;

  }

  public function add_version( string $version_string ) {

    assert( ! isset( $this->version_map[ $version_string ] ) );

    $version = new MudSchemaVersionBuilder( $version_string );

    $this->version_map[ $version_string ] = $version;

    return $version;

  }
}

class MudSchemaVersionBuilder {

  public string $version_string;
  public array $change_list = [];

  public function __construct( string $version_string ) {

    $this->version_string = $version_string;

  }

  public function add_table( string $table_name, MudModelSpecificType $specific_type ) {

    $change = new MudSchemaTableNew( $table_name, $specific_type );

    $this->change_list[] = $change;

    return $change;

  }
}
