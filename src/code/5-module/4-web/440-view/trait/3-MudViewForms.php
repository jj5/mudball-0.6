<?php

trait MudViewForms {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - triats...
  //

  use MudViewMixin;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function render_form_signup( $context ) {

    $this->render_form_open( $context, APP_FORM_SIGNUP, APP_ACTION_UTIL_USER_SIGNUP );

      //$this->render_input_email( $context, APP_INPUT_EMAIL_ADDRESS );
      $this->render_input_text( $context, APP_INPUT_USERNAME );
      $this->render_input_password( $context, APP_INPUT_PASSWORD );
      $this->render_input_password( $context, APP_INPUT_PASSWORD_CONFIRM );
      $this->render_button_submit( $context, APP_ACTION_UTIL_USER_SIGNUP );

    $this->render_form_shut( $context );

  }

  public function render_form_login( $context ) {

    $this->render_form_open( $context, APP_FORM_LOGIN, APP_ACTION_UTIL_USER_LOGIN );

      $this->render_input_text( $context, APP_INPUT_USERNAME );
      $this->render_input_password( $context, APP_INPUT_PASSWORD );
      $this->render_button_submit( $context, APP_ACTION_UTIL_USER_LOGIN );

    $this->render_form_shut( $context );

  }

  public function render_form_logout( $context ) {

    $this->render_form_open( $context, APP_FORM_LOGOUT, APP_ACTION_UTIL_USER_LOGOUT );

      $this->render_button_submit( $context, APP_ACTION_UTIL_USER_LOGOUT, 'Logout' );

    $this->render_form_shut( $context );

  }

  public function render_form_credential_forgot( $context ) {

    $this->render_form_open( $context, APP_FORM_CREDENTIAL_FORGOT, APP_ACTION_UTIL_USER_CREDENTIAL_FORGOT );

      $this->render_input_email( $context, APP_INPUT_EMAIL_ADDRESS );
      $this->render_button_submit( $context, APP_ACTION_UTIL_USER_CREDENTIAL_FORGOT );

    $this->render_form_shut( $context );

  }

  public function render_form_complex_idea( $context ) {

    $this->render_form_open( $context, 'complex-idea', APP_ACTION_DEV_COMPLEX_IDEA_TEST );

      $this->render_input_text( $context, APP_INPUT_USERNAME );
      $this->render_button_submit( $context, APP_ACTION_DEV_COMPLEX_IDEA_TEST );

    $this->render_form_shut( $context );

  }
}
