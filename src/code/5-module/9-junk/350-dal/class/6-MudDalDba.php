<?php

class MudDalDba extends MudDal {

  use MudDalCentral;
  use MudDalPeripheral;

  public function __construct() { parent::__construct( APP_SERVICE_DAL_DBA ); }

  public function is_raw() { return false; }
  public function is_trn() { return false; }
  public function is_emu() { return false; }
  public function is_aux() { return false; }
  public function is_dba() { return true; }

  protected function new_database() { return new_mud_database_dba(); }

}
