<?php

abstract class MudPdoLite extends PDO {

  use MudCreationMixin;

  abstract public function get_connection_type() : MudConnectionTypeLite;

}
