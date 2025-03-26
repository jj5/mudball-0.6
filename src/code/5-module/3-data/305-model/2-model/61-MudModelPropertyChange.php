<?php

abstract class MudModelPropertyChange extends MudModelChange implements IMudModelProperty {

  public string $name;
  public string $type;
  public array $spec;

  public function __construct( string $name, string $type, array $spec ) {

    parent::__construct();

    $this->name = $name;
    $this->type = $type;
    $this->spec = $spec;

  }

  public function get_property_name() : string { return $this->name; }

  public function get_column_name( IMudModel $model, IMudModelObject $object ) : string {

    return 'a_' . $model->get_model_namespace() . '_' . $object->get_object_name() . '_' . $this->name;

  }
}
