<?php

class MudConnectionLite_AUX extends MudConnectionLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::AUX;
  }
}
