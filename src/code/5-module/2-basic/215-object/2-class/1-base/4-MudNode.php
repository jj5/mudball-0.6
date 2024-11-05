<?php

abstract class MudNode extends MudHost implements IMudNode {

  private IMudNode|null $parent = null;

  public function get_parent() : IMudNode {

    return $this->parent ?? mud_null_object();

  }

  public function set_parent( IMudNode $parent ) : void {

    $this->parent = $parent;

  }

  public function get_grandparent() : IMudNode {

    return $this->get_parent()->get_parent();

  }

  public function get_ancestor( string $class ) : IMudNode {

    $ancestor = $this->get_parent();

    while ( ! $ancestor->is_null() ) {

      if ( $ancestor instanceof $class ) { return $ancestor; }

      $ancestor = $ancestor->get_parent();

    }

    return mud_null_object();
  
  }

  public function get_root() : IMudNode {

    $curr = $this;

    while ( ! $curr->get_parent()->is_null() ) {

      $curr = $curr->get_parent();

    }

    return $curr;

  }
}
