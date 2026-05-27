<?php

class MudSchemaLite extends MudGadget {

  protected string $namespace;
  protected string $name;
  protected string $path;

  public function __construct( string $namespace, string $name, string $path ) {

    parent::__construct();

    $this->namespace = $namespace;
    $this->name = $name;
    $this->path = $path;

  }

  public function get_revision_list() {

    $revision_list = [];

    $iterator = new DirectoryIterator( $this->path );

    foreach ( $iterator as $fileinfo ) {

      if ( $fileinfo->isFile() ) {

        $path = $fileinfo->getPathname();

        if ( preg_match( '/^\d{4}-\d{2}-\d{2}-\d{6}/', $fileinfo->getFilename() ) ) {

          $revision_list[] = new MudRevisionLite( $this, $path );

        }
      }
    }

    usort( $revision_list, function ( MudRevisionLite $a, MudRevisionLite $b ) {
      return strcmp( $a->datetime->format( 'Y-m-d\TH-i-s\Z' ), $b->datetime->format( 'Y-m-d\TH-i-s\Z' ) );
    } );

    return $revision_list;

  }
}
