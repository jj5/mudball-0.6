<?php

class MudModelPropertyDeletion extends MudModelPropertyChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::DELETION;
  }
}
