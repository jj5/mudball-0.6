<?php

class MudDatabaseConnection_PDO_AUX extends MudDatabaseConnection {
  function get_connection_type() : MudDatabaseConnectionType { return MudDatabaseConnectionType::AUX; }
}
