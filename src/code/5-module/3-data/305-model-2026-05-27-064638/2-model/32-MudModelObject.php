<?php

class MudModelObject implements IMudModelObject {

  public string $name;
  public ?string $type_code;
  public MudModelSpecificType $type;

  public array $property_map = [];
  public array $constraint_map = [];

  public function __construct( string $name, ?string $type_code, MudModelSpecificType $type ) {

    $this->name = $name;
    $this->type_code = $type_code;
    $this->type = $type;

  }

  public function get_object_name() : string { return $this->name; }
  public function get_specific_type() : MudModelSpecificType { return $this->type; }

  public function get_table_name( IMudModel $model ) : string {

    return 't_' . $this->get_specific_type()->value . '_' . $model->get_model_namespace() . '_' . $this->get_object_name();

  }
}
