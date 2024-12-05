<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-29 jj5 - include dependencies...
//

require_once __DIR__ . '/../340-cache/mud_cache.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_DAL_TRN_DISABLED', 'the trn connection is disabled.' );
mud_define_error( 'MUD_ERR_DAL_SQL_OPERATOR_INVALID', 'SQL operator invalid.' );
mud_define_error( 'MUD_ERR_DAL_OPEN_TRANSACTION_EXPECTED', 'open transaction expected.' );
mud_define_error( 'MUD_ERR_DAL_NAME_UNSAFE', 'the name component is unsafe.' );
mud_define_error( 'MUD_ERR_DAL_ID_COLUMN_UNREAD', 'the ID column was not read.' );
mud_define_error( 'MUD_ERR_DAL_VALUE_IS_INVALID', 'invalid value.' );
mud_define_error( 'MUD_ERR_DAL_TRANSACTION_FAILED', 'transaction failed.' );
mud_define_error( 'MUD_ERR_DAL_DATABASE_IS_OFFLINE', 'database is offline.' );
mud_define_error( 'MUD_ERR_DAL_ENTRY_IS_DUPLICATE', 'database is offline.' );
mud_define_error( 'MUD_ERR_DAL_RETRIES_EXHAUSTED', 'retries exhausted.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/trait/MudDalPeripheral.php';
require_once __DIR__ . '/trait/MudDalCentral.php';

require_once __DIR__ . '/class/0-MudDalBase.php';
//require_once __DIR__ . '/../../../../gen/dal/include.php';
require_once __DIR__ . '/class/1-MudDal.php';
require_once __DIR__ . '/class/2-MudDalRaw.php';
require_once __DIR__ . '/class/3-MudDalTrn.php';
require_once __DIR__ . '/class/4-MudDalEmu.php';
require_once __DIR__ . '/class/5-MudDalAux.php';
require_once __DIR__ . '/class/6-MudDalDba.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-08 jj5 - service locators...
//

function mud_module_dal() : MudModuleDal {

  return mud_locator()->get_module( MudModuleDal::class );

}

function mud_raw() : MudDalRaw {

  return mud_locator()->get_service( MudDalRaw::class );

}

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
