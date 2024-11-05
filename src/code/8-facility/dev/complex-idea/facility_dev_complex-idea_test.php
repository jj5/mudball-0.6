<?php

class mud_facility_dev_complex_idea_test extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context );

      tag_text( 'p', 'This is complex, baby.' );

    $this->render_foot( $context );

  }
}

return new mud_facility_dev_complex_idea_test();
