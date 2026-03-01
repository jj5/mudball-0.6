<?php

class MudDalAux extends MudDal {

  use MudDalPeripheral;

  public function __construct() { parent::__construct( APP_SERVICE_DAL_AUX ); }

  public function is_raw() { return false; }
  public function is_trn() { return false; }
  public function is_emu() { return false; }
  public function is_aux() { return true; }
  public function is_dba() { return false; }

  protected function new_database() { return new_mud_database_aux(); }

}
