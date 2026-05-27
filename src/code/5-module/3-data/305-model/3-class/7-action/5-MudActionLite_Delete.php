<?php

class MudActionLite_Delete extends MudActionLite_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::DELETE;
  }
}
