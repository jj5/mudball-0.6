<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: this is the base class for all services in the system. Services are simply objects that are
// available through and managed by a service locator. This means that an instance of a service class is globally available
// to your PHP process. Services are designed to be used to provide a specific set of functionality to the system. A module
// can define zero or more services.

// 2024-02-09 jj5 - NOTE: there are two service classes in this module: MudFactory and MudLocator. Check out the
// implementation of these classes and their service locator functions to see how to define, manage, and use services in
// your application.

abstract class MudService extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - private static fields...
  //

  private static array $service_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - constructor...
  //

  public function __construct( MudService|null $previous ) {

    parent::__construct();

    $class = get_class( $this );

    self::$service_map[ $class ] = $this;

  }
}
