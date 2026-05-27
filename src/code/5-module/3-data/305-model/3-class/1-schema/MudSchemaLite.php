<?php

class MudSchemaLite extends MudGadget {

  protected string $namespace;
  protected string $name;
  protected string $path;

  public function __construct( string $namespace, string $name, string $path ) {

    parent::__construct();

    $this->namespace = $namespace;
    $this->name = $name;
    $this->path = $path;

  }
}
