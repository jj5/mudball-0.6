<?php

interface IMudFacility {

  // 2022-04-08 jj5 - this was moved into Action...
  //
  //public function get_autoxsrf();

  public function get_selector_spec();

  //public function load_context( $request );

  public function can_query( $request );

  public function query( $request );

  public function render( $context );

}
