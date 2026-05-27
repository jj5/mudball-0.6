<?php

class MudElementAccessorDirect extends MudGadget implements IMudElementAccessor {

  use MudValidationLite;

  protected MudDatabaseLite $db;

  protected array $cache = [];

  public function __construct( MudDatabaseLite $db ) {

    parent::__construct();

    $this->db = $db;

  }

  protected $particle_statement_cache = [];

  public function get_particle( string $table, string $aid_column, string $value_column, int $rid ) : string {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    if ( ! isset( $this->particle_statement_cache[ $table ] ) ) {

      $sql = "select `$value_column` from `$table` where `$aid_column` = :rid";

      $statement = $this->db->get_raw()->prepare( $sql );

      $this->particle_statement_cache[ $table ] = $statement;

    }

    $statement = $this->particle_statement_cache[ $table ];

    $statement->bindValue( ':rid', $rid, PDO::PARAM_INT );
    $statement->execute();

    $result = $statement->fetchColumn();

    if ( $result === false ) {

      mud_fail(
        MUD_ERR_MODEL_ELEMENT_NOT_FOUND,
        [
          'table' => $table,
          'aid_column' => $aid_column,
          'value_column' => $value_column,
          'rid' => $rid,
        ]
      );

    }

    return $result;

  }

  protected $particle_rid_select_cache = [];
  protected $particle_rid_insert_cache = [];

  public function get_particle_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    for ( ;; ) {

      if ( ! isset( $this->particle_rid_select_cache[ $table ] ) ) {

        $sql = "select `$aid_column` from `$table` where `$value_column` = :value";

        $statement = $this->db->get_raw()->prepare( $sql );

        $this->particle_rid_select_cache[ $table ] = $statement;

      }

      $statement = $this->particle_rid_select_cache[ $table ];

      $statement->bindValue( ':value', $value, PDO::PARAM_STR );
      $statement->execute();

      $result = $statement->fetchColumn();

      if ( $result === false ) {

        try {

          if ( ! isset( $this->particle_rid_insert_cache[ $table ] ) ) {

            $insert_sql = "insert into `$table` ( `$value_column` ) values ( :value )";

            $insert_statement = $this->db->get_raw()->prepare( $insert_sql );

            $this->particle_rid_insert_cache[ $table ] = $insert_statement;

          }

          $insert_statement = $this->particle_rid_insert_cache[ $table ];

          $insert_statement->bindValue( ':value', $value, PDO::PARAM_STR );
          $insert_statement->execute();

        }
        catch ( PDOException $ex ) {

          mud_stderr( 'Error inserting particle: ' . $ex->getMessage() );

          if ( intval( $ex->getCode() ) === 23000 && ( $ex->errorInfo[ 1 ] ?? null ) === 1062 ) {

            // 2026-05-27 jj5 - duplicate key error, retry the select to get the existing rid... this can happen if two
            // concurrent requests try to insert the same new value at the same time

            usleep( random_int( 100, 1000 ) );

            continue;

          }

          throw $ex;

        }
      }

      return $result;

    }
  }

  public function get_piece( string $table, string $aid_column, string $value_column, int $rid ) : string {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    return '';

  }

  public function get_piece_rid( string $table, string $aid_column, string $hash_column, string $hash ) : int {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $hash_column );

    return 0;

  }

  public function get_pot( string $table, string $aid_column, string $value_column, int $rid ) : string {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    return '';

  }

  public function get_pot_rid( string $table, string $aid_column, string $value_column, string $value ) : int {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    return 0;

  }

  // 2026-05-27 jj5 - note that province is like particle but whole domain is pre-inserted and immutable
  public function get_province( string $table, string $aid_column, string $value_column, int $rid ) : string {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    return '';

  }

  public function get_province_rid( string $table, string $aid_column, string $value_column, mixed $value ) : int {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    $this->validate_name( $value_column );

    return 0;

  }

  public function get_product( string $table, string $aid_column, array $value_column_list, int $rid ) : array {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    foreach ( $value_column_list as $value_column ) {
      $this->validate_name( $value_column );
    }

    return [];

  }

  public function get_product_rid( string $table, string $aid_column, array $column_value_map ) : int {

    $this->validate_name( $table );
    $this->validate_name( $aid_column );
    foreach ( $column_value_map as $column => $value ) {
      $this->validate_name( $column );
    }

    return 0;

  }
}
