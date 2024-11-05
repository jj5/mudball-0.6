<?php

class MudModuleWebcontext extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_web_context( $request, $response, $view_state ) {

    return MudWebContext::Create( $request, $response, $view_state );

  }
}
