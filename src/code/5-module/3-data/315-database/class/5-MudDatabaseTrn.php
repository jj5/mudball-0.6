<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - class definition...
//
//

class MudDatabaseTrn extends MudDatabase {

  public function __construct( array $args = [] ) {

    parent::__construct( MUD_CONNECTION_TYPE_TRN, $args );

  }
}
