<?php

class MudDate extends MudDateTime {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTime interface...
  //

  public function is_date() : bool { return true; }

  public function is_time() : bool { return false; }

  public function is_date_time() : bool { return false; }

  public function is_universal() : bool { return false; }

  public function is_local() : bool { return true; }

  public function is_zoned() : bool { return false; }

  public function get_db_value() : int|float|string|null { return $this->format( 'Y-m-d' ); }

}
