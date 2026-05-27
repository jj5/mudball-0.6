<?php

class MudPdoLite_AUX extends MudPdoLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::AUX;
  }
}
