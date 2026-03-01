<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - include dependencies...
//

require_once __DIR__ . '/../320-sqlite/mud_sqlite.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - module errors...
//



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - include components...
//

mud_load_files( __DIR__ . '/1-enum' );
mud_load_files( __DIR__ . '/2-interface' );
mud_load_files( __DIR__ . '/3-class' );


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - functional interface...
//

function mud_is_valid_table_name( string $name ) : bool {

  return mud_module_schema()->is_valid_table_name( $name );

}

function mud_validate_connection(
  PDO $pdo,
  string $expected_isolation_level,
  string|null $expected_time_zone = null,
  string $expected_character_set = 'utf8mb4',
  string $expected_collation = 'utf8mb4_uca1400_ai_ci',
) {

  return mud_module_schema()->validate_connection(
    $pdo,
    $expected_isolation_level,
    $expected_time_zone,
    $expected_character_set,
    $expected_collation,
  );

}

function mud_get_database( $name ) : MudSchemaDatabase {

  return mud_module_schema()->get_database( $name );

}

function mud_get_migration() : MudSchemaMigration {

  return mud_module_schema()->get_migration();

}

function db_add_tab( $table_name ) : MudSchemaAddition_Table {

  return mud_module_schema()->add_tab( $table_name );

}

function db_add_key( $col_name, $col_type ) : MudSchemaAddition_ColumnKey {

  return mud_module_schema()->add_key( $col_name, $col_type );

}

function db_add_col( $col_name, $col_type ) : MudSchemaAddition_Column {

  return mud_module_schema()->add_col( $col_name, $col_type );

}

function db_add_ref( $ref_name, $ref_table, $ref_col ) : MudSchemaAddition_ColumnReference {

  return mud_module_schema()->add_ref( $ref_name, $ref_table, $ref_col );

}

function db_add_sproc( $sproc_sql ) : MudSchemaAddition_Sproc {

  return mud_module_schema()->add_sproc( $sproc_sql );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-03-01 jj5 - service locator...
//

function mud_module_schema() : MudModuleSchema {

  return mud_locator()->get_module( MudModuleSchema::class );

}
