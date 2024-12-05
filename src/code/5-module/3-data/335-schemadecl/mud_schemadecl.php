<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - include dependencies...
//

require_once __DIR__ . '/../330-schemadef/mud_schemadef.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_SCHEMADECL_CANARY', 'additional parameters detected.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_INVALID_MUD_SCHEMA_DIR', 'invalid mud schema dir.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_INVALID_APP_SCHEMA_DIR', 'invalid app schema dir.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_DUPLICATE_SCHEMA_DEFINITION', 'duplicate schema definition.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_REVISION_MUST_BE_ODD', 'invalid mud revision number, must be odd.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_REVISION_MUST_BE_EVEN', 'invalid mud revision number, must be even.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_MISSING_COLUMN', 'missing referenced column.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_CANNOT_BE_AFTER_AND_FIRST', 'cannot be after and first.' );
mud_define_error( 'MUD_ERR_SCHEMADECL_UNIT_NOT_FOUND', 'unit not found.' );



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-06 jj5 - module constants...
//

define( 'MUD_SCHEMADECL_TYPE_TAB', 'tab' );

define( 'MUD_SCHEMADECL_TYPE_COL', 'col' );
define( 'MUD_SCHEMADECL_TYPE_DUP', 'dup' );
define( 'MUD_SCHEMADECL_TYPE_KEY', 'key' );
define( 'MUD_SCHEMADECL_TYPE_VRT', 'vrt' );
define( 'MUD_SCHEMADECL_TYPE_REF', 'ref' );
define( 'MUD_SCHEMADECL_TYPE_REK', 'rek' );
define( 'MUD_SCHEMADECL_TYPE_REV', 'rev' );
define( 'MUD_SCHEMADECL_TYPE_FLG', 'flg' );

define( 'MUD_SCHEMADECL_TYPE_IDX', 'idx' );
define( 'MUD_SCHEMADECL_TYPE_VIEW', 'view' );
define( 'MUD_SCHEMADECL_TYPE_PROC', 'proc' );
define( 'MUD_SCHEMADECL_TYPE_DAT', 'dat' );
define( 'MUD_SCHEMADECL_TYPE_JOB', 'job' );

define( 'MUD_SCHEMADECL_UNIT_TAB', 'tab' );
define( 'MUD_SCHEMADECL_UNIT_COL', 'col' );
define( 'MUD_SCHEMADECL_UNIT_IDX', 'idx' );
define( 'MUD_SCHEMADECL_UNIT_VIEW', 'view' );
define( 'MUD_SCHEMADECL_UNIT_PROC', 'proc' );
define( 'MUD_SCHEMADECL_UNIT_DAT', 'dat' );
define( 'MUD_SCHEMADECL_UNIT_JOB', 'job' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudSchemaDeclBase.php';
require_once __DIR__ . '/class/MudSchemaDecl.php';
require_once __DIR__ . '/class/MudDatabaseUpgrader.php';

require_once __DIR__ . '/class/MudModuleSchemadecl.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_schema_decl( $info, $type, $name_spec, $attrs, $prev, $file, $line ) {

  return mud_module_schemadecl()->new_mud_schema_decl( $info, $type, $name_spec, $attrs, $prev, $file, $line );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-10-16 jj5 - functional interface...
//
//

// 2021-10-17 jj5 - return the head of our schemadecl spec... it's a linked list...
//
function mud_load_schemadecl( $mud_dir = null, $app_dir = null ) {

  return mud_module_schemadecl()->load( $mud_dir, $app_dir );

}

// 2020-04-07 jj5 - generate flags data...
//
function mud_gen_flags( array $flags ) : array {

  return mud_module_schemadecl()->gen_flags( $flags );

}

// 2021-10-16 jj5 - define a table...
//
function def_tab( $tab_name, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_tab( $tab_name );

}

// 2021-10-16 jj5 - define a key column...
//
function def_key( string $col_name, string $col_type, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_key(
    $col_name,
    [
      'col_type' => $col_type,
      'spec' => $spec
    ]
  );

}

// 2021-10-16 jj5 - define a new standard column...
//
function def_col( string $col_name, string $col_type, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  if ( $col_type === DBT_ENUM ) {

    $min = MUD_MAX_UINT32;
    $max = 0;

    foreach ( $spec[ SPEC_ENUM ] as $value ) {

      $min = min( $min, mb_strlen( $value ) );
      $max = max( $max, mb_strlen( $value ) );

    }

    if ( ! array_key_exists( SPEC_MIN, $spec ) ) {

      $spec[ SPEC_MIN ] = $min;

    }

    if ( ! array_key_exists( SPEC_MAX, $spec ) ) {

      $spec[ SPEC_MAX ] = $max;

    }
  }

  return mud_module_schemadecl()->def_col(
    $col_name,
    [
      'col_type' => $col_type,
      'spec' => $spec,
    ]
  );

}

// 2022-02-20 jj5 - define a new collation duplicate column...
//
function def_dup( string $col_name, string $ref_col_name, string $col_type, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  $ref_tab_name = mud_module_schemadecl()->get_current_tab()->name;

  return mud_module_schemadecl()->def_dup(
    $col_name,
    [
      'col_type' => $col_type,
      'ref_tab_name' => $ref_tab_name,
      'ref_col_name' => $ref_col_name,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define a new virtual column...
//
function def_vrt( string $col_name, string $col_type, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_vrt(
    $col_name,
    [
      'col_type' => $col_type,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define a foreign key column, or a reference column, which takes its
// attributes from another column.
//
function def_ref( string $col_name, string $ref_tab_name, $ref_col_name = null, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  $ref_col_name = $ref_col_name ?? $col_name;

  return mud_module_schemadecl()->def_ref(
    $col_name,
    [
      'ref_tab_name' => $ref_tab_name,
      'ref_col_name' => $ref_col_name,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define a foreign key which is also a primary key...
//
function def_rek( string $col_name, string $ref_tab_name, $ref_col_name = null, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  $ref_col_name = $ref_col_name ?? $col_name;

  return mud_module_schemadecl()->def_rek(
    $col_name,
    [
      'ref_tab_name' => $ref_tab_name,
      'ref_col_name' => $ref_col_name,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define a virtual reference column...
//
function def_rev( string $col_name, string $ref_tab_name, $ref_col_name = null, $spec = [], $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  $ref_col_name = $ref_col_name ?? $col_name;

  return mud_module_schemadecl()->def_rev(
    $col_name,
    [
      'ref_tab_name' => $ref_tab_name,
      'ref_col_name' => $ref_col_name,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define a new flag column...
//
function def_flg(
  string $flags_col_name,
  string $ref_tab_name,
  string $ref_col_name,
  int $flag,
  $spec = [],
  $canary = null
) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_flg(
    $flags_col_name,
    [
      'ref_tab_name' => $ref_tab_name,
      'ref_col_name' => $ref_col_name,
      'flag' => $flag,
      'spec' => $spec,
    ]
  );

}

// 2021-10-16 jj5 - define an index on a table...
//
function def_idx( array $col_name_list, string $idx_type, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_idx(
    $col_name_list,
    [
      'col_name_list' => $col_name_list,
      'idx_type' => $idx_type,
    ]
  );

}

// 2021-10-17 jj5 - define a view...
//
function def_view( string $view_name, callable $fn, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_view(
    $view_name,
    [
      'fn' => $fn,
    ]
  );

}

// 2021-10-16 jj5 - define a sproc...
//
function def_proc( string $proc_name, callable $fn, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_proc(
    $proc_name,
    [
      'fn' => $fn,
    ]
  );

}

// 2021-10-16 jj5 - declare default data...
//
function def_dat( string $tab_name, array $col_spec, array $rows, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_dat(
    $tab_name,
    [
      'col_spec' => $col_spec,
      'rows' => $rows,
    ]
  );

}

// 2021-10-16 jj5 - declare runnable process...
//
function def_job( string $job_name, callable $fn, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->def_job(
    $job_name,
    [
      'fn' => $fn,
    ]
  );

}

// 2021-10-17 jj5 - find existing items for modification...

function mod_tab( $tab_name, $canary = null) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->mod_tab( $tab_name );

}

function mod_col( $col_name, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->mod_col( $col_name );

}

function mod_idx( $col_name_list, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->mod_idx( $col_name_list );

}

function mod_view( $view_name, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->mod_view( $view_name );

}

function mod_proc( $proc_name, $canary = null ) {

  if ( $canary !== null ) { mud_fail( MUD_ERR_SCHEMADECL_CANARY, [ 'canary' => $canary ] ); }

  return mud_module_schemadecl()->mod_proc( $proc_name );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_schemadecl() : MudModuleSchemadecl {

  return mud_locator()->get_module( MudModuleSchemadecl::class );

}
