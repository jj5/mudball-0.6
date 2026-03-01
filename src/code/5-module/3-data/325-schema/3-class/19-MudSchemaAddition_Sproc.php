<?php

class MudSchemaAddition_Sproc extends MudSchemaAddition {

  protected $migration;
  protected $sql;

  public function __construct( $migration, $sql ) {

    $this->migration = $migration;
    $this->sql = $sql;

  }

  public function apply( $work ) {

    $work->create_sproc( $this->sql );

  }
}
