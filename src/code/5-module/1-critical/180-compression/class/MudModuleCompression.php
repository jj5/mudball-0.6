<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleCompression extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleCompression|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  public function zlob_encode( $data, int $level = 9 ) {

    return $this->gzip_encode( $data, $level );

  }

  public function zlob_decode( string $zlob ) {

    return $this->gzip_decode( $zlob );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-03-04 jj5 - protected functions...
  //

  protected function gzip_encode( $data, int $level = 9 ) {

    return gzencode( $data, $level );

  }

  protected function gzip_decode( string $compressed ) {

    return gzdecode( $compressed );

  }

  //
  // 2022-04-10 jj5 - NOTE: I was just playing here with these functions, I'm not sure they're
  // widely supported, I don't actually use them presently and have no plans to do so...
  //

  protected function zstd_encode( $data, int $level = 22 ) {

    return zstd_compress( $data, $level );

  }

  protected function zstd_decode( string $compressed ) {

    return zstd_uncompress( $compressed );

  }
}
