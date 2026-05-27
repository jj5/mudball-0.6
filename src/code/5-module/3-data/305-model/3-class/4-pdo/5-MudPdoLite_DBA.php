<?php

class MudPdoLite_DBA extends MudPdoLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::DBA;
  }
}
