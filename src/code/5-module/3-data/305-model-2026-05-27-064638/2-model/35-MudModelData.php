<?php

class MudModelData {

  public array $col_spec;
  public array $row_spec;

  public function __construct( array $col_spec, array $row_spec ) {

    $this->col_spec = $col_spec;
    $this->row_spec = $row_spec;

  }
}
