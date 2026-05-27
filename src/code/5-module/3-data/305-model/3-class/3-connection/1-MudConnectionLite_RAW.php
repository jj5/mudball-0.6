<?php

class MudConnectionLite_RAW extends MudConnectionLite {

  public function get_connection_type() : MudConnectionTypeLite {
    return MudConnectionTypeLite::RAW;
  }
}
