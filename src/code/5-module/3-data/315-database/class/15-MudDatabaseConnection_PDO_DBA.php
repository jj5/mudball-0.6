<?php

class MudDatabaseConnection_PDO_DBA extends MudDatabaseConnection {
  function get_connection_type() : MudDatabaseConnectionType { return MudDatabaseConnectionType::DBA; }
}
