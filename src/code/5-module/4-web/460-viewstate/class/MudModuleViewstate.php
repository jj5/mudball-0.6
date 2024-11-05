<?php

class MudModuleViewstate extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_view_state( array $state = [] ) {

    return new MudViewState( $state );

  }
}