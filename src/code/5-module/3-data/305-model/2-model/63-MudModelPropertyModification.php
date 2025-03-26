<?php

class MudModelPropertyModification extends MudModelPropertyChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::MODIFICATION;
  }
}
