<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-29 jj5 - include dependencies...
//

require_once __DIR__ . '/../335-schemadecl/mud_schemadecl.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_CACHE_INVALID_ID', 'invalid ID.' );
mud_define_error( 'MUD_ERR_CACHE_RETRY_LIMIT_EXCEEDED', 'retry limit exceeded.' );
mud_define_error( 'MUD_ERR_CACHE_UNRECOVERABLE_PDO_ERROR', 'unrecoverable PDO error.' );
mud_define_error( 'MUD_ERR_CACHE_MISSING_STATE_DIRECTORY', 'missing state directory.' );
mud_define_error( 'MUD_ERR_CACHE_INVALID_FILE_NAME_PART', 'invalid file name part.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudSerializationStrategy.php';

require_once __DIR__ . '/class/MudSerializationForJSON.php';
require_once __DIR__ . '/class/MudSerializationForPHP.php';

require_once __DIR__ . '/class/MudCacheTelemetry.php';
require_once __DIR__ . '/class/MudCacheTelemetryData.php';

require_once __DIR__ . '/class/MudCache.php';
require_once __DIR__ . '/class/MudModuleCache.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_cache( $name, $default_serializer = null ) {

  return mud_module_cache()->new_mud_cache( $name, $default_serializer );

}

function new_mud_serialization_for_json() {

  return mud_module_cache()->new_mud_serialization_for_json();

}

function new_mud_serialization_for_php() {

  return mud_module_cache()->new_mud_serialization_for_php();

}

function new_mud_cache_telemetry( string $name, string $container, int $serialization_type_enum ) {

  return mud_module_cache()->new_mud_cache_telemetry( $name, $container, $serialization_type_enum );

}

function new_mud_cache_telemetry_data(
  $duration,
  $row_count,
  $serialization_type_enum,
  $op_count,
  $op_time,
  $read_count,
  $read_time,
  $write_count,
  $write_time,
  $hit_count,
  $miss_count,
  $write_race_lost_count,
  $new_table_count,
  $error_count,
  $contention_count,
  $reconnect_count,
  $reset_count,
) {

  return mud_module_cache()->new_mud_cache_telemetry_data(
    $duration,
    $row_count,
    $serialization_type_enum,
    $op_count,
    $op_time,
    $read_count,
    $read_time,
    $write_count,
    $write_time,
    $hit_count,
    $miss_count,
    $write_race_lost_count,
    $new_table_count,
    $error_count,
    $contention_count,
    $reconnect_count,
    $reset_count,
  );

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//

function mud_module_cache() : MudModuleCache {

  return mud_locator()->get_module( MudModuleCache::class );

}
