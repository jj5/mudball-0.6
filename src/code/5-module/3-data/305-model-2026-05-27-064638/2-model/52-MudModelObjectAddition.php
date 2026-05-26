<?php

abstract class MudModelObjectAddition extends MudModelObjectChange {

  public abstract function create_object( MudModel $model ) : MudModelObject;

  public function get_change_type() : MudModelChangeType {

    return MudModelChangeType::ADDITION;

  }

  public function apply_model( MudModel $model ) {

    $object = $this->create_object( $model );

    $model->object_map[ $this->name ] = $object;

    foreach ( $this->property_map as $property ) {

      $object->property_map[ $property->name ] = new MudModelProperty( $property->name, $property->type, $property->spec );

    }

    foreach ( $this->constraint_map as $constraint ) {

      $constraint_name = $constraint->get_constraint_name();

      assert( ! isset( $object->constraint_map[ $constraint_name ] ) );

      $constraint = new MudModelConstraint( $constraint_name, $constraint->type, $constraint->property_list );

      $object->constraint_map[ $constraint_name ] = $constraint;

    }
  }

  public function apply_schema( IMudModel $model, MudSchemaVersionBuilder $schema ) {

    $table = $schema->add_table( $this->get_table_name( $model ), $this->get_specific_type() );

    foreach ( $this->property_map as $property ) {

      $column = $table->add_column( $model, $this, $property );

      $table->column_map[ $column->name ] = $column;

    }

  }
}
