<?php

<<<<<<< HEAD
abstract class MudNode extends MudHost implements IMudNode {

  private IMudNode|null $parent = null;

  public function get_parent() : IMudNode {

    return $this->parent ?? mud_null_object();
=======
class MudNode extends MudHost implements IMudHost {

  public function get_closest( string $class ) : IMudNode {

    if ( $this instanceof $class ) { return $this; }

    return $this->get_ancestor( $class );

  }

  private IMudNode|null $parent = null;

  public function get_parent( string|null $class = null ) : IMudNode {

    if ( $class === null ) {

      return $this->parent ?? $this->get_null();

    }

    if ( $this->parent instanceof $class ) { return $this->parent; }

    return $this->get_null();
>>>>>>> e3a066e (Work, work...)

  }

  public function set_parent( IMudNode $parent ) : void {

    $this->parent = $parent;

  }

<<<<<<< HEAD
  public function get_grandparent() : IMudNode {

    return $this->get_parent()->get_parent();

  }

  public function get_ancestor( string $class ) : IMudNode {
=======
  public function get_grandparent( string|null $class = null ) : IMudNode {

    return $this->get_parent()->get_parent( $class );

  }

  public function get_ancestor( string|null $class = null ) : IMudNode {
>>>>>>> e3a066e (Work, work...)

    $ancestor = $this->get_parent();

    while ( ! $ancestor->is_null() ) {

      if ( $ancestor instanceof $class ) { return $ancestor; }

      $ancestor = $ancestor->get_parent();

    }

<<<<<<< HEAD
    return mud_null_object();
  
  }

  public function get_root() : IMudNode {

    $curr = $this;

    while ( ! $curr->get_parent()->is_null() ) {

      $curr = $curr->get_parent();

    }

    return $curr;
=======
    return $this->get_null();
  
  }

  public function get_root( string|null $class = null ) : IMudNode {

    $root = $this;

    while ( ! $root->is_null() ) {

      $root = $root->get_parent();

    }

    if ( $class === null ) { return $root; }

    if ( $root instanceof $class ) { return $root; }

    return $this->get_null();
>>>>>>> e3a066e (Work, work...)

  }
}
