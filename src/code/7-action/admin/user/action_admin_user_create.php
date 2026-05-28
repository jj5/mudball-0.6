<?php

class mud_action_admin_user_create extends MudAction {

  public function process( $request, $response ) {

    $username = $request->get_input( APP_INPUT_USERNAME );
    $password = $request->get_input( APP_INPUT_PASSWORD );
    $password_confirm = $request->get_input( APP_INPUT_PASSWORD_CONFIRM );

    if ( $password !== $password_confirm ) {

      $response->set_error( APP_INPUT_PASSWORD_CONFIRM, 'passwords do not match.' );

    }

    // 2026-05-28 jj5 - TODO: validate contact method details...
    //$response->set_list_error( 'contact-method-detail', 2, 'contact method details are required.' );

    if ( $response->has_errors() ) {

      return $request->get_submission();

    }

    for ( $attempt = 0; $attempt < 100; $attempt++ ) {

      $user_iid = mud_new_iid();

    }

    var_dump( $user_iid ); exit;

    $sql = "
      insert into t_std_user ( a_std_user_username, a_std_user_password_hash )
      values ( ?, ? )
    ";

  }
}

return new mud_action_admin_user_create();
