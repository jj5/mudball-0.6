<?php

class MudSchemaColumn {

  protected MudSchemaTable $table;
  protected string $name;
  protected string $type;

  protected int $min_len = 0;
  protected int $max_len = 255;

  protected bool $nullable = false;
  protected bool $has_default = false;

  protected $default = null;

  public function __construct(
    MudSchemaTable $table,
    string $name,
    string $type,
    int $min_len = 0,
    int $max_len = 255,
    bool $nullable = false,
    bool $has_default = false,
    $default = null
  ) {

    $this->table = $table;
    $this->name = $name;
    $this->type = $type;
    $this->min_len = $min_len;
    $this->max_len = $max_len;
    $this->nullable = $nullable;
    $this->has_default = $has_default;
    $this->default = $default;

  }

  public function get_table() {

    return $this->table;

  }

  public function get_name() {

    return $this->name;

  }

  public function get_type() {

    return $this->type;

  }

  public function get_min_len() {

    return $this->min_len;

  }

  public function get_max_len() {

    return $this->max_len;

  }

  public function is_nullable() {

    return $this->nullable;

  }

  public function has_default() {

    return $this->has_default;

  }

  public function get_default() {

    return $this->default;

  }
}
