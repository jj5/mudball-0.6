<?php

function ka_is_valid_name( string $name ) : bool {

  return (bool)preg_match( '/^[a-z][[a-z0-9_]*$/i', $name );

}
