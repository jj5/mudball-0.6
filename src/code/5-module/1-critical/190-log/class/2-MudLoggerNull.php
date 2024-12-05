<?php


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerNull extends MudLoggerBase implements IMudLog {
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudLoggerNull implements IMudLog {
>>>>>>> e3a066e (Work, work...)

  public static function Instance() {

    static $instance = null;

    if ( $instance === null ) {

<<<<<<< HEAD
      $instance = MudLoggerNull::Create();
=======
      $instance = new_mud_logger_null();
>>>>>>> e3a066e (Work, work...)

    }

    return $instance;

  }

  public function log( string $message, int $level ) { ; }

}
