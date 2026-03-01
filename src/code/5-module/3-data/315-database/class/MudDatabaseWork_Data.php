<?php

class MudDatabaseWork_Data extends MudDatabaseWork {

  // 2026-01-28 jj5 - transactions used

  public function insert( string $sql, array $data ) : void {
    $stmt = $this->connection->get_pdo()->prepare( $sql );
    foreach ( $data as $row ) {
      $this->register_operation( new MudDatabaseInsert( $this->connection, $sql, $stmt, $row ) );
    }
  }

  public function process() : void {

    $manage_transaction = false;

    if ( ! $this->connection->is_in_transaction() ) {

      $manage_transaction = true;

      $this->connection->begin();

    }

    try {

      $this->do_process();

      if ( $manage_transaction ) {

        $this->connection->commit();

      }
    }
    catch ( Throwable $ex ) {

      if ( $manage_transaction ) {

        $this->connection->cancel();

      }

      throw $ex;

    }
  }
}