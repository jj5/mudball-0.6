<?php

abstract class MudObject extends MudGadget implements IMudObject {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - Stringable interface...
  //

  public function __toString() : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-01 jj5 - IMudObject interface...
  //

  public function is_valid( mixed $options = null ) : bool { return true; }

  public function to_string() : string { return get_class( $this ); }

  public function to_html( mixed $format = null ) : string {

    return $this->henc( $this->format( $format ) );

  }

  public function to_nbsp( mixed $format = null ) : string {

    return str_replace( ' ', '&nbsp;', $this->to_html( $format ) );

  }

  // 2024-07-01 jj5 - IMudNode objects will implement this, others will stub it out...
  //
  public function set_parent( IMudNode $parent ) : void { ; }

  public function format( mixed $spec = null ) : string { return $this->to_string(); }

  public function get_format( mixed $spec = null ) : mixed { return $spec === null ? $this->get_format_default() : $spec; }

  public function get_format_default() : mixed { return $this->to_string(); }

  public function render( mixed $format = null, array $attrs = [] ) : void {
    
    tag_text( 'span', $this->format( $format ), $attrs );

  }

  public function validate( mixed $options = null ) : void {

    if ( $this->is_valid( $options ) ) { return; }

    mud_fail( MUD_ERR_OBJECT_STATE_INVALID, [ '$this' => $this, '$options' => $options ] );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - protected instance methods...
  //

  protected function henc( string $string ) : string {

    return htmlspecialchars( $string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8' );

  }
}
