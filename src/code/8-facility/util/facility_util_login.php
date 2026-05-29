<?php

class mud_facility_util_login extends AppFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $args = [
      'title' => 'Login',
      'description' => 'User login page.',
      'keywords' => [ 'login', 'user', ],
    ];

    $this->render_head( $context, $args );

      $this->render_nav_header( $context );

      tag_open( 'main' );

        tag_text( 'h1', 'Login' );

        $this->render_form( $context );

      tag_shut( 'main' );

    $this->render_foot( $context );

  }

  public function render_form( $context ) {

    tag_open( 'form', [ 'method' => 'POST' ] );

      $this->render_input_hidden( $context, APP_INPUT_ACTION_DEFAULT, APP_ACTION_UTIL_LOGIN );

      $this->render_input_email( $context, APP_INPUT_EMAIL_ADDRESS );

      $this->render_input_password( $context, APP_INPUT_PASSWORD );

      $this->render_button_submit( $context, APP_ACTION_UTIL_LOGIN );

    tag_shut( 'form' );

  }
}

return new mud_facility_util_login();
