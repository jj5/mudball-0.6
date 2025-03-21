<?php

interface IMudObject extends Stringable {

  public function is_live() : bool;

  public function is_valid( mixed $options = null ) : bool;

  public function to_string() : string;

  public function to_html( mixed $format = null ) : string;

  public function to_nbsp( mixed $format = null ) : string;

  // 2024-07-01 jj5 - IMudNode objects will implement this, others will stub it out...
  //
  public function set_parent( IMudNode $parent ) : void;

  public function format( mixed $spec = null ) : string;

  public function get_format( mixed $spec = null ) : mixed;

  public function get_format_default() : mixed;

  public function render( mixed $format = null, array $attrs = [] ) : void;

  public function validate( mixed $options = null ) : void;

}
