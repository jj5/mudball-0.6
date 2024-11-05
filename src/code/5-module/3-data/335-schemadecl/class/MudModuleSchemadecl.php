<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - class definition...
//

class MudModuleSchemadecl extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-16 jj5 - protected fields...
  //

  protected $info = null;

  protected $head = null;
  protected $curr = null;


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleSchemadecl|null $previous = null) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_schema_decl( $info, $type, $name_spec, $attrs, $prev, $file, $line ) {

    return new MudSchemaDecl( $info, $type, $name_spec, $attrs, $prev, $file, $line );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-16 jj5 - public interface...
  //

  public function load( $mud_dir = null, $app_dir = null ) {

    if ( $mud_dir === null ) {

      $mud_dir = realpath( __DIR__ . '/../../../../6-schema' );

    }

    if ( $app_dir === null ) {

      $app_dir = realpath( __DIR__ . '/../../../../../../../../src/code/6-schema' );

    }

    // 2021-10-18 jj5 - this function reads in schema definition from various PHP files in the
    // various directories and then returns the head of a linked list of MudSchemaDecl items...

    if ( ! is_dir( $mud_dir ) ) { mud_fail( MUD_ERR_SCHEMADECL_INVALID_MUD_SCHEMA_DIR, [ 'dir' => $mud_dir ] ); }
    if ( ! is_dir( $app_dir ) ) { mud_fail( MUD_ERR_SCHEMADECL_INVALID_APP_SCHEMA_DIR, [ 'dir' => $app_dir ] ); }

    $this->reset();

    $file_list = $this->get_file_list( [ 'mud' => $mud_dir, 'app' => $app_dir ] );

    $rev_map = [];

    foreach ( $file_list as $file => $file_info ) {

      $revision_number = $file_info[ 'revision_number' ];
      $schema = $file_info[ 'schema' ];

      $rev_map[ $schema ] = $revision_number;

      $path = $file_info[ 'path' ];

      if ( DEBUG ) {

        //echo "$file => $path\n";

      }

      //var_dump( $file_info );

      $this->info = $file_info;

      require $path;

    }

    $cd = getcwd();

    foreach ( [ $mud_dir, $app_dir ] as $dir ) {

      chdir( $dir );

      foreach ( scandir( '.' ) as $subdir ) {

        if ( $subdir === '.' || $subdir === '..' ) { continue; }

        if ( ! is_dir( $subdir ) ) { continue; }

        $views = "$subdir/views.php";

        if ( ! is_file( $views ) ) { continue; }

        require $views;

      }
    }

    chdir( $cd );

    $result = $this->head;

    $this->reset();

    $result->rev_map = $rev_map;

    return $result;

  }

  public function gen_flags( array $flags_list ) : array {

    // 2020-04-13 jj5 - technically we don't need the $flags_list, just the
    // biggest one, but I think there's value in asserting that we have a
    // list of flags in the right order... of course we won't catch situations
    // where the list is too short.

    if ( defined( 'DEBUG' ) && DEBUG ) {

      $pow = 0;

      foreach ( $flags_list as $flag ) {

        assert( $flag === pow( 2, $pow++ ) );

      }
    }

    $table = [];

    $limit = pow( 2, count( $flags_list ) );

    for ( $flags = 0; $flags < $limit; $flags++ ) {

      $row = [ $flags ];

      foreach ( $flags_list as $flag ) {

        $row[] = ( $flags & $flag ) === $flag ? 1 : 0;

      }

      $table[] = $row;

    }

    return $table;

  }

  public function def_tab( $tab_name ) {

    assert( $this->curr === null || ! $this->curr->has_tab( $tab_name ) );

    return $this->def( MUD_SCHEMADECL_TYPE_TAB, $tab_name, [] );

  }

  public function def_col( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_COL, $col_name, $attrs );

  }

  public function def_dup( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_DUP, $col_name, $attrs );

  }

  public function def_key( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_KEY, $col_name, $attrs );

  }

  public function def_vrt( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_VRT, $col_name, $attrs );

  }

  public function def_ref( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_REF, $col_name, $attrs );

  }

  public function def_rek( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_REK, $col_name, $attrs );

  }

  public function def_rev( string $col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_REV, $col_name, $attrs );

  }

  public function def_flg( string $flags_col_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_FLG, $flags_col_name, $attrs );

  }

  public function def_idx( array $col_name_list, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_IDX, $col_name_list, $attrs );

  }

  public function def_view( string $view_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_VIEW, $view_name, $attrs );

  }

  public function def_proc( string $proc_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_PROC, $proc_name, $attrs );

  }

  public function def_dat( string $tab_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_DAT, $tab_name, $attrs );

  }

  public function def_job( string $job_name, array $attrs ) {

    return $this->def( MUD_SCHEMADECL_TYPE_JOB, $job_name, $attrs );

  }

  public function mod_tab( $tab_name ) {

    return $this->mod( MUD_SCHEMADECL_UNIT_TAB, $tab_name );

  }

  public function mod_col( $col_name ) {

    return $this->mod( MUD_SCHEMADECL_UNIT_COL, $col_name );

  }

  public function mod_idx( $col_name_list ) {

    return $this->mod( MUD_SCHEMADECL_UNIT_IDX, $col_name_list );

  }

  public function mod_view( $view_name ) {

    return $this->mod( MUD_SCHEMADECL_UNIT_VIEW, $view_name );

  }

  public function mod_proc( $proc_name ) {

    return $this->mod( MUD_SCHEMADECL_UNIT_PROC, $proc_name );

  }


  public function get_current_tab() {

    $curr = $this->curr;

    while ( $curr ) {

      if ( $curr->type === 'tab' ) { return $curr; }

      $curr = $curr->prev;

    }

    return null;

  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-16 jj5 - protected methods...
  //

  protected function reset() {

    $this->info = null;
    $this->head = null;
    $this->curr = null;

  }

  protected function get_file_list( $search_map ) {

    static $revision_pattern = '/^(\d\d\d\d-\d\d-\d\d-\d\d\d\d\d\d)/';

    $file_list = [];

    foreach ( $search_map as $namespace => $search ) {

      foreach ( scandir( $search ) as $file ) {

        if ( $file === '.' || $file === '..' ) { continue; }

        $path = "$search/$file";

        if ( ! is_dir( $path ) ) { continue; }

        // 2021-10-16 jj5 - if a schema file has a dash (-) or a dot (.) in it then we don't load
        // it...
        //
        if ( strpos( $file, '-' ) !== false ) { continue; }
        if ( strpos( $file, '.' ) !== false ) { continue; }

        $schema = $file;

        foreach ( scandir( "$search/$schema" ) as $file ) {

          $path = "$search/$schema/$file";

          if ( is_dir( $path ) ) { continue; }

          if ( ! preg_match( $revision_pattern, $file, $matches ) ) {

            //echo "file '$file' skipped.\n";

            continue;

          }

          $revision = $matches[ 1 ];

          if ( array_key_exists( $revision, $file_list ) ) {

            mud_fail(
              MUD_ERR_SCHEMADECL_DUPLICATE_SCHEMA_DEFINITION,
              [ 'new_file' => $file, 'first_file' => $file_list[ $file ] ]
            );

          }

          $revision_number = intval( str_replace( '-', '', $revision ) );

          switch ( $namespace ) {

            case 'mud' :

              if ( $revision_number % 2 !== 1 ) {

                // 2023-11-05 jj5 - the file name for 'std' database spec must be odd

                mud_fail(
                  MUD_ERR_SCHEMADECL_REVISION_MUST_BE_ODD,
                  [ 'revision_number' => $revision_number ]
                );

              }

              break;

            case 'app' :

              if ( $revision_number % 2 !== 0 ) {

                // 2023-11-05 jj5 - the file name for 'bus' database spec must be even

                mud_fail(
                  MUD_ERR_SCHEMADECL_REVISION_MUST_BE_EVEN,
                  [ 'revision_number' => $revision_number ]
                );

              }

              break;

            default : mud_not_supported( [ 'namespace' => $namespace ] );

          }

          $data = [
            'revision' => $revision,
            'revision_number' => $revision_number,
            'search' => $search,
            'schema' => $schema,
            'file' => $file,
            'path' => $path,
          ];

          //var_dump( $data );

          $file_list[ $revision_number ] = $data;

        }
      }
    }

    ksort( $file_list );

    return $file_list;

  }

  protected function def( $type, $name, $args ) {

    $trace = debug_backtrace();

    $file = $trace[ 2 ][ 'file' ];
    $line = $trace[ 2 ][ 'line' ];

    $next = new_mud_schema_decl(
      $this->info,
      $type,
      $name,
      $args,
      $this->curr,
      $file,
      $line
    );

    if ( $name === 't_entity_mud_user' ) {

      //var_dump( $next ); exit( 1 );

    }

    if ( $this->curr ) {

      $this->curr->next = $next;

    }
    else {

      $this->head = $next;

    }

    return $this->curr = $next;

  }

  protected function mod( $unit, $name_spec ) {

    $curr = $this->curr;

    if ( ! $curr ) {

      assert( false, 'can this happen?' );

      return null;

    }

    $name = MudSchemaDecl::GetName( $name_spec );

    do {

      if ( $curr->name !== $name ) { continue; }
      if ( $curr->unit !== $unit ) { continue; }

      $trace = debug_backtrace();

      $file = $trace[ 2 ][ 'file' ];
      $line = $trace[ 2 ][ 'line' ];

      $new = $curr->clone( $this->info, $this->curr, $file, $line );

      $this->curr = $new;

      return $new;

    }
    while ( $curr = $curr->prev );

    mud_fail(
      MUD_ERR_SCHEMADECL_UNIT_NOT_FOUND,
      [
        'unit' => $unit,
        'name_spec' => $name_spec,
      ]
    );

  }
}
