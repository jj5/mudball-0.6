<?php

class mud_facility_content_test extends AppFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context, [ 'title' => 'Mudball Test Facility' ] );

      $this->render_nav_header( $context );

      tag_open( 'main' );

        tag_text( 'p', 'Hi there, this is test content.' );

      tag_shut( 'main' );

    $this->render_foot( $context );

  }

}

return new mud_facility_content_test();
