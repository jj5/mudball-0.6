<?php

class MudModel implements IMudModel {

  public string $namespace;
  public string $name;

  public ?string $version_string = null;
  public array $object_map = [];

  public function __construct( string $namespace, string $name ) {

    $this->namespace = $namespace;
    $this->name = $name;

  }

  public function get_model_namespace() : string { return $this->namespace; }
  public function get_model_name() : string { return $this->name; }

}
