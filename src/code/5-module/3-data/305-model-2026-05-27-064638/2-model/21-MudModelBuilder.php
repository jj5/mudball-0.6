<?php

class MudModelBuilder {

  public string $name;
  public string $namespace;
  public string $path;

  public MudModel $model;
  public MudSchemaBuilder $schema_builder;
  public array $version_map = [];

  public function __construct( string $name, string $namespace, string $path ) {

    $this->name = $name;
    $this->namespace = $namespace;
    $this->path = $path;

    $this->model = new MudModel( $namespace, $name );
    $this->schema_builder = new MudSchemaBuilder( $namespace );

  }

  public function load() {

    global $g_mud_model_builder, $g_mud_model_version;

    $g_mud_model_builder = $this;

    $dir = $this->path . '/' . $this->name . '/';

    foreach ( scandir( $dir, SCANDIR_SORT_ASCENDING ) as $file ) {

      if ( $file === '.' || $file === '..' ) { continue; }

      $path = "{$dir}/{$file}";

      if ( is_dir( $path ) ) {

        continue;

      }
      else {

        assert( is_file( $path ) );

        try {

          if ( preg_match( '/^(\d{4}-\d{2}-\d{2}-\d{6})\.php$/', $file, $matches ) ) {

            $version_string = $matches[ 1 ];

            $g_mud_model_version = new MudModelVersionBuilder( $version_string );

            require_once $path;

            $this->version_map[ $version_string ] = $g_mud_model_version;

            $g_mud_model_version->apply_model( $this->model );
            $g_mud_model_version->apply_schema( $this->model, $this->schema_builder );

          }
        }
        catch ( Throwable $ex ) {

          error_log( $ex->getMessage() );

          error_log( "Error loading file: $path" );

          throw $ex;

        }
      }
    }
  }
}
