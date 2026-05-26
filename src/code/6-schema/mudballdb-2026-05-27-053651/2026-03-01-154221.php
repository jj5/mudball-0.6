<?php

db_add_tab( 't_abinitio_std_interaction' );

  db_add_key( 'a_std_interaction_aid', DBT_AID32 );
  db_add_col( 'a_std_interaction_connection_id', DBT_INT64 )->default( '(connection_id())' );
  db_add_col( 'a_std_interaction_created_on', DBT_CREATED_ON );

db_add_sproc("
  create procedure sp_std_new_interaction()
  begin
    insert into t_abinitio_std_interaction () values ();
    set @a_std_interaction_aid = last_insert_id();
  end
");

db_add_tab( 't_about_std_migration' );

  db_add_key( 'a_std_migration_aid', DBT_AID32 );
  db_add_col( 'a_std_migration_schema', DBT_ASCII_BIN );
  db_add_col( 'a_std_migration_revision', DBT_ASCII_CHAR_BIN )->len( 17 );
  db_add_col( 'a_std_migration_created_on', DBT_CREATED_ON );
  db_add_ref( 'a_std_migration_created_in', 't_abinitio_std_interaction', 'a_std_interaction_aid' );


// 2026-03-09 jj5 - THINK: maybe the config tables use natural keys? config tables get history like entity tables do.
// 2026-03-09 jj5 - TODO: need to generate the triggers for config tables. we could generate history tables too?
//
db_add_tab( 't_config_std_application_status' );

  db_add_key( 'a_std_application_status_id', DBT_ID8 );
  db_add_ref( 'a_std_application_status_software_code', 't_about_std_software', 'a_std_software_code' );
  db_add_col( 'a_std_application_status_is_online', DBT_BOOL )->default( 0 );
  db_add_col( 'a_std_application_status_is_logging_cache_usage', DBT_BOOL )->default( 1 );
  db_add_col( 'a_std_application_status_is_logging_database_access', DBT_BOOL )->default( 1 );
  db_add_col( 'a_std_application_status_is_logging_database_access_count', DBT_BOOL )->default( 1 );
  db_add_col( 'a_std_application_status_is_logging_database_operation_count', DBT_BOOL )->default( 1 );
  db_add_col( 'a_std_application_status_is_logging_database_transaction_count', DBT_BOOL )->default( 1 );
  db_add_col( 'a_std_application_status_created_on', DBT_CREATED_ON );
  db_add_col( 'a_std_application_status_updated_on', DBT_UPDATED_ON );
