<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - class definition...
//

class MudLoggerStderr extends MudLoggerBase implements IMudLog {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - public methods...
  //

  public function log( string $message, int $level ) {

    if ( $level > $this->level ) { return false; }

    $log = $this->get_log_line( $message, $level, MUD_LOG_FORMAT_STANDARD );

    mud_stderr( "$log\n" );

    return true;

  }
}
