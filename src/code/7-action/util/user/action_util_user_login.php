<?php

class mud_action_util_user_login extends MudAction {

  public function process( $request, $response ) {

    // 2022-04-06 jj5 - TODO: auth event logging

    $username = $request->get_value( APP_INPUT_USERNAME );
    $password = $request->get_value( APP_INPUT_PASSWORD );

    $user = app_orm()->get_mud_user([
      A_STD_USER_USERNAME => $username
    ]);

    if ( $user->is_missing() ) {

      $response->set_error( APP_INPUT_PASSWORD, 'Invalid username or password.' );

      return $request->get_submission();

    }

    $password_hash = $user[ A_STD_USER_PASSWORD_HASH ];

    if ( ! mud_password_verify( $password, $password_hash ) ) {

      $response->set_error( APP_INPUT_PASSWORD, 'Invalid username or password.' );

      return $request->get_submission();

    }

    app_session()->set_user( $user );

    app_orm()->save();

    app_trn()->checkpoint();

    app_session()->flash( "Login successful." );

    app_response()->redirect( app_url()->get_abs( '/home' ) );

    return true;



    mud_dump( $user );

    if ( ! app_raw()->is_online() ) {

      $request->set_error( A_STD_ACTION, 'Database is offline, please try again later.' );

      return $request->get_submission();

    }

    $request->redirect( app_url()->get_rel( '/home' ) );

  }
}

return new mud_action_util_user_login();
