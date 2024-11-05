<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - class definition...
//

// 2024-02-09 jj5 - NOTE: the MudGadget class is the base class for pretty much everything in the mudball system. It
// provides a number of useful features that are common to all objects in the system, such as logging, tracing, and
// debugging. It also provides a simple object identifier (oid) that can be used to uniquely identify objects in the
// system.

// 2024-02-09 jj5 - NOTE: the MudGadget class is also the base class for the MudModule and MudService classes, which are
// the two main types of objects in the mudball system. The MudModule class is used to define the module classes in the
// system and the MudService class is used to define the services in the system. The MudModule and MudService classes are
// designed to be extended by this library to define the modules and services available in the library. These modules and
// services can then be further specialized and used to build an application.

// 2024-02-09 jj5 - NOTE: if you can't inherit from MudGadget because you're inheriting from another class, then you
// can use the MudMixin trait to include most of the functionality of MudGadget in your class.

// 2024-02-09 jj5 - NOTE: one advantage of using the MudGadget class as the base class for everything in the system is that
// it has logic to detect when the constructor for an object has not been called. This is useful for debugging because
// forgetting to call the parent constructor is a common cause of bugs in PHP code.

abstract class MudGadget extends MudGadgetBase {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - include the mixin...
  //

  use MudMixin;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-23 jj5 - private static fields...
  //

  private static int $log_depth = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - private fields...
  //

  private bool $is_constructed = false;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - constructor...
  //

  public function __construct() {

    // 2024-07-23 jj5 - NOTE: object IDs are out until we have a specific use case for them.
    //$this->set_oid( self::new_oid() );

    $this->count_increment();

    $this->is_constructed = true;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - destructor...
  //

  public function __destruct() {

    if ( mud_is_debug() ) {

      if ( ! $this->is_constructed ) {

        $class = get_class( $this );

        mud_fail( "constructor not called for object '$class'." );

      }
    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - process tracing...
  //

  protected function trace_init( string $message, mixed $context = null ) : int {

    if ( self::$log_depth < 0 ) { self::$log_depth = 0; }

    $this->trace( $message, $context );

    self::$log_depth++;

    return self::$log_depth;

  }

  protected function trace_done( string $message, mixed $context = null ) : int {

    if ( self::$log_depth > 0 ) { self::$log_depth--; }

    $this->trace( $message, $context );

    return self::$log_depth;

  }

  protected function trace( string $message, mixed $context = null ) : void {

    $pad = str_repeat( ' ', self::$log_depth * 2 );

    $log = $this->format_log_string( $message, $context, $pad );

    if ( function_exists( 'mud_stderr' ) ) {

      mud_stderr( "$log\n" );

    }
    else {

      error_log( $log );

    }
  }
}
