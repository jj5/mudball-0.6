<?php

abstract class MudValue extends MudHost implements IMudValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudValue interface...
  //

  public function is_zero() : bool { return $this->is_integer( 0 ); }

  // 2024-06-30 jj5 - NOTE: this is a useful default implementation...
  //
  public function get_sort_value() : int|float|string|null { return $this->get_db_value(); }

  // 2024-06-30 jj5 - NOTE: values don't have parents but we implement the Null Object Pattern here so we don't have
  // to check...
  //
  public function set_parent( IMudNode $parent ) : void { ; }

  public function render( mixed $format = null, array $attrs = [] ) : void {

    // 2024-06-30 jj5 - this won't work if the HTML module has not been loaded...

    // 2024-07-01 jj5 - TODO: define a constant to indicate if the HTML module has been loaded or not and then use that
    // do decide if we actually want to run this code or not.

    $class = $attrs[ 'class' ] ?? '';

    if ( $class ) { $class .= ' '; }

    $class .= 'value ' . get_class( $this );

    $attrs[ 'class' ] = $class;

    tag_text( 'span', $this->format( $format ), $attrs );

  }
}
