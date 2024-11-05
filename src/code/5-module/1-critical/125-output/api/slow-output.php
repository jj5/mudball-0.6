<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-07 jj5 - functional interface...
//
//

function mud_print( string $line, &$bytes_written = null ) : void {

  mud_module_output()->printline( $line, $bytes_written );

}

function mud_write( string $output, &$bytes_written = null ) : void {

  mud_module_output()->stdout( $output, $flush = false, $bytes_written );

}

function mud_flush( string $output, &$bytes_written = null ) : void {

  mud_module_output()->stdout( $output, $flush = true, $bytes_written );

}

function mud_stdout( string $output, bool $flush = false, &$bytes_written = null ) : void {

  mud_module_output()->stdout( $output, $flush, $bytes_written );

}

function mud_stderr( string $output, bool $flush = false, &$bytes_written = null ) : void {

  mud_module_output()->stderr( $output, $flush, $bytes_written );

}
