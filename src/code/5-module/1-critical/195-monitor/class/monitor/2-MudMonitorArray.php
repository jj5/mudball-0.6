<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - class definition...
//

class MudMonitorArray extends MudMonitorStandard implements ArrayAccess {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - ArrayAccess interface...
  //

  public function offsetExists( mixed $offset ): bool {

    $this->log_monitor( __FUNCTION__, $offset );

    return isset( $this->monitor_object[ $offset ] );

  }

  public function offsetGet( mixed $offset ): mixed {

    $this->log_monitor( __FUNCTION__, $offset );

    return $this->monitor_object[ $offset ];

  }

  public function offsetSet( mixed $offset , mixed $value ): void {

    $this->log_monitor( __FUNCTION__, $offset );

    $this->monitor_object[ $offset ] = $value;

  }

  public function offsetUnset( mixed $offset ): void {

    $this->log_monitor( __FUNCTION__, $offset );

    unset( $this->monitor_object[ $offset ] );

  }
}
