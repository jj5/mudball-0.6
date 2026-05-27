<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-14 jj5 - trace load if enabled...
//

if ( defined( 'APP_TRACE_LOAD' ) && APP_TRACE_LOAD ) {

  error_log( "loading: " . __FILE__ );

}


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-11-05 jj5 - load dependencies...
//

require_once __DIR__ . '/5-module.php';

require_once __DIR__ . '/../5-module/6-app/699-top/include.php';

/////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-11-05 jj5 - application definition...
//

mud_define_app( 'MUDBALL' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - configurable application constants...
//

define( 'APP_URL_BASE', CFG_URL_BASE ?? null );


/////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - strong typed application service locators...
//

//
// 2022-04-10 jj5 - NOTE: if it's a stateful service which requires constructor args then the
// class name is ommitted and the locator can't automatically create an instance for you, so you
// will need to call the service locator to set manually...
//

function app_schema( $set = false ) : AppSchema {

  return mud_locator()->schema( $set, AppSchema::class );

}

function app_interaction( $set = false ) : AppInteraction {

  return mud_locator()->interaction( $set, AppInteraction::class );

}

function app_trn( $set = false ) : AppDalTrn {

  return mud_locator()->trn( $set, AppDalTrn::class );

}

function app_raw( $set = false ) : AppDalRaw {

  return mud_locator()->raw( $set, AppDalRaw::class );

}

function app_emu( $set = false ) : AppDalEmu {

  return mud_locator()->emu( $set, AppDalEmu::class );

}

function app_aux( $set = false ) : AppDalAux {

  return mud_locator()->aux( $set, AppDalAux::class );

}

function app_dba( $set = false ) : AppDalDba {

  return mud_locator()->dba( $set, AppDalDba::class );

}

function app_orm( $set = false ) : AppOrm {

  return mud_locator()->orm( $set, AppOrm::class );

}

function app_registry( $set = false ) : AppRegistry {

  return mud_locator()->registry( $set, AppRegistry::class );

}

function app_reader( $set = false ) : AppReader {

  return mud_locator()->reader( $set, AppReader::class );

}

function app_logic( $set = false ) : AppLogic {

  return mud_locator()->logic( $set, AppLogic::class );

}

function app_user( $set = false ) {

  return mud_locator()->user( $set, MudUserNative::class );

}

function app_browser( $set = false ) {

  return mud_locator()->browser( $set, MudBrowserPhp::class );

}

function app_session( $set = false ) {

  return mud_locator()->session( $set, MudSessionPhp::class );

}

function app_request( $set = false ) : AppRequest {

  return mud_locator()->manage_service( AppRequest::class, $set );

}

function app_response( $set = false ) : AppResponse {

  return mud_locator()->response( $set );

}

function app_url( $set = false ) : AppUrl {

  return mud_locator()->url( $set );

}

function app( $set = false ) : IMudController {

  return mud_locator()->app( $set );

}

function app_factory( $set = false ) : AppFactory {

  return mud_locator()->factory( $set, AppFactory::class );

}

function app_null_object( $set = false ) : AppNullObject {

  return mud_locator()->null_object( $set, AppNullObject::class );

}
