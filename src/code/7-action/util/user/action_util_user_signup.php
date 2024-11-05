<?php

class mud_action_util_user_signup extends MudAction {

  public function process( $request, $response ) {

    mud_dump( $request );

  }
}

return new mud_action_util_user_signup();
