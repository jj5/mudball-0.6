<?php

class MudSchemata extends MudGadget {

  public $rev_map = [];
  public $tab_map = [];
  public $col_map = [];

  public function jsonSerialize(): mixed {

    return [
      'rev_map' => $this->rev_map,
      'tab_map' => $this->tab_map,
      'col_map' => $this->col_map,
    ];

  }

  public function __construct( array $rev_map ) {

    parent::__construct();

    $this->rev_map = $rev_map;

  }

  public static function Load( $use_cache = true, &$def = null ) {

    if ( $use_cache ) {

      if ( defined( 'APP_PATH' ) ) {

        $base = APP_PATH;

      }
      else {

        $base = '.';

      }

      assert( is_dir( $base ) );

      $path = $base . '/src/gen/schemata/schemata.dat';

      //var_dump( $path ); exit;

      assert( is_file( $path ) );

      $schemata = unserialize(
        file_get_contents( $path ),
        [
          'allowed_classes' => [ 'MudSchemata', 'MudSchemaTab', 'MudSchemaCol', 'MudSchemaIdx' ],
        ]
      );

    }
    else {

      $head = $curr = mud_load_schemadecl();

      $def = new_mud_schema_def();

      do {

        $revision_number = $curr->get_revision_number();
        $type = $curr->get_type();
        $name = $curr->get_name();

        if ( DEBUG ) {

          //echo "$revision_number: $type: $name\n";

        }

        $curr->apply_def( $def );

        $last = $curr;

      }
      while ( $curr = $curr->next );

      $schemata = $def->get_schemata( $head->rev_map );

    }

    foreach ( $schemata->tab_map as $tab_name => $tab ) {

      $const = strtoupper( $tab_name );

      if ( defined( $const ) ) {

        assert( constant( $const ) === $tab_name );

      }
      else {

        define( $const, $tab_name );

      }
    }

    foreach ( $schemata->col_map as $col_name => $col ) {

      $const = strtoupper( $col_name );

      if ( defined( $const ) ) {

        assert( constant( $const ) === $col_name );

      }
      else {

        define( $const, $col_name );

      }
    }

    return $schemata;

  }

  public static function GetRelativePath( $path ) {

    $app_path = realpath( defined( 'APP_PATH' ) ? APP_PATH : MUDBALL_PATH );

    $path = realpath( $path );

    return substr( $path, strlen( $app_path ) + 1 );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - public instance methods...
  //

  public function get_info() {

    // 2022-02-28 jj5 - NOTE: this function only gets info for tables, not columns or data etc.

    $info = [];

    foreach ( $this->tab_map as $tab ) {

      $schema = $tab->schema;

      if ( array_key_exists( $schema, $info ) ) {

        $info[ $schema ][ 'tab_count' ]++;
        $info[ $schema ][ 'col_count' ] += count( $tab->col_map );

      }
      else {

        $info[ $schema ] = [
          'schema' => $schema,
          'tab_count' => 1,
          'col_count' => count( $tab->col_map ),
        ];

      }
    }

    return $info;

  }

  public function get_rev_map() { return $this->rev_map; }

  public function get_rev( $schema_name ) {

    return $this->rev_map[ $schema_name ];

  }

  public function get_tab( $tab_name ) {

    return $this->tab_map[ $tab_name ];

  }

  public function get_col( $col_name ) {

    return $this->col_map[ $col_name ];

  }

  public function get_tab_col( $tab_name, $col_name ) {

    return $this->get_tab( $tab_name )->col_map[ $col_name ];

  }

  public function get_db_value( $col_name, $value ) {

    $col = $this->col_map[ $col_name ] ?? null;

    if ( $col === null ) {

      assert( false );

      return $value;

    }

    return $col->get_db_value( $value );

  }

  public function get_app_value( $col_name, $value ) {

    $col = $this->col_map[ $col_name ] ?? null;

    if ( $col === null ) {

      assert( false );

      return $value;

    }

    return $col->get_app_value( $value );

  }

  public function validate( $col_name, $value ) {

    if ( $this->is_valid( $col_name, $value, $problem, $error ) ) { return; }

    mud_fail(
      MUD_ERR_SCHEMATA_FIELD_IS_INVALID,
      [ 'col_name' => $col_name, 'value' => $value, 'problem' => $problem ]
    );

  }

  public function is_valid( $col_name, $value, &$problem = null, &$error = null ) {

    $col = $this->get_col( $col_name );

    if ( $col === null ) {

      assert( false );

      return false;

    }

    return $col->is_valid( $value, $problem, $error );

  }

  public function get_human_name( $col_name ) {

    $col = $this->get_col( $col_name );

    if ( $col === null ) {

      assert( false );

      return false;

    }

    return $col->get_human_name();

  }
}
