<?php

class MudDatabaseAction_Update extends MudDatabaseAction_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::UPDATE;
  }
}
