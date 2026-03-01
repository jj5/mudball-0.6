<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - include dependencies...
//

require_once __DIR__ . '/../310-interaction/mud_interaction.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - module errors...
//



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - include components...
//

mud_load_files( __DIR__ . '/enum' );
mud_load_files( __DIR__ . '/trait' );
mud_load_files( __DIR__ . '/class' );


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - functional interface
//

function mud_is_ddl( string $sql ) : bool {

  return mud_module_database()->is_ddl( $sql );

}

function mud_is_dcl( string $sql ) : bool {

  return mud_module_database()->is_dcl( $sql );

}

function mud_is_dml( string $sql ) : bool {

  return mud_module_database()->is_dml( $sql );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - service locator...
//

function mud_module_database() : MudModuleDatabase {

  return mud_locator()->get_module( MudModuleDatabase::class );

}

function mud_raw() : MudDatabaseConnection_PDO_RAW {

  return mud_module_database()->get_raw();

}

/*
function mud_trn() : MudDalTrn {

  return mud_locator()->get_service( MudDalTrn::class );

}

function mud_emu() : MudDalEmu {

  return mud_locator()->get_service( MudDalEmu::class );

}

function mud_aux() : MudDalAux {

  return mud_locator()->get_service( MudDalAux::class );

}

function mud_dba() : MudDalDba {

  return mud_locator()->get_service( MudDalDba::class );

}
*/
