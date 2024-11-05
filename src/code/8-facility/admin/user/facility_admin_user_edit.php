<?php

class mud_facility_admin_user_edit extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context, [ 'title' => 'Just testing...' ] );

    tag_text( 'p', 'Hi there.' );

    $this->render_foot( $context );

  }

}

return new mud_facility_admin_user_edit();
