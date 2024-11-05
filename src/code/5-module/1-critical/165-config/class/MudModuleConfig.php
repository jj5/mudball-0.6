<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//
//

class MudModuleConfig extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleConfig|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function get_config( array $path, $default = null, &$result = null ) {

    global $config;

    if ( ! $config ) { $config = []; }

    $result = mud_read_ad( $config, $path, $default );

    return $result;

  }
}
