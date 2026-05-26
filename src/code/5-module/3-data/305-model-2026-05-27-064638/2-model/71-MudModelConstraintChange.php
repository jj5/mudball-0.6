<?php

abstract class MudModelConstraintChange extends MudModelChange {

  public array $property_list;
  public MudModelConstraintType $type;

  public function __construct( array $property_list, MudModelConstraintType $type ) {

    parent::__construct();

    $this->property_list = $property_list;
    $this->type = $type;

  }

  public function get_constraint_name() : string {

    $md5 = md5( implode( '_', $this->property_list ) );

    switch ( $this->type ) {
      case MudModelConstraintType::PRIMARY: return "pk_$md5";
      case MudModelConstraintType::UNIQUE: return "uk_$md5";
      case MudModelConstraintType::INDEX: default: return "ix_$md5";
    }
  }
}
