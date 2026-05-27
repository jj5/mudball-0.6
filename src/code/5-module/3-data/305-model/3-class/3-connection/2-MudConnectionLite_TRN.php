<?php

class MudConnectionLite_TRN extends MudConnectionLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::TRN;
  }
}
