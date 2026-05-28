<?php

class MudRevisionLite extends MudGadget {

  protected MudSchemaLite $schema;
  protected string $timestring;
  protected DateTimeImmutable $datetime;
  protected string $path;

  public function __construct( MudSchemaLite $schema, string $path ) {

    parent::__construct();

    if ( ! file_exists( $path ) ) {

      mud_fail( MUD_ERR_MODEL_REVISION_FILE_MISSING, [ 'path' => $path ] );

    }

    $path = realpath( $path );
    $file_name = basename( $path );
    $timestring = pathinfo( $file_name, PATHINFO_FILENAME );

    if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})-(\d{2})(\d{2})(\d{2})$/', $file_name, $matches ) ) {

      mud_fail( MUD_ERR_MODEL_INVALID_TIMESTRING, [ 'timestring' => $timestring ] );

    }

    $timestamp = $matches[1] . '-' . $matches[2] . '-' . $matches[3] . 'T' . $matches[4] . ':' . $matches[5] . ':' . $matches[6];

    $this->schema = $schema;
    $this->timestring = $timestring;
    $this->datetime = new DateTimeImmutable( $timestamp, new DateTimeZone( MUD_DATABASE_DEFAULT_TIME_ZONE ) );
    $this->path = $path;

  }

  public function get_schema() : MudSchemaLite {
    return $this->schema;
  }

  public function get_timestring() : string {
    return $this->timestring;
  }

  public function get_datestring( string $format ) : string {
    return $this->datetime->format( $format );
  }

  public function get_timestamp() : int {
    return $this->datetime->getTimestamp();
  }

  public function get_path() : string {
    return $this->path;
  }

  public function apply( $db ) {

    mud_stderr( "applying revision: " . $this->get_timestring() . "\n" );

    $dir = $this->get_path() . '/rev';

    $files = array_filter( scandir( $dir ), fn( $file ) => $file !== '.' && $file !== '..' );

    sort( $files, SORT_NATURAL | SORT_FLAG_CASE );

    foreach ( $files as $file ) {

      $path = $dir . DIRECTORY_SEPARATOR . $file;

      $this->apply_revision_file( $db, $path );

    }
  }

  protected function apply_revision_file( $db, string $path ) {

    mud_stderr( "applying revision file: " . $path . "\n" );

    $extension = pathinfo( $path, PATHINFO_EXTENSION );

    switch ( $extension ) {

      case 'sql':

        $sql = file_get_contents( $path );

        if ( $sql === false ) {

          mud_fail( MUD_ERR_MODEL_REVISION_FILE_MISSING, [ 'name' => $path ] );

        }

        $db->get_dba()->exec( $sql );

        break;

      case 'php' :

        require $path;

        break;

      default:

        mud_stderr( "skipping unsupported revision type: " . $extension . "\n" );
    }

    $sql = "
      insert ignore into t_particle__std_schema_name (
        a_std_schema_name
      )
      values (
        " . $db->get_dba()->quote( $this->get_schema()->get_name() ) . "
      )";

    $db->get_dba()->exec( $sql );

    $sql = "
      select
        a_std_schema_name_aid
      from
        t_particle__std_schema_name
      where
        a_std_schema_name = " . $db->get_dba()->quote( $this->get_schema()->get_name() );

    $a_std_schema_name_rid = $db->get_dba()->query( $sql )[ 0 ][ 'a_std_schema_name_aid' ];

    $sql = "
      insert into t_journal__std_schema_migration (
        a_std_schema_migration_schema_name_rid,
        a_std_schema_migration_revision
      )
      values (
        " . $db->get_dba()->quote( $a_std_schema_name_rid ) . ",
        " . $db->get_dba()->quote( $this->get_datestring( 'Y-m-d H:i:s' ) ) . "
      )";

    $db->get_dba()->exec( $sql );

    //var_dump( MUDBALL_CODE );

    $rid = $db->get_particle_rid(
      't_particle__std_software_code',
      'a_std_software_code_aid',
      'a_std_software_code',
      MUDBALL_CODE,
    );

  }
}
