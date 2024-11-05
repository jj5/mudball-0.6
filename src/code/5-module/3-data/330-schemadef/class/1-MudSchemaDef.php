<?php

class MudSchemaDef extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public fields...
  //

  public $tab_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public methods...
  //

  public function get_schemata( $rev_map ) {

    $schemata = new_mud_schemata( $rev_map );

    foreach ( $this->tab_map as $tab_def ) {

      $tab_def->create_tab( $schemata );

    }

    return $schemata;

  }
}
