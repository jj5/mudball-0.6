<?php

class mud_action_util_user_logout extends MudAction {

  public function process( $request, $response ) {

    // 2022-04-06 jj5 - TODO: auth event logging

    app_session()->set_user( app_null_object() );

    app_orm()->save();

    app_trn()->checkpoint();

    app_session()->flash( "Logged out." );

    app_response()->redirect( app_url()->get_abs( '/home' ) );

    return true;

  }
}

return new mud_action_util_user_logout();
