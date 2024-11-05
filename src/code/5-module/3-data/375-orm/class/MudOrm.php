<?php

class MudOrm extends MudService {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - protected fields...
  //

  protected $config_class_map = [];
  protected $record_class_map = [];

  protected $config_map = [];
  protected $record_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - magic methods...
  //

  public function __call( string $function, array $arguments ) {

    $parts = explode( '_', $function, 2 );

    if ( count( $parts ) !== 2 ) {

      mud_fail(
        MUD_ERR_ORM_INVALID_FUNCTION,
        [ 'function' => $function ]
      );

    }

    $type = $parts[ 0 ];
    $name = $parts[ 1 ];

    switch ( $type ) {

      case 'new' :

        return $this->new_record( $name );

      case 'get' :

        $arg = $arguments[ 0 ] ?? null;

        if ( $arg === null ) {

          mud_fail( MUD_ERR_ORM_INVALID_ARG, [ 'function' => $function ] );

        }

        $new_parts = explode( '_', $name );

        $result_type = array_pop( $new_parts );

        $new_name = implode( '_', $new_parts );

        switch ( $result_type ) {

          case 'list' :

            return $this->get_list( $new_name, $arg );

          case 'map' :

            $map_col = $arguments[ 1 ] ?? null;

            if ( $map_col === null ) {

              mud_fail( MUD_ERR_ORM_INVALID_ARG, [ 'function' => $function ] );

            }

            return $this->get_map( $new_name, $arg, $map_col );

          default :

            return $this->get_record( $name, $arg );

        }

      default :

        mud_not_supported( [ 'function' => $function ] );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-05 jj5 - public methods...
  //

  public function save() {

    foreach ( $this->record_map as $map ) {

      foreach ( $map as $record ) {

        $record->save_if_dirty();

      }
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - protected methods...
  //

  protected function new_record( $name ) {

    mud_not_implemented();

  }

  protected function get_record( $name, $arg ) {

    if ( is_int( $arg ) ) {

      $cached = $this->record_map[ $name ][ $arg ] ?? null;

      if ( $cached ) { return $cached; }

    }

    if ( $this->read_record_class( $name, $table_const, $table, $config_class, $record_class ) ) {

      if ( array_key_exists( $config_class, $this->config_map ) ) {

        $config = $this->config_map[ $config_class ];

      }
      else {

        $col_list = [];
        $col_map = [];
        $default = [];

        foreach ( mud_schemata()->get_tab( $table )->col_map as $col_name => $col ) {

          $col_list[] = $col;
          $col_map[ $col->get_name() ] = $col;
          $default[ $col->get_name() ] = $col->get_db_value( $col->get_default_value() );

        }

        $config = new $config_class( $table, $col_list, $col_map, $default );

      }

      $this->config_map[ $config_class ] = $config;

      $record = new $record_class( $config );

      $record->load( $arg );

      $this->record_map[ $name ][ $record->get_id() ] = $record;

      return $record;

    }

    mud_not_implemented([
      'name' => $name,
      'arg' => $arg,
      'config_map' => $this->config_map,
    ]);

  }

  protected function get_list( $name, $arg ) {

    mud_not_implemented();

  }

  protected function get_map( $name, $arg ) {

    mud_not_implemented();

  }

  protected function read_record_class(
    $name,
    &$table_const = null,
    &$table = null,
    &$config_class = null,
    &$record_class = null
  ) {

    $table_const = 'T_ENTITY_' . strtoupper( $name );

    if ( ! defined( $table_const ) ) {

      mud_fail( MUD_ERR_ORM_TABLE_CONST_MISSING, [ 'table_const' => $table_const ] );

    }

    $table = constant( $table_const );

    $config_class = $this->config_class_map[ $table ] ?? null;
    $record_class = $this->record_class_map[ $table ] ?? null;

    if ( $config_class && $record_class ) { return true; }

    foreach ( [ 'AppActiveConfig', 'MudActiveConfig' ] as $class_prefix ) {

      $class = $class_prefix . '_' . $name;

      if ( class_exists( $class ) ) {

        $this->config_class_map[ $table ] = $class;

        $config_class = $class;

        break;

      }
    }

    foreach ( [ 'AppActiveRecord', 'MudActiveRecord' ] as $class_prefix ) {

      $class = $class_prefix . '_' . $name;

      if ( class_exists( $class ) ) {

        $this->record_class_map[ $table ] = $class;

        $record_class = $class;

        break;

      }
    }

    if ( $config_class && $record_class ) { return true; }

    mud_fail(
      MUD_ERR_ORM_CLASS_MISSING,
      [
        'table' => $table,
        'config_class_map' => $this->config_class_map,
        'record_class_map' => $this->record_class_map,
      ]
    );

  }

}
