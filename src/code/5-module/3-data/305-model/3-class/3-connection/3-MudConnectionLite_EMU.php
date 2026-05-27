<?php

class MudConnectionLite_EMU extends MudConnectionLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::EMU;
  }
}
