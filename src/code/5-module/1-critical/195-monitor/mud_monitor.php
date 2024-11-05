<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - include dependencies...
//

require_once __DIR__ . '/../190-pclog/mud_pclog.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/base/MudMonitor.php';

require_once __DIR__ . '/class/monitor/1-MudMonitorStandard.php';
require_once __DIR__ . '/class/monitor/2-MudMonitorArray.php';

require_once __DIR__ . '/class/MudModuleMonitor.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_monitor_array( $monitor_object ) {

  return mud_module_monitor()->new_mud_monitor_array( $monitor_object );

}

function new_mud_monitor_standard( $monitor_object ) {

  return mud_module_monitor()->new_mud_monitor_standard( $monitor_object );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - functional interface...
//

function mud_monitor( $object ) {

  return mud_module_monitor()->monitor( $object );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-06-17 jj5 - service locator...
//

function mud_module_monitor() : MudModuleMonitor {

  return mud_locator()->get_module( MudModuleMonitor::class );

}
