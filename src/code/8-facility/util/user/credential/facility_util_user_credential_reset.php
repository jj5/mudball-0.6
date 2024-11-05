<?php

class mud_facility_util_user_credential_reset extends MudFacility {

  public function get_selector_spec() { return [ APP_INPUT_TOKEN ]; }

  public function query( $request ) {

    $token = $request->get_criterion( APP_INPUT_TOKEN );

    $token_id = app_raw()->get_a_std_token_id_by_token( $token );

    $user_credential_reset = app_orm()->get_mud_user_credential_reset([
      A_STD_USER_CREDENTIAL_RESET_TOKEN_ID => $token_id,
    ]);

    $user_id = $user_credential_reset[ A_STD_USER_CREDENTIAL_RESET_USER_ID ];

    $user = app_orm()->get_mud_user([
      A_STD_USER_ID => $user_id
    ]);

    $email_address = $user[ A_STD_USER_EMAIL_ADDRESS ];

    return [
      APP_INPUT_EMAIL_ADDRESS => $email_address,
    ];

  }

  public function render( $context ) {

    $this->render_head( $context );

      $this->render_form_credential_reset( $context );

    $this->render_foot( $context );

  }

  public function render_form_credential_reset( $context ) {

    tag_open( 'form', [ 'method' => 'POST' ] );

      $this->render_input_hidden( $context, APP_INPUT_ACTION_DEFAULT, APP_ACTION_UTIL_USER_CREDENTIAL_RESET );
      $this->render_input_hidden( $context, APP_INPUT_TOKEN, $context->get_criterion( APP_INPUT_TOKEN ) );

      $email_address = $context[ APP_INPUT_EMAIL_ADDRESS ];

      $this->render_input(
        $context,
        MUD_HTML_INPUT_TYPE_EMAIL,
        APP_INPUT_EMAIL_ADDRESS,
        $email_label = null,
        $email_placeholder = null,
        $email_id = null,
        $email_address,
        [
          'readonly' => true,
        ]
      );

      $this->render_input_password( $context, APP_INPUT_PASSWORD );
      $this->render_input_password( $context, APP_INPUT_PASSWORD_CONFIRM );

      $this->render_button_submit( $context, APP_ACTION_UTIL_USER_CREDENTIAL_RESET );

    tag_shut( 'form' );

  }
}

return new mud_facility_util_user_credential_reset();
