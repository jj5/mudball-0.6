<?php

class MudElementAccessorCached extends MudGadget implements IMudElementAccessor {

  use MudValidationLite;

  protected MudDatabaseLite $db;

  protected array $cache = [];

  public function __construct( MudDatabaseLite $db ) {

    parent::__construct();

    $this->db = $db;

  }

  public function get_particle( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return '';

  }

  public function get_particle_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    return 0;

  }

  public function get_piece( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return '';

  }

  public function get_piece_rid( string $table, string $aid_column, string $hash_column, string $hash ) : int {

    return 0;

  }

  public function get_pot( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return '';

  }

  public function get_pot_rid( string $table, string $aid_column, string $value_column, string $value ) : int {

    return 0;

  }

  // 2026-05-27 jj5 - note that province is like particle but whole domain is pre-inserted and immutable
  public function get_province( string $table, string $aid_column, string $value_column, int $rid ) : string {

    return '';

  }

  public function get_province_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    return 0;

  }

  public function get_product( string $table, string $aid_column, array $value_column_list, int $rid ) : array {

    return [];

  }

  public function get_product_rid( string $table, string $aid_column, array $column_value_map ) : int {

    return 0;

  }
}
