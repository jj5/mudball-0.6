<?php

// 2025-03-26 jj5 - prefix: a_

class MudSchemaColumnNew {

  public string $name;
  public $type;

  public function __construct( string $name, $type ) {

    $this->name = $name;
    $this->type = $type;

  }

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::ADDITION;
  }
}
