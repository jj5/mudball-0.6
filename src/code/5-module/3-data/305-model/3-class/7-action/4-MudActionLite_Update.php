<?php

class MudActionLite_Update extends MudActionLite_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::UPDATE;
  }
}
