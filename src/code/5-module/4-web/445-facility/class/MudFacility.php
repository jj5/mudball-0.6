<?php

abstract class MudFacility extends MudGadget implements IMudFacility {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - triats...
  //

  use MudViewForms;
  use MudViewTemplate;


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-05 jj5 - public instance methods...
  //

  abstract function get_selector_spec();

  public function can_query( $request ) { return true; }

  public function query( $request ) { return new_mud_view_state(); }

  public function render( $context ) {

    mud_fail(
      BOM_ERR_FACILITY_CANNOT_RENDER,
      [ 'facility' => get_class( $this ), ]
    );

  }
}
