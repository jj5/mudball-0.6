<?php

class MudDateTimeZoned extends MudDateTime implements IMudDateTimeZoned {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - private fields
  //

  private $child_list = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //

  public function get_child_list() : array {

    if ( $this->child_list = null ) {

      $this->child_list = [];

      $this->get_time_zone()->add_to_list( $this->child_list );

    }

    return $this->child_list;
    
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - IMudDateTime interface...
  //

  public function is_date() : bool { return true; }

  public function is_time() : bool { return true; }

  public function is_date_time() : bool { return true; }

  public function is_universal() : bool { return false; }

  public function is_local() : bool { return false; }

  public function is_zoned() : bool { return true; }

  public function get_time_zone() : IMudDateTimeZone { return mud_get_date_time_zone( $this->get_value()->getTimezone() ); }

}
