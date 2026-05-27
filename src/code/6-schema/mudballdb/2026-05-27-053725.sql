
-- 2026-05-27 jj5 - different types of identities:
-- AID - auto incrementing integer primary key
-- IID - internal ID
-- RID - foreign key pointing to AID or IID
-- XID - external ID

-- 2026-05-27 jj5 - namespace -> schema
-- bus -> mudballdb
-- std -> myappdb

create table t_abinitio_std_time_zone (
  a_std_time_zone_aid smallint unsigned not null auto_increment,
  a_std_time_zone_name varchar( 255 ) collate ascii_bin not null default ( @@session.time_zone ),
  a_std_time_zone_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_time_zone_aid ),
  unique key ( a_std_time_zone_name )
);

create trigger bu_t_abinitio_std_time_zone
before update on t_abinitio_std_time_zone
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create table t_abinitio_std_interaction (
  a_std_interaction_aid int unsigned not null auto_increment,
  -- 2026-05-27 jj5 - it's hard to get good info about what the best datatype to use here is,
  -- and I don't like using bigint unsigned because PHP can't represent it natively
  a_std_interaction_connection_id bigint unsigned not null default ( connection_id() ),
  a_std_interaction_time_zone_rid smallint unsigned not null,
  a_std_interaction_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_interaction_aid ),
  foreign key ( a_std_interaction_time_zone_rid )
    references t_abinitio_std_time_zone ( a_std_time_zone_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_abinitio_std_interaction
before update on t_abinitio_std_interaction
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create procedure sp_std_new_interaction()
begin

  declare var_time_zone varchar( 255 ) collate ascii_bin;

  set var_time_zone = @@session.time_zone;

  insert ignore into t_abinitio_std_time_zone (
    a_std_time_zone_name
  )
  values (
    var_time_zone
  );

  set @a_std_time_zone_rid = (
    select a_std_time_zone_aid from t_abinitio_std_time_zone where a_std_time_zone_name = var_time_zone
  );

  insert into t_abinitio_std_interaction ( a_std_interaction_time_zone_rid ) values ( @a_std_time_zone_rid );

  set @a_std_interaction_aid = last_insert_id();

end;

call sp_std_new_interaction();

create table t_particle_std_schema_name (
  a_std_schema_name_aid smallint unsigned not null auto_increment,
  a_std_schema_name varchar( 255 ) collate ascii_bin not null,
  a_std_schema_name_created_in int unsigned not null default ( @a_std_interaction_aid ),
  a_std_schema_name_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_schema_name_aid ),
  unique key ( a_std_schema_name ),
  foreign key ( a_std_schema_name_created_in )
    references t_abinitio_std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_particle_std_schema_name
before update on t_particle_std_schema_name
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create table t_about_std_migration (
  a_std_migration_aid int unsigned not null auto_increment,
  a_std_migration_schema_name_rid smallint unsigned not null,
  a_std_migration_revision datetime not null,
  a_std_migration_created_in int unsigned not null default ( @a_std_interaction_aid ),
  a_std_migration_updated_in int unsigned not null default ( @a_std_interaction_aid ),
  a_std_migration_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  a_std_migration_updated_on datetime( 6 ) not null default current_timestamp( 6 ) on update current_timestamp( 6 ),
  primary key ( a_std_migration_aid ),
  unique key ( a_std_migration_schema_name_rid, a_std_migration_revision ),
  foreign key ( a_std_migration_created_in )
    references t_abinitio_std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_about_std_migration
before update on t_about_std_migration
for each row
begin
  set new.a_std_migration_updated_in = @a_std_interaction_aid;
end;
