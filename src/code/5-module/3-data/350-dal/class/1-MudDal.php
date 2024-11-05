<?php

//class MudDataAccessLayer extends MudDataAccessLayerGen {
abstract class MudDal extends MudDalBase {

  protected $name;

  protected function __construct( string $name ) {

    parent::__construct();

    $this->name = $name;

  }

  public function is_trn() { return $this->name === APP_SERVICE_DAL_TRN; }
  public function is_raw() { return $this->name === APP_SERVICE_DAL_RAW; }
  public function is_emu() { return $this->name === APP_SERVICE_DAL_EMU; }
  public function is_aux() { return $this->name === APP_SERVICE_DAL_AUX; }
  public function is_dba() { return $this->name === APP_SERVICE_DAL_DBA; }

  public function is_online(): bool {

    try {

      return parent::is_online();

    }
    catch ( Throwable $ex ) {

      if ( DEBUG ) {

        var_dump( $ex ); exit;

      }

      return false;

    }
  }

  public function checkpoint() {

    $this->commit();

    $this->begin();

  }

  public function begin() {

    return $this->get_database()->begin();

  }

  public function commit() {

    return $this->get_database()->commit();

  }

  public function rollback() {

    return $this->get_database()->rollback();

  }

  public function prepare( $sql ) {

    return $this->get_database()->prepare( $sql );

  }

  public function random_delay() {

    return $this->get_database()->random_delay();

  }

  public function quote( string $value ) {

    return $this->get_database()->quote( $value );

  }
}
