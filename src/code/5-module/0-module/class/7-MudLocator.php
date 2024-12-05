<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: the MudLocator is the service locator for the system. It is used to manage the services (including
// modules) in the system. It provides specific support for managing the factory and the locator services, and general
// support for managing modules and other services. The MudLocator is the primary way that modules and services are accessed
// and managed in the system. See mud_module.php and the mud_module_standard() function for an example of how to use this
// class to manage a module; services are managed in a similar way, see mud_factory() and mud_locator() for examples.

class MudLocator extends MudService {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - private fields...
  //

  private array $module_map = [];

  private array $module_indicator_map = [];

  private array $service_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - public methods...
  //

  public function get_factory() : MudFactory {

    return mud_factory();

  }

  public function set_factory( MudFactory $factory ) {

    mud_factory( $factory );

  }

  public function get_locator() : MudLocator {

    return mud_locator();

  }

  public function set_locator( MudLocator $locator ) {

    mud_locator( $locator );

  }

  public function has_module( string $module_indicator ) : bool {

    $module_name = $this->get_module_name( $module_indicator );

    return array_key_exists( $module_name, $this->module_map );

  }

  public function get_module( string $module_indicator ) {

    $module = $this->module_indicator_map[ $module_indicator ] ?? null;

    if ( $module ) { return $module; }

    $module_name = $this->get_module_name( $module_indicator );

    $module = $this->module_map[ $module_name ] ?? null;

    if ( $module === null ) {

      $module = $this->get_factory()->create_module( $module_name );

      $this->module_map[ $module_name ] = $module;

    }

    $this->module_indicator_map[ $module_indicator ] = $module;

    return $module;

  }

  public function set_module( string $module_indicator, MudModule $module ) {

    $module_name = $this->get_module_name( $module_indicator );

    $this->module_map[ $module_name ] = $module;

  }

  public function manage_module( string $module_indicator, MudModule|false $module ) {

    if ( $module !== false ) {

      $this->set_module( $module_indicator, $module );

    }

    return $this->get_module( $module_indicator );

  }

  public function has_service( string $service_indicator ) : bool {

    $service_name = $this->get_service_name( $service_indicator );

    return array_key_exists( $service_name, $this->service_map );

  }

  public function get_service( string $service_indicator ) : object {

    $service_name = $this->get_service_name( $service_indicator );

    $service = $this->service_map[ $service_name ] ?? null;

    if ( $service === null ) {

      $service = $this->get_factory()->create_service( $service_name );

      $this->service_map[ $service_name ] = $service;

    }

    return $service;

  }

  public function set_service( string $service_indicator, MudService $service ) {

    $service_name = $this->get_service_name( $service_indicator );

    $this->service_map[ $service_name ] = $service;

  }

  public function manage_service( string $service_indicator, MudService|false $service ) {

    if ( $service !== false ) {

      $this->set_service( $service_indicator, $service );

    }

    return $this->get_service( $service_indicator );

  }

  public function get_module_name( string $indicator ) : string {

    return $this->get_name( $indicator );

  }

  public function get_service_name( string $indicator ) : string {

    return $this->get_name( $indicator );

  }

  public function get_name( string $indicator ) : string {

    // 2024-02-15 jj5 - we might relax this requirement in future, but for now it seems like this might be a good idea...
    //
    assert( class_exists( $indicator ), "class '$indicator' does not exist." );

    // 2024-02-15 jj5 - the $indicator is usually just a class name, like MudModuleDatabase or AppOrm.

    // 2024-02-15 jj5 - the service/module name is the name of the class sans the 'Mud' or 'App' prefix...

    if (
      preg_match( '/^Mud[A-Z]/', $indicator ) ||
      preg_match( '/^App[A-Z]/', $indicator )
    ) {

      return substr( $indicator, 3 );

    }

    return $indicator;

  }
}
