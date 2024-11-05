<?php

class mud_action_complex_idea_test extends MudAction {

  public function process( $request, $response ) {

    mud_dump( $request );

  }
}

return new mud_action_complex_idea_test();
