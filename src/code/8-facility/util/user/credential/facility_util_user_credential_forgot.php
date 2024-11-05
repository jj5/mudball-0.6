<?php

class mud_facility_util_user_credential_forgot extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context );

      $this->render_form_credential_forgot( $context );

    $this->render_foot( $context );

  }

  public function render_form_credential_forgot( $context ) {

    tag_open( 'form', [ 'method' => 'POST' ] );

      $this->render_input_hidden( $context, APP_INPUT_ACTION_DEFAULT, ACTION_UTIL_USER_CREDENTIAL_FORGOT );

      $this->render_input_email( $context, APP_INPUT_EMAIL_ADDRESS );

      $this->render_button_submit( $context, ACTION_UTIL_USER_CREDENTIAL_FORGOT );

    tag_shut( 'form' );

  }
}

return new mud_facility_util_user_credential_forgot();
