<?php

class MudDatabaseAction_Insert extends MudDatabaseAction_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::INSERT;
  }
}
