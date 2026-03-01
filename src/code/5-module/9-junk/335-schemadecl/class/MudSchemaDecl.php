<?php

class MudSchemaDecl extends MudSchemaDeclBase {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - public fields...
  //

  public $info;

  public $type;
  public $unit;
  public $name;
  public $attrs;

  public $prev;
  public $next;

  public $op_args = null;

  public $is_processed = false;

  // 2022-03-06 jj5 - this revision map maps schema names to revision numbers, and is copied into
  // the head element after loading all the schema files...
  //
  public $rev_map = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - constructor...
  //

  public function __construct( $info, $type, $name_spec, $attrs, $prev, $file, $line ) {

    $name = self::GetName( $name_spec, $type );

    $attrs[ 'file' ] = $file;
    $attrs[ 'line' ] = $line;

    $this->info = $info;

    $this->type = $type;
    $this->unit = self::GetUnit( $type );
    $this->name = $name;
    $this->attrs = $attrs;

    $this->prev = $prev;
    $this->next = null;

    // 2022-02-22 jj5 - THINK: do I want this..?
    //
    if ( $prev ) { $prev->next = $this; }

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - public static methods...
  //

  public static function GetUnit( $type ) {

    switch ( $type ) {

      case MUD_SCHEMADECL_TYPE_TAB :

        return MUD_SCHEMADECL_UNIT_TAB;

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_DUP :
      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_VRT :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_REK :
      case MUD_SCHEMADECL_TYPE_REV :
      case MUD_SCHEMADECL_TYPE_FLG :

        return MUD_SCHEMADECL_UNIT_COL;

      case MUD_SCHEMADECL_TYPE_IDX :

        return MUD_SCHEMADECL_UNIT_IDX;

      case MUD_SCHEMADECL_TYPE_VIEW :

        return MUD_SCHEMADECL_UNIT_VIEW;

      case MUD_SCHEMADECL_TYPE_PROC :

        return MUD_SCHEMADECL_UNIT_PROC;

      case MUD_SCHEMADECL_TYPE_DAT :

        return MUD_SCHEMADECL_UNIT_DAT;

      case MUD_SCHEMADECL_TYPE_JOB :

        return MUD_SCHEMADECL_UNIT_JOB;

      default :

        mud_not_supported( [ 'type ' => $type ] );

    }
  }

  public static function GetName( $spec ) {

    if ( is_string( $spec ) ) { return $spec; }

    // 2021-10-18 jj5 - if it's not a string then it's an array of column names for an index...

    return 'idx_' . mud_hash_hex( mud_json_compact( $spec ) );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - public methods...
  //

  public function clone( $info, $prev, $file, $line ) {

    return new_mud_schema_decl( $info, $this->type, $this->name, $this->attrs, $prev, $file, $line );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - schema operations...
  //

  public function rename( $name ) {

    mud_require( $this->op_args === null, 'args are null.' );

    switch ( $this->unit ) {

      case MUD_SCHEMADECL_UNIT_TAB :

        $this->op_args = [
          'operation' => 'tab-rename',
          'old-name' => $this->name,
          'new-name' => $name,
        ];

        $this->name = $name;

        break;

      case MUD_SCHEMADECL_UNIT_COL :

        $this->op_args = [
          'operation' => 'col-rename',
          'old-name' => $this->name,
          'new-name' => $name,
        ];

        $this->name = $name;

        break;

      default :

        mud_not_supported( [ 'unit' => $this->unit ] );

    }

    return $this;

  }

  public function change() {

    mud_require( $this->op_args === null, 'args are null.' );

    mud_not_implemented();

    return $this;

  }

  public function drop() {

    mud_require( $this->op_args === null, 'args are null.' );

    switch ( $this->unit ) {

      case MUD_SCHEMADECL_UNIT_TAB :

        $this->op_args = [
          'operation' => 'tab-drop',
        ];

        break;

      case MUD_SCHEMADECL_UNIT_COL :

        $this->op_args = [
          'operation' => 'col-drop',
        ];

        break;

      case MUD_SCHEMADECL_UNIT_IDX :

        $this->op_args = [
          'operation' => 'idx-drop',
        ];

        break;

      default :

        mud_not_supported( [ 'unit' => $this->unit ] );

    }

    return $this;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - public property accessors...
  //

  public function get_info() { return $this->info; }
  public function get_revision() { return $this->info[ 'revision' ]; }
  public function get_revision_number() { return $this->info[ 'revision_number' ]; }
  public function get_schema() { return $this->info[ 'schema' ]; }

  public function get_type() { return $this->type; }
  public function get_unit() { return $this->unit; }
  public function get_name() { return $this->name; }
  public function get_attrs() { return $this->attrs; }

  public function get_next() { return $this->next; }
  public function get_prev() { return $this->prev; }

  public function get_file() { return $this->get_attr( 'file' ); }
  public function get_line() { return $this->get_attr( 'line' ); }

  public function get_ref_tab_name() { return $this->get_attr( 'ref_tab_name' ); }
  public function get_ref_col_name() { return $this->get_attr( 'ref_col_name' ); }

  public function is_interaction_id() {

    $curr = $this;

    while ( $curr->is_ref() ) {

      if ( $curr->get_ref_col_name() === 'a_std_interaction_id' ) { return true; }

      $curr = $curr->get_ref_col();

    }

    return false;

  }

  public function get_flag() { return $this->get_attr( 'flag' ); }

  public function get_col_name_list() { return $this->get_attr( 'col_name_list' ); }
  public function get_idx_type() { return $this->get_attr( 'idx_type' ); }

  public function get_min() { return $this->get_spec( SPEC_MIN, $this->get_min_default() ); }
  public function get_max() { return $this->get_spec( SPEC_MAX, $this->get_max_default() ); }
  public function get_nullable() { return $this->get_spec( SPEC_NULLABLE, false ); }
  public function get_default() { return $this->get_spec( SPEC_DEFAULT, MUD_UNSPECIFIED ); }
  public function get_valid() { return $this->get_spec( SPEC_VALID, $this->get_valid_default() ); }
  public function get_invalid() { return $this->get_spec( SPEC_INVALID, $this->get_invalid_default() ); }
  public function get_after() { return $this->get_spec( SPEC_AFTER ); }

  public function get_tab_type() {

    $name_parts = explode( '_', $this->get_name() );

    return $name_parts[ 1 ];

  }

  public function get_col_type() {

    $result = $this->attrs[ 'col_type' ] ?? null;

    if ( $result ) { return $result; }

    //var_dump( $this->attrs );

    $ref_tab_name = $this->get_ref_tab_name();
    $ref_col_name = $this->get_ref_col_name();

    /*
    if ( $this->type === MUD_SCHEMADECL_TYPE_DUP ) {

      assert( $ref_tab_name === null );

      $ref_tab_name = $this->get_current_tab()->get_name();

    }
    */

    $ref_col = $this->get_col( $ref_tab_name, $ref_col_name );

    if ( $ref_col === $this ) {

      //var_dump( $this ); exit( 1 );

    }

    if ( ! $ref_col ) {

      mud_fail(
        MUD_ERR_SCHEMADECL_MISSING_COLUMN,
        [ 'ref_tab_name' => $ref_tab_name, 'ref_col_name' => $ref_col_name ]
      );

    }

    return $ref_col->get_col_type();

  }

  public function is_tab() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_TAB );

  }

  public function is_col() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_COL );

  }

  public function is_idx() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_IDX );

  }

  public function is_view() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_VIEW );

  }

  public function is_proc() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_PROC );

  }

  public function is_dat() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_DAT );

  }

  public function is_job() {

    return $this->is_unit( MUD_SCHEMADECL_UNIT_JOB );

  }

  public function is_unit( $unit ) {

    return $this->get_unit() === $unit;

  }

  public function is_key() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column' );

    switch ( $this->type ) {

      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_REK :

        return true;

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_DUP :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_VRT :
      case MUD_SCHEMADECL_TYPE_REV :
      case MUD_SCHEMADECL_TYPE_FLG :

        return false;

      default :

        mud_not_supported( [ 'type' => $this->type ] );

    }
  }

  public function is_vrt() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    switch ( $this->type ) {

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_DUP :
      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_REK :

        return false;

      case MUD_SCHEMADECL_TYPE_VRT :
      case MUD_SCHEMADECL_TYPE_REV :
      case MUD_SCHEMADECL_TYPE_FLG :

        return true;

      default :

        mud_not_supported( [ 'type' => $this->type ] );

    }
  }

  public function is_ref() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    switch ( $this->type ) {

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_VRT :

        return false;

      case MUD_SCHEMADECL_TYPE_DUP :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_REK :
      case MUD_SCHEMADECL_TYPE_REV :
      case MUD_SCHEMADECL_TYPE_FLG :

        return true;

      default :

        mud_not_supported(
          [
            'type' => $this->type,
            'name' => $this->name,
          ]
        );

    }
  }

  public function is_flg() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    switch ( $this->type ) {

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_DUP :
      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_VRT :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_REK :
      case MUD_SCHEMADECL_TYPE_REV :

        return false;

      case MUD_SCHEMADECL_TYPE_FLG :

        return true;

      default :

        mud_not_supported( [ 'type' => $this->type ] );

    }
  }

  public function is_dup() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    switch ( $this->type ) {

      case MUD_SCHEMADECL_TYPE_DUP :

        return true;

      case MUD_SCHEMADECL_TYPE_COL :
      case MUD_SCHEMADECL_TYPE_KEY :
      case MUD_SCHEMADECL_TYPE_REK :
      case MUD_SCHEMADECL_TYPE_REF :
      case MUD_SCHEMADECL_TYPE_VRT :
      case MUD_SCHEMADECL_TYPE_REV :
      case MUD_SCHEMADECL_TYPE_FLG :

        return false;

      default :

        mud_not_supported( [ 'type' => $this->type ] );

    }
  }


  public function is_unique() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    if ( $this->is_key() ) { return true; }

    $idx_list = $this->get_idx_list();

    $col_list = [ $this->get_name() ];

    foreach ( $idx_list as $idx ) {

      if ( $idx->get_idx_type() === MUD_IDX_INDEX ) { continue; }

      // 2021-10-27 jj5 - at the moment this is the only other index type...
      //
      mud_require( $idx->get_idx_type() === MUD_IDX_UNIQUE, 'index is unique.' );

      if ( $idx->get_col_name_list() === $col_list ) { return true; }

    }

    return false;

  }

  public function is_fk() {

    mud_require( $this->unit === MUD_SCHEMADECL_UNIT_COL, 'unit is column.' );

    if ( ! $this->is_ref() ) { return false; }

    $ref_col = $this->get_ref_col();

    return $ref_col->is_unique();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - these are our spec shortcuts...
  //

  public function min( $value ) {

    return $this->set_spec( SPEC_MIN, $value );

  }

  public function max( $value ) {

    return $this->set_spec( SPEC_MAX, $value );

  }

  public function nullable( $value ) {

    return $this->set_spec( SPEC_NULLABLE, $value );

  }

  public function default( $value ) {

    return $this->set_spec( SPEC_DEFAULT, $value );

  }

  public function valid( $value ) {

    return $this->set_spec( SPEC_VALID, $value );

  }

  public function invalid( $value ) {

    return $this->set_spec( SPEC_INVALID, $value );

  }

  public function after( $col_name ) {

    return $this->set_spec( SPEC_AFTER, $col_name );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - these are the operations we can perform...
  //

  public function apply_def( $def ) {

    if ( $this->op_args ) {

      switch ( $this->op_args[ 'operation' ] ) {

        case 'tab-rename' :

          $new_name = $this->op_args[ 'new-name' ];
          $old_name = $this->op_args[ 'old-name' ];

          $tab = $def->tab_map[ $old_name ];

          $tab->tab_name = $new_name;

          unset( $def->tab_map[ $old_name ] );

          $def->tab_map[ $new_name ] = $tab;

          $tab->file_info = $this->info;

          return;

        case 'col-rename' :

          $tab_name = $this->get_current_tab()->get_name();

          $tab = $def->tab_map[ $tab_name ];

          $new_name = $this->op_args[ 'new-name' ];
          $old_name = $this->op_args[ 'old-name' ];

          $col = $tab->col_map[ $old_name ];

          $col->col_name = $new_name;

          unset( $tab->col_map[ $old_name ] );

          $tab->col_map[ $new_name ] = $col;

          $col->file_info = $this->info;

          return;

        case 'tab-drop' :

          unset( $def->tab_map[ $this->get_name() ] );

          return;

        case 'col-drop' :

          $tab_name = $this->get_current_tab()->get_name();

          unset( $def->tab_map[ $tab_name ]->col_map[ $this->get_name() ] );

          return;

        case 'idx-drop' :

          // 2021-10-27 jj5 - TODO: implement me.

          return;

        case 'view-drop' :

          // 2021-10-27 jj5 - TODO: implement me.

          return;

        case 'proc-drop' :

          // 2021-10-27 jj5 - TODO: implement me.

          return;

        default :

          mud_not_supported( [ 'op_args' => $this->op_args ] );

      }
    }

    switch ( $this->unit ) {

      case MUD_SCHEMADECL_UNIT_TAB :

        $file = $this->get_file();
        $line = $this->get_line();

        $tab_name = $this->get_name();
        $tab_type = $this->get_tab_type();

        if ( array_key_exists( $tab_name, $def->tab_map ) ) {

          //var_dump( $tab_name );

        }
        else {

          $def->tab_map[ $tab_name ] = new_mud_schema_tab_def(
            $this->info,
            $file,
            $line,
            $tab_name,
            $tab_type
          );

        }

        break;

      case MUD_SCHEMADECL_UNIT_COL :

        $tab_name = $this->get_current_tab()->get_name();

        $file = $this->get_file();
        $line = $this->get_line();

        $col_name = $this->get_name();
        $col_type = $this->get_col_type();

        $is_key = $this->is_key();
        $is_vrt = $this->is_vrt();
        $is_ref = $this->is_ref();
        $is_flg = $this->is_flg();
        $is_dup = $this->is_dup();

        $is_unique = $this->is_unique();
        $is_fk = $this->is_fk();

        $min = $this->get_min();
        $max = $this->get_max();
        $nullable = $this->get_nullable();
        $default = $this->get_default();
        $valid = $this->get_valid();
        $invalid = $this->get_invalid();

        $ref_tab_name = $this->get_ref_tab_name();
        $ref_col_name = $this->get_ref_col_name();

        $flag = $this->get_flag();

        $is_interaction_id = $this->is_interaction_id();

        $def->tab_map[ $tab_name ]->col_map[ $col_name ] = new_mud_schema_col_def(
          $this->info,
          $file,
          $line,
          $col_name,
          $col_type,
          $is_key,
          $is_vrt,
          $is_ref,
          $is_flg,
          $is_dup,
          $is_unique,
          $is_fk,
          $min,
          $max,
          $nullable,
          $default,
          $valid,
          $invalid,
          $ref_tab_name,
          $ref_col_name,
          $flag,
          $is_interaction_id
        );

        break;

      case MUD_SCHEMADECL_UNIT_IDX :

        $tab_name = $this->get_current_tab()->get_name();

        $file = $this->get_file();
        $line = $this->get_line();

        $idx_name = $this->get_name();
        $idx_type = $this->get_idx_type();

        $col_name_list = $this->get_col_name_list();

        $def->tab_map[ $tab_name ]->idx_map[ $idx_name ] = new_mud_schema_idx_def(
          $this->info,
          $file,
          $line,
          $idx_name,
          $idx_type,
          $col_name_list
        );

        break;

      case MUD_SCHEMADECL_UNIT_VIEW :

        // 2021-10-27 jj5 - TODO: implement me.

        break;

      case MUD_SCHEMADECL_UNIT_PROC :

        // 2021-10-27 jj5 - TODO: implement me.

        break;

      case MUD_SCHEMADECL_UNIT_DAT :

        // 2021-10-27 jj5 - TODO: implement me.

        break;

      case MUD_SCHEMADECL_UNIT_JOB :

        // 2021-10-27 jj5 - TODO: implement me.

        break;

      default :

        mud_not_supported( [ 'unit' => $this->unit ] );

    }
  }

  public function apply_sql( $db, &$sql ) {

    $sql = null;

    if ( $this->is_processed ) { return false; }

    if ( $this->op_args ) {

      switch ( $this->op_args[ 'operation' ] ) {

        case 'tab-rename' :

          return;

        case 'col-rename' :

          return;

        case 'tab-drop' :

          return;

        case 'col-drop' :

          return;

        case 'idx-drop' :

          return;

        case 'view-drop' :

          return;

        case 'proc-drop' :

          return;

        default :

          mud_not_supported( [ 'op_args' => $this->op_args ] );

      }
    }

    switch ( $this->unit ) {

      case MUD_SCHEMADECL_UNIT_TAB :

        return $this->create_tab_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_COL :

        return $this->create_col_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_IDX :

        return $this->create_idx_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_VIEW :

        return $this->create_view_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_PROC :

        return $this->create_proc_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_DAT :

        return $this->create_dat_in_database( $db, $sql );

      case MUD_SCHEMADECL_UNIT_JOB :

        return $this->run_job( $db, $sql );

      default :

        mud_not_supported( [ 'unit' => $this->unit ] );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions for searching our linked list...
  //

  public function get_ref_tab() {

    return $this->get_tab( $this->get_ref_tab_name() );

  }

  public function get_ref_col() {

    return $this->get_col( $this->get_ref_tab_name(), $this->get_ref_col_name() );

  }

  public function has_tab( $tab_name ) {

    return $this->get_tab( $tab_name ) !== null;

  }

  public function get_tab( $tab_name ) {

    $curr = $this;

    do {

      switch ( $curr->unit ) {

        case MUD_SCHEMADECL_UNIT_TAB :

          if ( $curr->get_name() === $tab_name ) { return $curr; }

      }
    }
    while ( $curr = $curr->prev );

    return null;

  }

  public function get_col( $tab_name, $col_name ) {

    //echo "searching for $tab_name.$col_name...\n";

    $curr = $this;

    do {

      switch ( $curr->unit ) {

        case MUD_SCHEMADECL_UNIT_COL :

          if ( $curr->get_name() !== $col_name ) { break; }

          if ( $curr->get_current_tab()->get_name() === $tab_name ) { return $curr; }

          break;

      }
    }
    while ( $curr = $curr->prev );

    return null;

  }

  public function get_current_tab() {

    $curr = $this;

    do {

      switch ( $curr->unit ) {

        case MUD_SCHEMADECL_UNIT_TAB : return $curr;

      }
    }
    while ( $curr = $curr->prev );

    return null;

  }

  public function get_idx_list() {

    $result = [];

    $curr = $this->get_current_tab();

    mud_require( $curr !== null, 'current element is not null.' );

    do {

      switch ( $curr->unit ) {

        case MUD_SCHEMADECL_TYPE_IDX : $result[] = $curr; break;

        case MUD_SCHEMADECL_UNIT_TAB : return $result;

      }
    }
    while ( $curr = $curr->next );

    return $result;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-17 jj5 - protected methods...
  //

  protected function get_attr( $item, $default = null ) {

    mud_require( is_array( $this->attrs ), 'attributes are array.' );

    return $this->attrs[ $item ] ?? $default;

  }

  protected function get_spec( $item, $default = null ) {

    //var_dump( $this->attrs );

    //mud_require( is_array( $this->attrs[ 'spec' ] ) );

    return $this->attrs[ 'spec' ][ $item ] ?? $default;

  }

  protected function set_spec( $item, $value ) {

    mud_require( is_array( $this->attrs[ 'spec' ] ), 'spec is array.' );

    $this->attrs[ 'spec' ][ $item ] = $value;

    return $this;

  }

  protected function create_tab_in_database( $db, &$sql ) {

    if ( $db->has_table( $this->name ) ) {

      $this->is_processed = true;

      return;

    }

    $revision_number = $this->get_revision_number();
    $prefix = $db->get_prefix();

    $curr = $this->next;
    $first_col = null;
    $has_primary_index = false;
    $col_list = [];
    $idx_list = [];
    $parts = [];

    do {

      if ( $curr->get_revision_number() > $revision_number ) { break; }

      switch ( $curr->unit ) {

        case MUD_SCHEMADECL_UNIT_TAB : break 2;

        case MUD_SCHEMADECL_UNIT_COL :

          if ( $curr->is_vrt() ) { break; }

          if ( $first_col === null ) { $first_col = $curr; }

          $col_list[] = $curr;

          $parts[] = $curr->get_col_sql();

          $curr->is_processed = true;

          break;

        case MUD_SCHEMADECL_UNIT_IDX :

          $idx_list[] = $curr;

          $curr->is_processed = true;

          break;

      }
    }
    while ( $curr = $curr->next );

    if ( ! $has_primary_index ) {

      $parts[] = 'primary key ( ' . $first_col->get_name() . ' )';

    }

    foreach ( $col_list as $col ) {

      if ( ! $col->is_ref() ) { continue; }
      if ( $col->is_dup() ) { continue; }

      // 2021-10-18 jj5 - NOTE: this is a bit shit, but we only support single-column foreign
      // keys, which is not of itself a problem, except that above we go out of our way to
      // support composite primary keys, which is a bit silly if we can't use them as FKs...
      // But I can't imagine it ever being sensible to take on the complexity of composite keys...
      // so this is fine for now (and ever?)

      $name = $col->get_name();
      $ref_tab = $col->get_ref_tab();
      $ref_col = $col->get_ref_col();
      $ref_tab_name = $prefix . $ref_tab->get_name();
      $ref_col_name = $ref_col->get_name();

      //if ( ! $ref_col->is_unique() ) { continue; }

      if ( ! $col->is_fk() ) { continue; }

      $parts[] = "foreign key ( $name ) references $ref_tab_name ( $ref_col_name )";

    }

    foreach ( $idx_list as $idx ) {

      $parts[] = $idx->get_idx_sql();

    }

    $name = $this->name;

    $sql = "create table {$prefix}{$name} (\n  ";

    $sql .= implode( ",\n  ", $parts );

    $sql .= "\n) engine=InnoDB collate=utf8mb4_unicode_520_ci";

    //echo $sql . "\n";

    $db->exec( $sql );

    $this->is_processed = true;

  }

  protected function create_col_in_database( $db, &$sql ) {

    if ( $this->is_vrt() ) { return; }

    $prefix = $db->get_prefix();
    $tab_name = $this->get_current_tab()->name;

    $sql = "alter table {$prefix}{$tab_name}\n  add column " . $this->get_col_sql();

    $after = $this->attrs[ 'spec' ][ SPEC_AFTER ] ?? null;
    $first = $this->attrs[ 'spec' ][ SPEC_FIRST ] ?? false;

    if ( $after && $first ) {

      mud_fail(
        MUD_ERR_SCHEMADECL_CANNOT_BE_AFTER_AND_FIRST,
        [ 'after' => $after, 'first' => $first ]
      );

    }

    if ( $after ) {

      $sql .= " after $after";

    }
    else if ( $first ) {

      $sql .= ' first';

    }

    if ( $this->is_fk() && $this->is_ref() && ! $this->is_dup() ) {

      $name = $this->get_name();
      $ref_tab = $this->get_ref_tab();
      $ref_col = $this->get_ref_col();
      $ref_tab_name = $prefix . $ref_tab->get_name();
      $ref_col_name = $ref_col->get_name();

      $sql .= ",\n  add foreign key ( $name ) references $ref_tab_name ( $ref_col_name )";

    }

    $db->exec( $sql );

    $this->is_processed = true;

  }

  protected function create_idx_in_database( $db, &$sql ) {

    $prefix = $db->get_prefix();
    $tab_name = $this->get_current_tab()->name;

    $sql = "alter table {$prefix}{$tab_name}\n  add " . $this->get_idx_sql();

    $db->exec( $sql );

    $this->is_processed = true;

  }

  protected function create_view_in_database( $db, &$sql ) {

    $sql = $this->attrs[ 'fn' ]( $db->get_prefix(), $db );

    $db->exec( $sql );

    $this->is_processed = true;

  }

  protected function create_proc_in_database( $db, &$sql ) {

    $sql = $this->attrs[ 'fn' ]( $db->get_prefix(), $db );

    $db->exec( $sql );

    $this->is_processed = true;

  }

  protected function create_dat_in_database( $db, &$sql ) {

    $revision_number = $this->get_revision_number();
    $prefix = $db->get_prefix();

    $sql = $this->get_dat_sql( $prefix );

    $stmt = $db->prepare( $sql );

    $db->begin();

    foreach ( $this->attrs[ 'rows' ] as $row ) {

      $params = $this->get_dat_params( $row, $db );

      $stmt->execute( $params );

      $stmt->closeCursor();

    }

    $db->commit();

    $this->is_processed = true;

  }

  protected function run_job( $db, &$sql ) {

    $this->attrs[ 'fn' ]( $db, $sql );

    $this->is_processed = true;

  }

  public function get_col_sql() {

    $name = $this->get_name();
    $type = $this->get_sql_type();
    $null = $this->get_nullable() ? 'null' : 'not null';
    $default = $this->get_default();

    if ( $default === MUD_UNSPECIFIED ) {

      if ( $this->get_nullable() ) {

        $default = ' default null';

      }
      else {

        $default = '';

      }
    }
    elseif ( $default === MUD_CURRENT_TIMESTAMP ) {

      $default = ' default current_timestamp';

    }
    elseif ( $default !== null ) {

      $default = " default $default";

    }
    else {

      $default = ' default null';

    }

    switch ( $this->get_col_type() ) {

      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :

        return "{$name} {$type}";

    }

    if ( $this->type === MUD_SCHEMADECL_TYPE_DUP ) {

      return "{$name} {$type} as (" . $this->get_attr( 'ref_col_name' ) . ')';

    }

    return "{$name} {$type} {$null}{$default}";

  }

  public function get_idx_sql() {

    $cols = implode( ', ', $this->get_col_name_list() );
    $name = $this->get_name();

    switch ( $this->get_idx_type() ) {

      /*
      case MUD_IDX_PRIMARY :

        return "primary key ( $cols )";
      */

      case MUD_IDX_UNIQUE :

        return "unique key $name ( $cols )";

      case MUD_IDX_INDEX :

        return "index $name ( $cols )";

      default :

        mud_not_supported();

    }

  }

  protected function get_dat_sql( string $prefix ) {

    $columns = array_keys( $this->attrs[ 'col_spec' ] );

    $sql_cols = implode( ', ', $columns );
    $vals = [];
    $update = [];

    foreach ( $columns as $col_name ) {

      $vals[] = ":$col_name";

      $update[] = "$col_name = VALUES( $col_name )";

    }

    $sql_vals = implode( ', ', $vals );
    $sql_update = implode( ', ', $update );

    $tab_name = $this->name;

    $sql = "
      insert into {$prefix}{$tab_name} (
        $sql_cols
      )
      values (
        $sql_vals
      )
      on duplicate key update
      $sql_update
    ";

    return $sql;

  }

  protected function get_dat_params( array $row, $db ) {

    $params = [];
    $index = 0;

    foreach ( $this->attrs[ 'col_spec' ] as $col_name => $default_value ) {

      $value = $row[ $index++ ] ?? $default_value;

      if ( ! is_string( $value ) && is_callable( $value ) ) {

        $value = call_user_func_array( $value, [ $row, $db ] );

      }

      $params[ ":$col_name" ] = $value;

    }

    return $params;

  }

  public function get_sql_type() {

    $max = $this->get_max();

    if ( $this->is_ref() ) {

      switch ( $this->get_col_type() ) {

        // 2019-10-16 jj5 - references don't auto_increment...
        //
        case DBT_ID8  : return 'tinyint unsigned';
        case DBT_ID16 : return 'smallint unsigned';
        case DBT_ID24 : return 'mediumint unsigned';
        case DBT_ID32 : return 'int unsigned';

        // 2023-11-05 jj5 - don't use signed 64-bit ints, PHP can't represent them...
        //
        case DBT_ID64 : return 'bigint';

      }
    }

    switch ( $this->get_col_type() ) {

      case DBT_BOOL : return 'boolean';

      // 2019-10-16 jj5 - signed integers for IDs (auto-increment)...
      //
      case DBT_ID8  : return 'tinyint unsigned auto_increment';
      case DBT_ID16 : return 'smallint unsigned auto_increment';
      case DBT_ID24 : return 'mediumint unsigned auto_increment';
      case DBT_ID32 : return 'int unsigned auto_increment';

      // 2023-11-05 jj5 - don't use signed 64-bit ints, PHP can't represent them...
      //
      case DBT_ID64 : return 'bigint auto_increment';

      // 2019-09-22 jj5 - unsigned integers...
      //
      case DBT_UINT8  : return 'tinyint unsigned';
      case DBT_UINT16 : return 'smallint unsigned';
      case DBT_UINT24 : return 'mediumint unsigned';
      case DBT_UINT32 : return 'int unsigned';
      case DBT_UINT64 : return 'bigint unsigned';

      // 2019-09-22 jj5 - signed integers...
      //
      case DBT_INT8  : return 'tinyint';
      case DBT_INT16 : return 'smallint';
      case DBT_INT24 : return 'mediumint';
      case DBT_INT32 : return 'int';
      case DBT_INT64 : return 'bigint';

      // 2019-10-20 jj5 - floats...
      //
      case DBT_SINGLE : return 'float';
      case DBT_DOUBLE : return 'double';

      // 2019-09-22 jj5 - datetimes...
      //
      case DBT_CREATED_ON : return 'timestamp default current_timestamp';
      case DBT_UPDATED_ON : return 'timestamp default current_timestamp on update current_timestamp';

      case DBT_DATETIME_UTC : return 'datetime';
      case DBT_DATETIME_SYD : return 'datetime';
      case DBT_DATETIME     : return 'datetime';

      case DBT_TIMEZONE : return 'varchar(255) collate ascii_general_ci';


      // 2019-11-06 jj5 - sha512/224 hashes in various formats...
      //
      case DBT_HASH_HEX : return 'char(56) collate ascii_general_ci';
      case DBT_HASH_BIN : return 'binary(28)';

      // 2019-11-06 jj5 - tokens are 48 char alphanumerics...
      //
      case DBT_TOKEN : return 'char(48) collate ascii_bin';

      // 2019-09-22 jj5 - strings...
      //
      case DBT_ASCII_BIN  : return "varchar({$max}) collate ascii_bin";
      case DBT_ASCII_CI   : return "varchar({$max}) collate ascii_general_ci";
      case DBT_UTF8_BIN   : return "varchar({$max}) collate utf8mb4_bin";
      case DBT_UTF8_CI    : return "varchar({$max}) collate utf8mb4_unicode_520_ci";

      // 2020-03-09 jj5 - fixed width strings...
      //
      case DBT_ASCII_CHAR_BIN : return "char({$max}) collate ascii_bin";
      case DBT_ASCII_CHAR_CI  : return "char({$max}) collate ascii_general_ci";
      case DBT_UTF8_CHAR_BIN  : return "char({$max}) collate utf8mb4_bin";
      case DBT_UTF8_CHAR_CI   : return "char({$max}) collate utf8mb4_unicode_520_ci";

      // 2020-03-26 jj5 - text...
      //
      case DBT_TEXT : return "longtext collate utf8mb4_unicode_520_ci";

      // 2020-03-17 jj5 - medium/large binary data...
      //
      case DBT_BMOB : return 'mediumblob';
      case DBT_BLOB : return 'longblob';

      case DBT_ENUM :

        $counter = 1;

        $sql = 'enum( ';

        foreach ( $this->attrs[ 'spec' ][ SPEC_ENUM ] as $item ) {

          if ( $counter++ > 1 ) { $sql .= ', '; }

          $sql .= $this->quote( $item );

        }

        $sql .= ' )';

        return $sql;

      default :

        mud_not_supported(  [ 'col_type' => $this->get_col_type() ]  );

    }
  }

  protected function quote( string $value ) {

    return mud_raw()->quote( $value );

  }

  protected function get_min_default() {

    switch ( $this->get_col_type() ) {

      case DBT_BOOL : return 0;

      // 2019-10-16 jj5 - unsigned integers for IDs (auto-increment)...
      //
      case DBT_ID8  : return 0;
      case DBT_ID16 : return 0;
      case DBT_ID24 : return 0;
      case DBT_ID32 : return 0;
      case DBT_ID64 : return 0;

      // 2019-09-22 jj5 - unsigned integers...
      //
      case DBT_UINT8  : return 0;
      case DBT_UINT16 : return 0;
      case DBT_UINT24 : return 0;
      case DBT_UINT32 : return 0;
      case DBT_UINT64 : return 0;

      // 2019-09-22 jj5 - signed integers...
      //
      case DBT_INT8  : return MUD_MIN_INT8;
      case DBT_INT16 : return MUD_MIN_INT16;
      case DBT_INT24 : return MUD_MIN_INT24;
      case DBT_INT32 : return MUD_MIN_INT32;
      case DBT_INT64 : return MUD_MIN_INT64;

      // 2019-10-20 jj5 - floats...
      //
      case DBT_SINGLE :
      case DBT_DOUBLE : return null;

      // 2019-09-22 jj5 - datetimes...
      //
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON : return null;

      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME     : return null;

      case DBT_TIMEZONE : return 0;


      // 2019-11-06 jj5 - sha512/224 hashes in various formats...
      //
      case DBT_HASH_HEX : return 56;
      case DBT_HASH_BIN : return 28;

      // 2019-11-06 jj5 - tokens are 48 char alphanumerics...
      //
      case DBT_TOKEN : return 48;

      // 2019-09-22 jj5 - strings...
      //
      case DBT_ASCII_BIN  : return 0;
      case DBT_ASCII_CI   : return 0;
      case DBT_UTF8_BIN   : return 0;
      case DBT_UTF8_CI    : return 0;

      // 2020-03-09 jj5 - characters...
      //
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI  :
      case DBT_UTF8_CHAR_BIN  :
      case DBT_UTF8_CHAR_CI   : return 1;

      // 2020-03-26 jj5 - text...
      //
      case DBT_TEXT : return null;

      // 2020-03-17 jj5 - medium/large binary data...
      //
      case DBT_BMOB :
      case DBT_BLOB : return null;

      case DBT_ENUM : return null;

      // 2021-03-27 jj5 - some schema elements don't define a data type, such as schema
      // definitions and tables, so if col type is null just return null...
      //
      case null: return null;

      default :

        mud_not_supported(
          [ 'col_type' => $this->get_col_type(), 'element' => $this ]
        );

    }
  }

  protected function get_max_default() {

    switch ( $this->get_col_type() ) {

      case DBT_BOOL : return 1;

      // 2019-10-16 jj5 - unsigned integers for IDs (auto-increment)...
      //
      case DBT_ID8  : return MUD_MAX_UINT8;
      case DBT_ID16 : return MUD_MAX_UINT16;
      case DBT_ID24 : return MUD_MAX_UINT24;
      case DBT_ID32 : return MUD_MAX_UINT32;

      // 2023-11-05 jj5 - don't use signed 64-bit ints, PHP can't represent them...
      //
      case DBT_ID64 : return MUD_MAX_INT64;

      // 2019-09-22 jj5 - unsigned integers...
      //
      case DBT_UINT8  : return MUD_MAX_UINT8;
      case DBT_UINT16 : return MUD_MAX_UINT16;
      case DBT_UINT24 : return MUD_MAX_UINT24;
      case DBT_UINT32 : return MUD_MAX_UINT32;
      case DBT_UINT64 : return MUD_MAX_UINT64;

      // 2019-09-22 jj5 - signed integers...
      //
      case DBT_INT8  : return MUD_MAX_INT8;
      case DBT_INT16 : return MUD_MAX_INT16;
      case DBT_INT24 : return MUD_MAX_INT24;
      case DBT_INT32 : return MUD_MAX_INT32;
      case DBT_INT64 : return MUD_MAX_INT64;

      // 2019-10-20 jj5 - floats...
      //
      case DBT_SINGLE :
      case DBT_DOUBLE : return null;

      // 2019-09-22 jj5 - datetimes...
      //
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON : return null;

      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME     : return null;

      case DBT_TIMEZONE : return 255;


      // 2019-11-06 jj5 - sha512/224 hashes in various formats...
      //
      case DBT_HASH_HEX : return 56;
      case DBT_HASH_BIN : return 28;

      // 2019-11-06 jj5 - tokens are 48 char alphanumerics...
      //
      case DBT_TOKEN : return 48;

      // 2019-09-22 jj5 - strings...
      //
      case DBT_ASCII_BIN  : return MUD_SIZE_ASCII_255;
      case DBT_ASCII_CI   : return MUD_SIZE_ASCII_255;
      case DBT_UTF8_BIN   : return MUD_SIZE_UTF8_190;
      case DBT_UTF8_CI    : return MUD_SIZE_UTF8_190;

      // 2020-03-09 jj5 - characters...
      //
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI  :
      case DBT_UTF8_CHAR_BIN  :
      case DBT_UTF8_CHAR_CI   : return 1;

      // 2020-03-26 jj5 - text...
      //
      case DBT_TEXT : return null;

      // 2020-03-17 jj5 - medium/large binary data...
      //
      case DBT_BMOB :
      case DBT_BLOB : return null;

      case DBT_ENUM : return null;

      // 2021-03-27 jj5 - some schema elements don't define a data type, such as schema
      // definitions and tables, so if col type is null just return null...
      //
      case null: return null;

      default :

        mud_not_supported(
          [ 'col_type' => $this->get_col_type(), 'element' => $this ]
        );

    }
  }

  protected function get_valid_default() {

    $col_type = $this->get_col_type();

    assert( is_array( self::$schema_type[ $col_type ] ) );

    return self::$schema_type[ $col_type ][ 'valid' ] ?? null;

  }

  protected function get_invalid_default() {

    $col_type = $this->get_col_type();

    assert( is_array( self::$schema_type[ $col_type ] ) );

    return self::$schema_type[ $col_type ][ 'invalid' ] ?? null;

  }
}
