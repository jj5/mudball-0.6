<?php

class mud_facility_admin_user_list extends AppFacility {

  public function get_selector_spec() { return []; }

  public function query( $context ) {

    return [
      'contact-method-id' => [ mud_new_client_id(), ],
      'contact-method-type' => [ 'email', ],
      'contact-method-detail' => [ '' ],
    ];

  }

  public function render( $context ) {

    $description = 'User List';
    $keywords = [ 'user', 'list', ];

    $tabindex = 1;

    $args = [
      'title' => $description,
      'description' => $description,
      'keywords' => $keywords,
    ];

    $this->render_head( $context, $args );

      $this->render_nav_header( $context );

      tag_open( 'main' );

        tag_text( 'h1', 'User List' );


      tag_shut( 'main' );

    $this->render_foot( $context );

  }
}

return new mud_facility_admin_user_list();
