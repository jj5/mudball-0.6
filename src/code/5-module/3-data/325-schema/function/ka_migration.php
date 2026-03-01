<?php

function ka_migration() : Kickass\SchemaMigration {

  global $migration;

  return $migration;

}

function ka_add_tab( $table_name, Kickass\TabType $table_type ) : Kickass\SchemaAddition_Table {

  return ka_migration()->add_tab( $table_name, $table_type );

}

function ka_add_key( $col_name, Kickass\ColType $col_type ) : Kickass\SchemaAddition_ColumnKey {

  return ka_migration()->curr_tab()->add_key( $col_name, $col_type );

}

function ka_add_col( $col_name, Kickass\ColType $col_type ) : Kickass\SchemaAddition_Column {

  return ka_migration()->curr_tab()->add_col( $col_name, $col_type );

}

function ka_add_ref( $ref_name, $ref_table, $ref_col ) : Kickass\SchemaAddition_ColumnReference {

  return ka_migration()->curr_tab()->add_ref( $ref_name, $ref_table, $ref_col );

}

function ka_add_sproc( $sproc_sql ) : Kickass\SchemaAddition_Sproc {

  return ka_migration()->add_sproc( $sproc_sql );

}
