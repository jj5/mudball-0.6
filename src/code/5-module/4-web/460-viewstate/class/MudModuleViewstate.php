<?php

class MudModuleViewstate extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_view_state( array $state = [] ) {

<<<<<<< HEAD
    return MudViewState::Create( $state );

  }
}
=======
    return new MudViewState( $state );

  }
}
>>>>>>> e3a066e (Work, work...)
