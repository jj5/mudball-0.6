<?php

class MudDatabaseConnection_PDO_EMU extends MudDatabaseConnection {
  function get_connection_type() : MudDatabaseConnectionType { return MudDatabaseConnectionType::EMU; }
}
