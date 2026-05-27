<?php

class MudPdoLite_RAW extends MudPdoLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::RAW;
  }
}
