<?php


<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
/////////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
// 2021-06-17 jj5 - class definition...
//

class MudModuleMonitor extends MudModuleCritical {


<<<<<<< HEAD
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleMonitor|null $previous = null) {

    parent::__construct( $previous );

  }


>>>>>>> e3a066e (Work, work...)
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_monitor_array( $monitor_object ) {

<<<<<<< HEAD
    return MudMonitorArray::Create( $monitor_object );
=======
    return new MudMonitorArray( $monitor_object );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_monitor_standard( $monitor_object ) {

<<<<<<< HEAD
    return MudMonitorStandard::Create( $monitor_object );
=======
    return new MudMonitorStandard( $monitor_object );
>>>>>>> e3a066e (Work, work...)

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2021-06-17 jj5 - public interface...
  //

  public function monitor( $object ) {

    if ( is_array( $object ) || is_a( $object, 'ArrayAccess' ) ) {

      return $this->new_mud_monitor_array( $object );

    }

    return $this->new_mud_monitor_standard( $object );

  }
}
