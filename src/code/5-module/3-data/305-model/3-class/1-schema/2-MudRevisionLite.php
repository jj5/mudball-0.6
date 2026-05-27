<?php

class MudRevisionLite extends MudGadget {

  protected string $timestring;
  protected DateTimeImmutable $datetime;
  protected string $path;

  public function __construct( MudSchemaLite $schema, string $path ) {

    parent::__construct();

    $file_name = basename( $path );
    $timestring = pathinfo( $file_name, PATHINFO_FILENAME );



    $this->timestring = $timestring;
    $this->datetime = new DateTimeImmutable( $timestring );
    $this->path = $path;

  }
}
