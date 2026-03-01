<?php

trait MudDatabaseValidation {

  public function validate_name( string $name ) : void {
    if ( preg_match( '/^[a-zA-Z][a-zA-Z0-9_]+$/', $name ) ) { return; }
    throw new InvalidArgumentException( "Invalid name: " . $name );
  }
}
