<?php

class MudDatabaseAction_Delete extends MudDatabaseAction_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::DELETE;
  }
}
