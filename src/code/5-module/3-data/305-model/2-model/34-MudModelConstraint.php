<?php

class MudModelConstraint {

  public string $name;
  public MudModelConstraintType $type;
  public array $property_list;

  public function __construct( string $name, MudModelConstraintType $type, array $property_list ) {

    $this->name = $name;
    $this->type = $type;
    $this->property_list = $property_list;

  }
}
