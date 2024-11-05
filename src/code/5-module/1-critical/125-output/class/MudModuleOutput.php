<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - class definition...
//

class MudModuleOutput extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - output private fields...
  //

  private $stdout_sent = 0;

  private $stderr_sent = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-08-07 jj5 - public instance methods...
  //

  public function get_total_stdout_bytes() { return $this->stdout_sent; }
  public function get_total_stderr_bytes() { return $this->stderr_sent; }

  public function printline( string $line, &$bytes_written ) : void {

    $this->stdout( "$line\n", $flush = true, $bytes_written );

  }

  public function stdout( string $output, bool $flush, &$bytes_written ) : void {

    $strlen = strlen( $output );

    $this->stdout_sent += $strlen;
    $bytes_written += $strlen;

    echo $output;

    if ( $flush ) { flush(); }

  }

  public function stderr( string $output, bool $flush, &$bytes_written ) : void {

    $strlen = strlen( $output );

    $this->stderr_sent += $strlen;
    $bytes_written += $strlen;

    if ( defined( 'STDERR' ) ) {

      // 2020-05-01 jj5 - OLD:
      //file_put_contents( 'php://stderr', $output );
      // 2020-05-01 jj5 - NEW:
      fwrite( STDERR, $output );
      // 2020-05-01 jj5 - END

      if ( $flush ) { fflush( STDERR ); }

    }
    else {

      error_log( $output );

    }
  }
}
