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
