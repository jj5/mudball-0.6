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

    $month_iterator = new DirectoryIterator( $this->path );

    foreach ( $month_iterator as $month_fileinfo ) {

      if ( $month_fileinfo->isDir() ) {

        $month_path = $month_fileinfo->getPathname();

        if ( preg_match( '/^\d{4}-\d{2}$/', $month_fileinfo->getFilename() ) ) {

          $rev_iterator = new DirectoryIterator( $month_path );

          foreach ( $rev_iterator as $rev_fileinfo ) {

            if ( $rev_fileinfo->isDir() ) {

              $rev_path = $rev_fileinfo->getPathname();

              if ( preg_match( '/^\d{4}-\d{2}-\d{2}-\d{6}/', $rev_fileinfo->getFilename() ) ) {

                $revision_list[] = new MudRevisionLite( $this, $rev_path );

              }
            }
          }
        }
      }
    }

    usort( $revision_list, function ( MudRevisionLite $a, MudRevisionLite $b ) {
      return strcmp( $a->get_datestring( 'Y-m-d\TH-i-s\Z' ), $b->get_datestring( 'Y-m-d\TH-i-s\Z' ) );
    } );

    return $revision_list;

  }

  public function get_namespace() : string {
    return $this->namespace;
  }

  public function get_name() : string {
    return $this->name;
  }

  public function get_path() : string {
    return $this->path;
  }
}
