<?php

class MudDatabaseException extends MudException {

  public function is_retryable() {

    static $retryable = [ MUD_ERR_DATABASE_LOCK_WAIT_TIMEOUT_EXCEEDED ];

    if ( in_array( $this->getCode(), $retryable, $strict = true ) ) { return true; }

    return false;

  }
}
