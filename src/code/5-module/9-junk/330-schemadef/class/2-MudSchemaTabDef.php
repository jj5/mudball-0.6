<?php

class MudSchemaTabDef extends MudGadget {

  public $file_info;

  public $file;
  public $line;

  public $tab_name;
  public $tab_type;

  public $col_map = [];
  public $idx_map = [];

  private $primary_key = null;

  public function __construct( $file_info, $file, $line, $tab_name, $tab_type ) {

    parent::__construct();

    $this->file_info = $file_info;

    $this->file = $file;
    $this->line = $line;

    $this->tab_name = $tab_name;
    $this->tab_type = $tab_type;

  }

  public function create_tab( $schemata ) {

    $info = $this->file_info;

    $schema = $info[ 'schema' ];
    $revision = $info[ 'revision' ];
    $revision_number = $info[ 'revision_number' ];
    $revision_file = MudSchemata::GetRelativePath( $info[ 'path' ] );
    $file = MudSchemata::GetRelativePath( $this->file );

    $tab = new_mud_schema_tab(
      $schemata,
      $schema,
      $revision,
      $revision_number,
      $revision_file,
      $file,
      $this->line,
      $this->tab_name,
      $this->tab_type,
      $this->get_connection_type(),
      $this->is_cacheable(),
      $this->get_const()
    );

    assert( ! array_key_exists( $tab->get_name(), $schemata->tab_map ) );

    $schemata->tab_map[ $tab->get_name() ] = $tab;

    foreach ( $this->col_map as $col_def ) {

      $col = $col_def->create_col( $tab );

    }

    foreach ( $this->idx_map as $idx_def ) {

      $idx = $idx_def->create_idx( $tab );

    }

    return $tab;

  }

  public function get_name() { return $this->tab_name; }
  public function get_type() { return $this->tab_type; }

  public function get_connection_type() {

    switch ( $this->get_type() ) {

      case MUD_TABLE_PATTERN_ENTITY     :
      case MUD_TABLE_PATTERN_HISTORY    :
      case MUD_TABLE_PATTERN_EPHEMERAL  :
      case MUD_TABLE_PATTERN_EVENT      :

        return MUD_CONNECTION_TYPE_TRN;

      case MUD_TABLE_PATTERN_ABINITIO :
      case MUD_TABLE_PATTERN_LOOKUP   :
      case MUD_TABLE_PATTERN_STATIC   :
      case MUD_TABLE_PATTERN_ABOUT    :
      case MUD_TABLE_PATTERN_CONFIG   :
      case MUD_TABLE_PATTERN_DETAIL   :
      case MUD_TABLE_PATTERN_IDENT    :
      case MUD_TABLE_PATTERN_PARTICLE :
      case MUD_TABLE_PATTERN_PIECE    :
      case MUD_TABLE_PATTERN_POT      :
      case MUD_TABLE_PATTERN_PRODUCT  :
      case MUD_TABLE_PATTERN_DOMAIN   :
      case MUD_TABLE_PATTERN_LOG      :

        return MUD_CONNECTION_TYPE_RAW;

      default :

        mud_not_supported( [ 'type' => $this->get_type() ] );

    }
  }

  public function is_cacheable() {

    switch ( $this->get_type() ) {

      case MUD_TABLE_PATTERN_ABOUT      :
      case MUD_TABLE_PATTERN_CONFIG     :
      case MUD_TABLE_PATTERN_DETAIL     :
      case MUD_TABLE_PATTERN_IDENT      :
      case MUD_TABLE_PATTERN_ENTITY     :
      case MUD_TABLE_PATTERN_HISTORY    :
      case MUD_TABLE_PATTERN_EPHEMERAL  :
      case MUD_TABLE_PATTERN_EVENT      :

        return false;

      case MUD_TABLE_PATTERN_ABINITIO :
      case MUD_TABLE_PATTERN_LOOKUP   :
      case MUD_TABLE_PATTERN_STATIC   :
      case MUD_TABLE_PATTERN_PARTICLE :
      case MUD_TABLE_PATTERN_PIECE    :
      case MUD_TABLE_PATTERN_POT      :
      case MUD_TABLE_PATTERN_PRODUCT  :
      case MUD_TABLE_PATTERN_DOMAIN   :
      case MUD_TABLE_PATTERN_LOG      :

        return true;

      default :

        mud_not_supported( [ 'type' => $this->get_type() ] );

    }
  }

  public function get_primary_key() {

    if ( ! $this->primary_key ) {

      foreach ( $this->col_map as $column ) {

        assert( $column->is_key() );

        $this->primary_key = $column;

        break;

      }
    }

    return $this->primary_key;

  }

  public function get_const() { return strtoupper( $this->get_name() ); }

}
