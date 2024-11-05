<?php

abstract class MudTool extends MudGadget {

  public function report( $line ) {

    if ( ! $this->verbose ) { return; }

    echo "$line\n";

  }

  public function error( $problem, int $error_level ) {

    while ( ob_get_level() ) { ob_end_clean(); }

    mud_stderr( "error: $problem" );

    exit( $error_level );

  }

  public function value_error( $problem, $value, int $error_level ) {

    error( "$problem: " . json_encode( $value, JSON_UNESCAPED_SLASHES ), $error_level );

  }
}
