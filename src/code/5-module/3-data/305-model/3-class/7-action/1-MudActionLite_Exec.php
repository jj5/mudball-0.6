<?php

class MudActionLite_Exec extends MudActionLite {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::EXEC;
  }

  public function execute() : int|false {
    //$sql = $this->connection->dedent( $this->sql );
    return $this->connection->exec( $this->sql );
    //$records_affected = $this->connection->get_pdo()->exec( $this->sql );
  }
}
