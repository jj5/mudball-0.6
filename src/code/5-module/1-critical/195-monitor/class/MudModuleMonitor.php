<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - class definition...
//

class MudModuleMonitor extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_monitor_array( $monitor_object ) {

    return MudMonitorArray::Create( $monitor_object );

  }

  public function new_mud_monitor_standard( $monitor_object ) {

    return MudMonitorStandard::Create( $monitor_object );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-06-17 jj5 - public interface...
  //

  public function monitor( $object ) {

    if ( is_array( $object ) || is_a( $object, 'ArrayAccess' ) ) {

      return $this->new_mud_monitor_array( $object );

    }

    return $this->new_mud_monitor_standard( $object );

  }
}
