<?php

class MudConnectionLite_DBA extends MudConnectionLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::DBA;
  }
}
