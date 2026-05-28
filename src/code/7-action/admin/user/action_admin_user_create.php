<?php

class mud_action_admin_user_create extends MudAction {

  public function process( $request, $response ) {

    //var_dump( $request ); exit;

    return [
      APP_INPUT_USERNAME => $request->get_input( APP_INPUT_USERNAME ),
    ];

  }
}

return new mud_action_admin_user_create();
