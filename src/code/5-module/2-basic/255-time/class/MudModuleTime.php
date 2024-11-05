<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-14 jj5 - class definition...
//

class MudModuleTime extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-14 jj5 - public functions...
  //

  public function get_sydtime() {

    static $time_zone_name = 'Australia/Sydney';

    static $datetime = null;

    if ( $datetime === null ) {

      $time_zone = new_php_date_time_zone( $time_zone_name );

      $datetime = new_php_date_time( 'now', $time_zone );

    }

    $datetime->setTimestamp( time() );

    return $datetime->format( 'Y-m-d-His' );

  }
}
