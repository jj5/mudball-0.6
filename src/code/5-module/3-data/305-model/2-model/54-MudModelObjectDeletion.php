<?php

abstract class MudModelObjectDeletion extends MudModelObjectChange {

  public function get_change_type() : MudModelChangeType {
    return MudModelChangeType::DELETION;
  }
}
