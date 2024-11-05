<?php

class mud_action_util_user_credential_reset extends MudAction {

  public function process( $request, $response ) {

    $token = app_reader()->read( A_STD_TOKEN );
    $password = app_reader()->read( A_STD_PASSWORD );
    $password_confirm = app_reader()->read( A_STD_PASSWORD_CONFIRM );

    if ( $password !== $password_confirm ) {

      $response->set_error( APP_INPUT_PASSWORD_CONFIRM, 'passwords do not match.' );

    }

    if ( $response->has_errors() ) {

      return $request->get_submission();

    }

    $token_id = app_raw()->get_a_std_token_id_by_token( $token );

    if ( ! $token_id ) { return $this->invalid_token( $request ); }

    $credential_reset = app_trn()->get_row_t_entity_mud_user_credential_reset_by_token_id( $token_id );

    if ( ! $credential_reset ) { return $this->invalid_token( $request ); }

    //mud_dump( $credential_reset );

    $user_id = $credential_reset[ A_STD_USER_CREDENTIAL_RESET_USER_ID ];

    if ( ! $user_id ) { return $this->invalid_token( $request ); }

    //mud_dump( $user_id );

    $password_hash = mud_password_hash( $password );

    //$password_hash_id = app_raw()->add_row_t_particle_mud_password_hash( $password_hash );

    //mud_dump( $password_hash_id );

    $user = app_orm()->get_mud_user( $user_id );

    $user[ A_STD_USER_PASSWORD_HASH ] = $password_hash;

    //var_dump( $credential_reset );

    app_orm()->save();

    app_trn()->checkpoint();

    app_session()->flash( "Password reset successful." );

    app_response()->redirect( app_url()->get_abs( '/home' ) );

  }

  protected function invalid_token( $request, $response ) {

    $response->set_error( APP_INPUT_TOKEN, 'invalid token.' );

    return $request->get_submission();

  }
}

return new mud_action_util_user_credential_reset();
