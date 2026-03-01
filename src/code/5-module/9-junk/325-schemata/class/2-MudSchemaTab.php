<?php

class MudSchemaTab extends MudGadget {

  public $schemata;
  public $schema;
  public $revision;
  public $revision_number;
  public $revision_file;
  public $file;
  public $line;

  public $tab_name;
  public $tab_type;
  public $short_name;

  public $connection_type;
  public $is_cacheable;
  public $const;

  public $col_map = [];
  public $idx_map = [];

  public function jsonSerialize(): mixed {

    return [
      //'schemata' => $this->schemata,
      'schema' => $this->schema,
      'revision' => $this->revision,
      'revision_number' => $this->revision_number,
      'revision_file' => $this->revision_file,
      'file' => $this->file,
      'line' => $this->line,
      'tab_name' => $this->tab_name,
      'tab_type' => $this->tab_type,
      'short_name' => $this->short_name,
      'connection_type' => $this->connection_type,
      'is_cacheable' => $this->is_cacheable,
      'const' => $this->const,
      'col_map' => $this->col_map,
      'idx_map' => $this->idx_map,
    ];

  }

  public function __construct(
    $schemata,
    $schema,
    $revision,
    $revision_number,
    $revision_file,
    $file,
    $line,
    $tab_name,
    $tab_type,
    $connection_type,
    $is_cacheable,
    $const
  ) {

    $this->schemata = $schemata;
    $this->schema = $schema;
    $this->revision = $revision;
    $this->revision_number = $revision_number;
    $this->revision_file = $revision_file;
    $this->file = $file;
    $this->line = $line;

    $this->tab_name = $tab_name;
    $this->tab_type = $tab_type;

    $parts = explode( '_', $tab_name, 3 );

    assert( count( $parts ) === 3 );
    assert( $parts[ 0 ] === 't' );
    assert( $tab_type === $parts[ 1 ] );

    $this->short_name = $parts[ 2 ];

    $this->connection_type = $connection_type;
    $this->is_cacheable = $is_cacheable;
    $this->const = $const;

    parent::__construct();

  }

  public function get_name() { return $this->tab_name; }
  public function get_type() { return $this->tab_type; }
  public function get_short_name() { return $this->short_name; }

  public function get_connection_type() { return $this->connection_type; }
  public function is_cacheable() { return $this->is_cacheable; }
  public function get_const() { return $this->const; }

  public function get_key() {

    foreach ( $this->col_map as $col_name => $col ) {

      assert( $col->is_key() );

      return $col;

    }

    return null;

  }
}
