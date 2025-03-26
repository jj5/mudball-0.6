<?php

class MudModelVersionBuilder {

  public string $version_string;
  public array $change_list = [];

  public function __construct( string $version_string ) {

    $this->version_string = $version_string;

  }

  public function apply_model( MudModel $model ) {

    $model->version_string = $this->version_string;

    foreach ( $this->change_list as $change ) {

      $change->apply_model( $model );

    }
  }

  public function apply_schema( IMudModel $model, MudSchemaBuilder $schema_builder ) {

    $version_builder = $schema_builder->add_version( $this->version_string );

    foreach ( $this->change_list as $change ) {

      $change->apply_schema( $model, $version_builder );

    }
  }

  public function add_abinitio( string $name, ?string $type_code = null ) {

    $change = new mud_model_abinitio_add( $name, $type_code );

    return $this->add_change( $change );

  }

  public function add_lookup( string $name ) {

    $change = new mud_model_lookup_add( $name, null );

    return $this->add_change( $change );

  }

  protected function add_change( MudModelChange $change ) {

    $this->change_list[] = $change;

    return $change;

  }
}
