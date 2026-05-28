<?php

class mud_facility_util_login extends AppFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context );

      $this->render_form_login( $context );

    $this->render_foot( $context );

  }

  public function render_form_login( $context ) {

    tag_open( 'form', [ 'method' => 'POST' ] );

      $this->render_input_hidden( $context, APP_INPUT_ACTION_DEFAULT, APP_ACTION_UTIL_LOGIN );

      $this->render_input_email( $context, APP_INPUT_EMAIL_ADDRESS );

      $this->render_button_submit( $context, APP_ACTION_UTIL_LOGIN );

    tag_shut( 'form' );

  }
}

return new mud_facility_util_login();
