<?php

class MudModuleCache extends MudModuleData {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleCache|null $previous = null) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_cache( $name, $default_serializer = null ) {

    return new MudCache( $name, $default_serializer );

  }

  public function new_mud_serialization_for_json() {

    return new MudSerializationForJSON();

  }

  public function new_mud_serialization_for_php() {

    return new MudSerializationForPHP();

  }

  public function new_mud_cache_telemetry( string $name, string $container, int $serialization_type_enum ) {

    return new MudCacheTelemetry( $name, $container, $serialization_type_enum );

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

    return new MudCacheTelemetryData(
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
