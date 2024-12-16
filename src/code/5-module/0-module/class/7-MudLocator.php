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

  private array $module_class_map = [];
  private array $module_name_map = [];

  private array $service_class_map = [];
  private array $service_name_map = [];


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

  public function get_module_name( string $class ) : string {

    return $this->get_name( $class );

  }

  public function has_module( string $module_class ) : bool {

    return $this->has_object( $module_class, $this->module_class_map, $this->module_name_map );

  }

  public function get_module( string $module_class ) {

    return $this->get_object( $module_class, $this->module_class_map, $this->module_name_map );

  }

  public function set_module( string $module_class, MudModule $module ) {

    $this->set_object( $module_class, $module, $this->module_class_map, $this->module_name_map );

  }

  public function manage_module( string $module_class, MudModule|false $module ) {

    if ( $module !== false ) {

      $this->set_module( $module_class, $module );

    }

    return $this->get_module( $module_class );

  }

  public function get_service_name( string $class ) : string {

    return $this->get_name( $class );

  }

  public function has_service( string $service_class ) : bool {

    return $this->has_object( $service_class, $this->service_class_map, $this->service_name_map );

  }

  public function get_service( string $service_class ) {

    return $this->get_object( $service_class, $this->service_class_map, $this->service_name_map );

  }

  public function set_service( string $service_class, MudModule $service ) {

    $this->set_object( $service_class, $service, $this->service_class_map, $this->service_name_map );

  }

  public function manage_service( string $service_class, MudModule|false $service ) {

    if ( $service !== false ) {

      $this->set_service( $service_class, $service );

    }

    return $this->get_service( $service_class );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-12-17 jj5 - protected methods...
  //

  protected function get_name( string $class ) : string {

    // 2024-02-15 jj5 - we might relax this requirement in future, but for now it seems like this might be a good idea...
    //
    assert( class_exists( $class ), "class '$class' does not exist." );

    // 2024-02-15 jj5 - the $class is usually just a class name, like MudModuleDatabase or AppOrm.

    // 2024-02-15 jj5 - the service/module name is the name of the class sans the 'Mud' or 'App' prefix...

    if (
      preg_match( '/^Mud[A-Z]/', $class ) ||
      preg_match( '/^App[A-Z]/', $class )
    ) {

      return substr( $class, 3 );

    }

    return $class;

  }

  protected function has_object( string $class, array $class_map, array $map ) : bool {

    if ( array_key_exists( $class, $class_map ) ) { return true; }

    $name = self::get_name( $class );

    return array_key_exists( $name, $map );

  }

  protected function get_object( string $class, array &$class_map, array &$map ) {

    $object = $class_map[ $class ] ?? null;

    if ( $object ) { return $object; }

    $name = self::get_name( $class );

    $object = $map[ $name ] ?? null;

    if ( $object === null ) {

      $object = $this->get_factory()->create_object( $class );

      $map[ $name ] = $object;

    }

    $class_map[ $class ] = $object;

    return $object;

  }

  protected function set_object( string $class, object $object, array &$class_map, array &$map ) {

    $name = self::get_name( $class );

    $map[ $name ] = $object;

    $class_map[ $class ] = $object;

  }
}
