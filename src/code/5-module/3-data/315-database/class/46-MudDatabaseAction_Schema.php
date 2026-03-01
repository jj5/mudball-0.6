<?php

class MudDatabaseAction_Schema extends MudDatabaseAction_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::SCHEMA;
  }
}
