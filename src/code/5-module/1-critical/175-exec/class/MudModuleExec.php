<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-25 jj5 - class definition...
//

class MudModuleExec extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public functions...
  //

  public function exec( string $command ) : void {

    mud_log_trace( "executing command", [ $command ] );

    $output = null;
    $error_level = null;

    exec( $command . ' 2>&1', $output, $error_level );

    mud_log_trace( "command complete", [ $error_level, $command ] );

    if ( $error_level !== 0 ) {

      mud_fail( MUD_ERR_EXEC_COMMAND_FAILED, [ '$command' => $command, '$error_level' => $error_level ] );

    }
  }
}
