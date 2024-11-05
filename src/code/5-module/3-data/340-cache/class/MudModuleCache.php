<?php

class MudModuleCache extends MudModuleData {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_cache( $name, $default_serializer = null ) {

    return MudCache::Create( $name, $default_serializer );

  }

  public function new_mud_serialization_for_json() {

    return MudSerializationForJSON::Create();

  }

  public function new_mud_serialization_for_php() {

    return MudSerializationForPHP::Create();

  }

  public function new_mud_cache_telemetry( string $name, string $container, int $serialization_type_enum ) {

    return MudCacheTelemetry::Create( $name, $container, $serialization_type_enum );

  }

  public function new_mud_cache_telemetry_data(
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

    return MudCacheTelemetryData::Create(
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
}
