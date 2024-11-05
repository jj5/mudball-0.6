<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - class definition...
//

class MudMonitorStandard extends MudMonitor {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - magic methods...
  //

  public function __get( $name ) {

    $this->log_monitor( __FUNCTION__, $name );

    return $this->monitor_object->$name;

  }

  public function __set( $name, $value ) {

    $this->log_monitor( __FUNCTION__, $name );

    $this->monitor_object->$name = $value;

  }

  public function __isset( $name ) {

    $this->log_monitor( __FUNCTION__, $name );

    return isset( $this->monitor_object->$name );

  }

  public function __unset( $name ) {

    $this->log_monitor( __FUNCTION__, $name );

    unset( $this->monitor_object->$name );

  }

  public function __toString() {

    $this->log_monitor( __FUNCTION__ );

    return strval( $this->monitor_object );

  }

  public function __call( $name, $args ) {

    $this->log_monitor( __FUNCTION__, $name );

    return call_user_func_array( [ $this->monitor_object, $name ], $args );

  }
}
