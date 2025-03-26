<?php

// 2025-03-26 jj5 - prefix: t_

class MudSchemaTableNew {

  public string $name;
  public MudModelSpecificType $specific_type;

  public array $column_map = [];
  public array $index_map = [];

  public function __construct( string $name, MudModelSpecificType $specific_type ) {

    $this->name = $name;
    $this->specific_type = $specific_type;

  }

  public function get_specific_type() : MudModelSpecificType {
    return $this->specific_type;
  }

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::ADDITION;
  }

  public function add_column( IMudModel $model, IMudModelObject $object, IMudModelProperty $property ) {

    $column_name = $property->get_column_name( $model, $object );

    $column = new MudSchemaColumnNew( $column_name, $property->type );

    $this->column_map[ $column_name ] = $column;

    return $column;

  }

}
