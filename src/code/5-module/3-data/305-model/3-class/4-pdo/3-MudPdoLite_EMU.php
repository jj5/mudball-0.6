<?php

class MudPdoLite_EMU extends MudPdoLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::EMU;
  }
}
