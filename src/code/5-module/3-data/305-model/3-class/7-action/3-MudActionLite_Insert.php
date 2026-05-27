<?php

class MudActionLite_Insert extends MudActionLite_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::INSERT;
  }
}
