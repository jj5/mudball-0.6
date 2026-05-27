<?php

class MudPdoLite_TRN extends MudPdoLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::TRN;
  }
}
