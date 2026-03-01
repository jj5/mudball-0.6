<?php

class MudDatabaseConnection_PDO_RAW extends MudDatabaseConnection {
  function get_connection_type() : MudDatabaseConnectionType { return MudDatabaseConnectionType::RAW; }
  protected function initialize() {
    parent::initialize();
    $sql = "
      insert into t_abinitio_std_interaction () values ()
    ";
    $this->exec( $sql );
    $this->set_a_std_interaction_aid( $this->get_auto_increment_id() );
    echo "raw interactions:\n";
    $interaction_list = $this->query( "select * from t_abinitio_std_interaction" );
    var_dump( $interaction_list );
  }
}
