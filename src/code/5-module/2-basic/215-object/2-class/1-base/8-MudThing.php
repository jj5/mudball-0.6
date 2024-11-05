<?php

class MudThing extends MudNode implements IMudThing {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - private fields...
  //

  private IMudThing|null $parent = null;

  private array $child_list;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

  public function __construct( array $child_list = [] ) {

    foreach ( $child_list as $child ) {

      $child->set_parent( $this );

    }

    $this->child_list = $child_list;

  }
}
