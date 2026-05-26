<?php

abstract class MudModelObjectModification extends MudModelObjectChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::MODIFICATION;
  }
}
