<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../145-flags/mud_flags.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-19 jj5 - module constants...
//

define( 'MUD_TOKEN_LENGTH', 48 );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleRandom.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//
//

function mud_new_token( int $length = MUD_TOKEN_LENGTH ) : string {

  return mud_module_random()->new_token( $length );

}

function mud_new_seed() : int {

  return mud_module_random()->new_seed();

}


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_random() : MudModuleRandom {

  return mud_locator()->get_module( MudModuleRandom::class );

}

