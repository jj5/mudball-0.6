<?php

abstract class MudModelObjectChange extends MudModelChange implements IMudModelObject {

  public string $name;
  public ?string $type_code;

  public array $property_map = [];
  public array $constraint_map = [];

  public array $add_data_list = [];
  public array $mod_data_list = [];
  public array $del_data_list = [];

  public function __construct( string $name, ?string $type_code ) {

    parent::__construct();

    $this->name = $name;
    $this->type_code = $type_code;

  }

  public abstract function get_specific_type() : MudModelSpecificType;
  public abstract function apply_model( MudModel $model );

  public function get_object_name() : string { return $this->name; }

  public function get_table_name( IMudModel $model ) : string {

    return 't_' . $this->get_specific_type()->value . '_' . $model->get_model_namespace() . '_' . $this->name;

  }

  public function add_key( string $property_name, string $property_type, array $property_spec = [] ) {

    assert( ! isset( $this->property_map[ $property_name ] ) );

    $property = new MudModelPropertyAddition( $property_name, $property_type, $property_spec );

    $this->property_map[ $property_name ] = $property;

    $constraint = new MudModelConstraintAddition( [ $property_name ], MudModelConstraintType::PRIMARY );

    $constraint_name = $constraint->get_constraint_name();

    assert( ! isset( $this->constraint_map[ $constraint_name ] ) );

    $this->constraint_map[ $constraint_name ] = $constraint;

    return $this;

  }

  public function add_col( string $property_name, string $property_type, array $property_spec = [] ) {

    assert( ! isset( $this->property_map[ $property_name ] ) );

    $property = new MudModelPropertyAddition( $property_name, $property_type, $property_spec );

    $this->property_map[ $property_name ] = $property;

    return $this;

  }

  public function add_idx( array $property_list, MudModelConstraintType $constraint_type = MudModelConstraintType::INDEX ) {

    $constraint = new MudModelConstraintAddition( $property_list, $constraint_type );

    $constraint_name = $constraint->get_constraint_name();

    assert( ! isset( $this->constraint_map[ $constraint_name ] ) );

    $this->constraint_map[ $constraint_name ] = $constraint;

    return $this;

  }

  public function add_dat( array $col_spec, array $row_spec ) {

    $this->add_data_list[] = new MudModelData( $col_spec, $row_spec );

    return $this;

  }

  public function add_php( string $path ) {

    $spec = require $path;

    return $this->add_dat( $spec[ 0 ], $spec[ 1 ] );

  }
}
