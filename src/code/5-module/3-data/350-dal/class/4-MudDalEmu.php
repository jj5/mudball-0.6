<?php

class MudDalEmu extends MudDal {

  use MudDalPeripheral;

  public function __construct() { parent::__construct( APP_SERVICE_DAL_EMU ); }

  public function is_raw() { return false; }
  public function is_trn() { return false; }
  public function is_emu() { return true; }
  public function is_aux() { return false; }
  public function is_dba() { return false; }

  protected function new_database() { return new_mud_database_emu(); }

}
