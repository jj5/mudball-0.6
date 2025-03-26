<?php

interface IMudModel {

  public function get_model_namespace() : string;
  public function get_model_name() : string;

}

interface IMudModelObject {

  public function get_object_name() : string;
  public function get_specific_type() : MudModelSpecificType;

  public function get_table_name( IMudModel $model ) : string;

}

interface IMudModelProperty {

  public function get_property_name() : string;

  public function get_column_name( IMudModel $model, IMudModelObject $object ) : string;

}

interface IMudModelConstraint {

  public function get_constraint_name() : string;

}
