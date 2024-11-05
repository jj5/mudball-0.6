<?php

class MudViewState extends MudGadget implements ArrayAccess {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - protected fields...
  //

  protected array $state;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - constructor...
  //

  public function __construct( array $state = [] ) {

    $this->state = $state;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - ArrayAccess interface...
  //

  public function offsetExists( mixed $property ): bool {

    return array_key_exists( $property, $this->state );

  }

  public function offsetGet( mixed $property ): mixed {

    return $this->state[ $property ];

  }

  public function offsetSet( mixed $property, mixed $value ): void {

    mud_not_supported();

  }

  public function offsetUnset( mixed $property ): void {

    mud_not_supported();

  }
}
