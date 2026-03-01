<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../310-interaction/mud_interaction.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_CONNECTION_EXCEPTION', 'database connection exception.' );
mud_define_error( 'MUD_ERR_CONNECTION_STATEMENT_IS_ALREADY_OPEN', 'statement is already open.' );
mud_define_error( 'MUD_ERR_CONNECTION_TRANSACTION_IS_ALREADY_OPEN', 'already in transaction.' );
mud_define_error( 'MUD_ERR_CONNECTION_TRANSACTION_IS_NOT_OPEN', 'no open transaction.' );
mud_define_error( 'MUD_ERR_CONNECTION_TRANSACTION_FAILED_TO_BEGIN', 'could not begin transaction.' );
mud_define_error( 'MUD_ERR_CONNECTION_TRANSACTION_FAILED_TO_COMMIT', 'could not commit transaction.' );
mud_define_error( 'MUD_ERR_CONNECTION_TRANSACTION_FAILED_TO_ROLLBACK', 'could not rollback transaction.' );
mud_define_error( 'MUD_ERR_CONNECTION_SPECIFIED_KEY_IS_TOO_LONG', 'specified key too long.' );
mud_define_error( 'MUD_ERR_CONNECTION_COUNT_IS_INVALID', 'invalid count.' );
mud_define_error( 'MUD_ERR_CONNECTION_ENTRY_IS_DUPLICATE', 'duplicate entry.' );
mud_define_error( 'MUD_ERR_CONNECTION_ISOLATION_LEVEL_IS_INVALID', 'invalid isolation level.' );
mud_define_error( 'MUD_ERR_CONNECTION_OPERATION_UNSUPPORTED', 'unsupported database operation.' );
mud_define_error( 'MUD_ERR_CONNECTION_ADMIN_NOT_DEFINED', 'ADMIN not defined.' );

// 2022-04-10 jj5 - errors for which we can retry our database operations... these needs to be
// registered in the MudConnectionException::is_retryable() function.
//
mud_define_error( 'MUD_ERR_CONNECTION_LOCK_WAIT_TIMEOUT_EXCEEDED', 'lock wait timeout exceeded.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/trait/MudConnectionTraits.php';

require_once __DIR__ . '/class/1-MudConnectionException.php';
require_once __DIR__ . '/class/2-MudConnectionStatement.php';
require_once __DIR__ . '/class/3-MudConnection.php';
require_once __DIR__ . '/class/4-MudConnectionRaw.php';
require_once __DIR__ . '/class/5-MudConnectionTrn.php';
require_once __DIR__ . '/class/6-MudConnectionEmu.php';
require_once __DIR__ . '/class/7-MudConnectionAux.php';
require_once __DIR__ . '/class/8-MudConnectionDba.php';
require_once __DIR__ . '/class/9-MudModuleConnection.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_connection_exception( $message, $code, $previous, $name, $hint, $data ) {

  return mud_module_connection()->new_mud_connection_exception( $message, $code, $previous, $name, $hint, $data );

}

function new_mud_connection_raw( array $args = [] ) {

  return mud_module_connection()->new_mud_connection_raw( $args );

}

function new_mud_connection_trn( array $args = [] ) {

  return mud_module_connection()->new_mud_connection_trn( $args );

}

function new_mud_connection_emu( array $args = [] ) {

  return mud_module_connection()->new_mud_connection_emu( $args );

}

function new_mud_connection_aux( array $args = [] ) {

  return mud_module_connection()->new_mud_connection_aux( $args );

}

function new_mud_connection_dba( array $args = [] ) {

  return mud_module_connection()->new_mud_connection_dba( $args );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-09 jj5 - functional interface...
//

function mud_register_new_connection( string $connection_type, MudConnection $connection ) {

  return mud_module_connection()->register_new_connection( $connection_type, $connection );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_connection() : MudModuleConnection {

  return mud_locator()->get_module( MudModuleConnection::class );

}
