<?php

// 2025-03-26 jj5 - THINK: I don't think we actually need constraint modifications...

class MudModelConstraintModification extends MudModelConstraintChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::MODIFICATION;
  }
}
