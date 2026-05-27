<?php

class MudRevisionLite extends MudGadget {

  protected MudSchemaLite $schema;
  protected string $timestring;
  protected DateTimeImmutable $datetime;
  protected string $path;
  protected string $file_type;

  public function __construct( MudSchemaLite $schema, string $path ) {

    parent::__construct();

    if ( ! file_exists( $path ) ) {

      mud_fail( MUD_ERR_MODEL_REVISION_FILE_MISSING, [ 'name' => $path ] );

    }

    $path = realpath( $path );
    $file_name = basename( $path );
    $timestring = pathinfo( $file_name, PATHINFO_FILENAME );
    $file_type = pathinfo( $file_name, PATHINFO_EXTENSION );

    if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})-(\d{2})(\d{2})(\d{2})/', $file_name, $matches ) ) {

      mud_fail( MUD_ERR_MODEL_INVALID_TIMESTRING, [ 'timestring' => $timestring ] );

    }

    $timestamp = $matches[1] . '-' . $matches[2] . '-' . $matches[3] . 'T' . $matches[4] . ':' . $matches[5] . ':' . $matches[6];

    $this->schema = $schema;
    $this->timestring = $timestring;
    $this->datetime = new DateTimeImmutable( $timestamp, new DateTimeZone( MUD_DATABASE_DEFAULT_TIME_ZONE ) );
    $this->path = $path;
    $this->file_type = $file_type;

  }

  public function get_schema() : MudSchemaLite {
    return $this->schema;
  }

  public function get_timestring() : string {
    return $this->timestring;
  }

  public function get_datetime( string $format ) : string {
    return $this->datetime->format( $format );
  }

  public function get_timestamp() : int {
    return $this->datetime->getTimestamp();
  }

  public function get_type() : string {
    return $this->file_type;
  }

  public function get_path() : string {
    return $this->path;
  }
}
