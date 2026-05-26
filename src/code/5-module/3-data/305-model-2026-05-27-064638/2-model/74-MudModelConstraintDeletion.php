<?php

class MudModelConstraintDeletion extends MudModelConstraintChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::DELETION;
  }
}
