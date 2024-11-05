<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-07 jj5 - include dependencies...
//

require_once __DIR__ . '/../245-password/mud_password.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-07 jj5 - module defines...
//

define( 'MUD_SECRET_PROMPT_DEFAULT', 'Please enter password: ' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleSecret.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-08-07 jj5 - functional interface...
//

function mud_secret_read_stdin( $prompt = MUD_SECRET_PROMPT_DEFAULT, $secret = null ) {

  return mud_module_secret()->read_stdin( $prompt, $secret );

}

function mud_secret_generate( $length = 32 ) {

  return mud_module_secret()->generate( $length );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_secret() : MudModuleSecret {

  return mud_locator()->get_module( MudModuleSecret::class );

}
