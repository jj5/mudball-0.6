<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerNull implements IMudLog {

  public static function Instance() {

    static $instance = null;

    if ( $instance === null ) {

      $instance = new_mud_logger_null();

    }

    return $instance;

  }

  public function log( string $message, int $level ) { ; }

}
