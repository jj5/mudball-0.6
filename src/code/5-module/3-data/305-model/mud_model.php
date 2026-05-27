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
// 2026-05-27 jj5 - include components...
//

require_once __DIR__ . '/1-enum/MudConnectionTypeLite.php';

require_once __DIR__ . '/2-trait/MudValidationLite.php';

require_once __DIR__ . '/3-class/0-module/MudModuleModel.php';

require_once __DIR__ . '/3-class/1-schema/MudSchemaLite.php';

require_once __DIR__ . '/3-class/2-database/MudDatabaseLite.php';

require_once __DIR__ . '/3-class/3-connection/0-MudConnectionLite.php';
require_once __DIR__ . '/3-class/3-connection/1-MudConnectionLite_RAW.php';
require_once __DIR__ . '/3-class/3-connection/2-MudConnectionLite_TRN.php';
require_once __DIR__ . '/3-class/3-connection/3-MudConnectionLite_EMU.php';
require_once __DIR__ . '/3-class/3-connection/4-MudConnectionLite_AUX.php';
require_once __DIR__ . '/3-class/3-connection/5-MudConnectionLite_DBA.php';

require_once __DIR__ . '/3-class/4-pdo/0-MudPdoLite.php';
require_once __DIR__ . '/3-class/4-pdo/1-MudPdoLite_RAW.php';
require_once __DIR__ . '/3-class/4-pdo/2-MudPdoLite_TRN.php';
require_once __DIR__ . '/3-class/4-pdo/3-MudPdoLite_EMU.php';
require_once __DIR__ . '/3-class/4-pdo/4-MudPdoLite_AUX.php';
require_once __DIR__ . '/3-class/4-pdo/5-MudPdoLite_DBA.php';

require_once __DIR__ . '/3-class/5-statement/MudStatementLite.php';

require_once __DIR__ . '/3-class/6-work/0-MudWorkLite.php';
require_once __DIR__ . '/3-class/6-work/1-MudWorkLite_Data.php';
require_once __DIR__ . '/3-class/6-work/2-MudWorkLite_Privilege.php';
require_once __DIR__ . '/3-class/6-work/3-MudWorkLite_Schema.php';

require_once __DIR__ . '/3-class/7-action/0-MudActionLite.php';
require_once __DIR__ . '/3-class/7-action/1-MudActionLite_Exec.php';
require_once __DIR__ . '/3-class/7-action/2-MudActionLite_Statement.php';
require_once __DIR__ . '/3-class/7-action/3-MudActionLite_Insert.php';
require_once __DIR__ . '/3-class/7-action/4-MudActionLite_Update.php';
require_once __DIR__ . '/3-class/7-action/5-MudActionLite_Delete.php';
require_once __DIR__ . '/3-class/7-action/6-MudActionLite_Schema.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-27 jj5 - module constants...
//

define( 'MUD_DATABASE_DEFAULT_TIME_ZONE', date_default_timezone_get() );
define( 'MUD_DATABASE_DEFAULT_CHARSET', 'utf8mb4' );
define( 'MUD_DATABASE_DEFAULT_COLLATION', 'utf8mb4_uca1400_ai_ci' );

define( 'MUD_CONNECTION_SETTING', [
  MudConnectionTypeLite::RAW->value => [
    'pdo_class' => MudPdoLite_RAW::class,
    'connection_class' => MudConnectionLite_RAW::class,
    'isolation_level' => 'READ COMMITTED',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudConnectionTypeLite::TRN->value => [
    'pdo_class' => MudPdoLite_TRN::class,
    'connection_class' => MudConnectionLite_TRN::class,
    'isolation_level' => 'SERIALIZABLE',
    'auto_commit' => false,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudConnectionTypeLite::AUX->value => [
    'pdo_class' => MudPdoLite_AUX::class,
    'connection_class' => MudConnectionLite_AUX::class,
    'isolation_level' => 'READ COMMITTED',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => false,
  ],
  MudConnectionTypeLite::EMU->value => [
    'pdo_class' => MudPdoLite_EMU::class,
    'connection_class' => MudConnectionLite_EMU::class,
    'isolation_level' => 'READ COMMITTED',
    'auto_commit' => true,
    'emulate_prepares' => true,
    'allow_multi_statements' => false,
  ],
  MudConnectionTypeLite::DBA->value => [
    'pdo_class' => MudPdoLite_DBA::class,
    'connection_class' => MudConnectionLite_DBA::class,
    'isolation_level' => 'READ COMMITTED',
    'auto_commit' => true,
    'emulate_prepares' => false,
    'allow_multi_statements' => true,
  ],
]);


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
