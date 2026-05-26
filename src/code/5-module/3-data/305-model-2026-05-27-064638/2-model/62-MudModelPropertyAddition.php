<?php

class MudModelPropertyAddition extends MudModelPropertyChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::ADDITION;
  }
}
