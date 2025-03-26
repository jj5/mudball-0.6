<?php

class MudModelConstraintAddition extends MudModelConstraintChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::ADDITION;
  }
}
