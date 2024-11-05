<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - errors...
//

mud_define_error( 'MUD_ERR_ACTION_CREDENTIAL_RESET_EMAIL_MISSING', 'credential reset from email missing.' );
mud_define_error( 'MUD_ERR_ACTION_CREDENTIAL_RESET_EMAIL_NOT_SENT', 'credential reset email not sent.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - class definition...
//

class mud_action_util_user_credential_forgot extends MudAction {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function process( $request, $response ) {

    $email = app_reader()->read( A_STD_EMAIL_ADDRESS );

    if ( $response->has_errors() ) { return $request->get_submission(); }

    $user = app_trn()->get_row_t_entity_mud_user_by_email_address( $email );

    if ( $user ) {

      $user_id = $user[ A_STD_USER_ID ];

      $token = mud_new_token();

      $token_id = app_raw()->add_row_t_particle_mud_token( $token );

      $credential_reset_id = app_raw()->new_internal_id();

      $interaction_id = app()->get_interaction_id();

      $credential_reset_history_id = app_trn()->add_row_t_history_mud_user_credential_reset(
        $interaction_id,
        MudCrud::CREATE,
        $credential_reset_id,
        $user_id,
        $token_id
      );

      app_trn()->add_row_t_entity_mud_user_credential_reset(
        $credential_reset_id,
        $credential_reset_history_id,
        $user_id,
        $token_id
      );

      $this->send_reset_email( $email, $token );

    }

    app()->success(
      "Password reset processed for $email. Check your inbox for a reset link. " .
      "If you don't find an email in your inbox (check your junk folder too) you might need to " .
      "confirm you have nominated the correct email address for your account."
    );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - protected methods...
  //

  protected function send_reset_email( $to, $token ) {

    $subject = mud_get_config( [ 'app', 'password-reset', 'subject' ], 'Password Reset' );
    $from = mud_get_config( [ 'app', 'password-reset', 'from' ] );

    if ( ! $from ) {

      mud_fail( MUD_ERR_ACTION_CREDENTIAL_RESET_EMAIL_MISSING );

    }

    $headers = mud_format_headers([
      'MIME-Version' => '1.0',
      'Content-Type' => 'text/html; charset=UTF-8',
      'From' => $from,
      'Reply-To' => $from,
      'X-Mailer' => 'PHP/' . phpversion(),
    ]);

    $link = app_url()->get_abs( "/util/user/credential/reset/$token" );

    $message = trim("
<html><body>
<h1>Password Reset</h1>
<p>Reset your password here: <a href='$link'>$link</a></p>
</body></html>
");

    if ( mail( $to, $subject, $message, $headers ) ) { return true; }

    mud_fail( MUD_ERR_ACTION_CREDENTIAL_RESET_EMAIL_NOT_SENT );

  }
}

return new mud_action_util_user_credential_forgot();
