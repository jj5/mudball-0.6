<?php

class MudActionLite_Schema extends MudActionLite_Statement {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::SCHEMA;
  }
}
