<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerNull extends MudLoggerBase implements IMudLog {

  public static function Instance() {

    static $instance = null;

    if ( $instance === null ) {

      $instance = MudLoggerNull::Create();

    }

    return $instance;

  }

  public function log( string $message, int $level ) { ; }

}
