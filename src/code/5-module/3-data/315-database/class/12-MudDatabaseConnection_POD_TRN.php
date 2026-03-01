<?php

class MudDatabaseConnection_PDO_TRN extends MudDatabaseConnection {
  function get_connection_type() : MudDatabaseConnectionType { return MudDatabaseConnectionType::TRN; }
  public function begin() {
    //$this->get_pdo()->exec( 'START TRANSACTION WITH CONSISTENT SNAPSHOT' );
    $this->get_pdo()->beginTransaction();
    assert( $this->get_pdo()->inTransaction() );
  }
  public function snapshot() {
    $this->commit();
    $this->begin();
  }
  protected function initialize() {
    parent::initialize();
    $this->begin();
  }
}
