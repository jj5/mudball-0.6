<?php

class MudModelProperty {

  public string $name;
  public string $type;
  public array $spec;

  public function __construct( string $name, string $type, array $spec ) {

    $this->name = $name;
    $this->type = $type;
    $this->spec = $spec;

  }

  public function get_column_name( IMudModel $model, IMudModelObject $object ) {

    return 'a_' . $model->get_model_namespace() . '_' . $object->get_object_name() . '_' . $this->name;

  }
}
