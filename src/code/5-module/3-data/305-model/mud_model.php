<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../300-data/mud_data.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_MODEL_CERTIFICATE_MISSING', 'database certificate not found.' );
mud_define_error( 'MUD_ERR_MODEL_UNSUPPORTED_CONNECTION_TYPE', 'unsupported connection type.' );
mud_define_error( 'MUD_ERR_MODEL_INVALID_ISOLATION_LEVEL', 'invalid isolation level.' );
mud_define_error( 'MUD_ERR_MODEL_INVALID_NAME', 'invalid name.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - module constants...
//

define( 'MUD_DATABASE_DEFAULT_TIME_ZONE', date_default_timezone_get() );
define( 'MUD_DATABASE_DEFAULT_CHARSET', 'utf8mb4' );
define( 'MUD_DATABASE_DEFAULT_COLLATION', 'utf8mb4_uca1400_ai_ci' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - include components...
//

require_once __DIR__ . '/class/0-MudModuleModel.php';
require_once __DIR__ . '/class/1-MudSchemaLite.php';
require_once __DIR__ . '/class/2-MudDatabaseLite.php';
require_once __DIR__ . '/class/3-MudConnectionLite.php';
require_once __DIR__ . '/class/4-MudStatementLite.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - functional interface...
//

function mud_declare_schema( string $namespace, string $name, string $path ) : MudSchemaLite {

  return mud_module_model()->declare_schema( $namespace, $name, $path );

}

function mud_declare_database(
  array  $schema_list,
  string $db_host = DB_HOST,
  int    $db_port = DB_PORT,
  ?string $db_cert = DB_CERT,
  string $db_name = DB_NAME,
  string $db_user = DB_USER,
  string $db_pass = DB_PASS,
  string $db_user_dba = DB_USER_DBA,
  string $db_pass_dba = DB_PASS_DBA,
) : MudDatabaseLite {

  return mud_module_model()->declare_database(
    $schema_list,
    $db_host,
    $db_port,
    $db_cert,
    $db_name,
    $db_user,
    $db_pass,
    $db_user_dba,
    $db_pass_dba
  );

}

function mud_validate_connection_lite(
  PDO $pdo,
  string $expected_isolation_level,
  string $expected_time_zone = MUD_DATABASE_DEFAULT_TIME_ZONE,
  string $expected_character_set = MUD_DATABASE_DEFAULT_CHARSET,
  string $expected_collation = MUD_DATABASE_DEFAULT_COLLATION,
) {

  return mud_module_model()->validate_connection(
    $pdo,
    $expected_isolation_level,
    $expected_time_zone,
    $expected_character_set,
    $expected_collation,
  );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - service locator...
//
//

function mud_module_model() : MudModuleModel {

  return mud_locator()->get_module( MudModuleModel::class );

}
