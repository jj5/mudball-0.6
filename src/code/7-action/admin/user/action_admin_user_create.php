<?php

class mud_action_admin_user_create extends MudAction {

  public function process( $request, $response ) {

    if ( true ) {

      $response->set_error( APP_INPUT_PASSWORD_CONFIRM, 'passwords do not match.' );

    }

    $response->set_list_error( 'contact-method-detail', 2, 'contact method details are required.' );

    if ( $response->has_errors() ) {

      return $request->get_submission();

    }

    return [
      APP_INPUT_USERNAME => $request->get_input( APP_INPUT_USERNAME ),
    ];

  }
}

return new mud_action_admin_user_create();
