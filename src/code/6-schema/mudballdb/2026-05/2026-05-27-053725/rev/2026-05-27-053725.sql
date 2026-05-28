
-- 2026-05-27 jj5 - different types of identities:
-- AID - auto incrementing integer primary key
-- IID - internal ID
-- RID - foreign key pointing to AID or IID
-- XID - external ID
-- HID - historical ID

-- 2026-05-27 jj5 - namespace -> schema
-- bus -> mudballdb
-- std -> myappdb

create table t_abinitio__std_interaction_time_zone (
  a_std_interaction_time_zone_aid smallint unsigned not null auto_increment,
  a_std_interaction_time_zone_name varchar( 255 ) collate ascii_bin not null default ( @@session.time_zone ),
  a_std_interaction_time_zone_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_interaction_time_zone_aid ),
  unique key ( a_std_interaction_time_zone_name )
);

create trigger bu_t_abinitio__std_interaction_time_zone
before update on t_abinitio__std_interaction_time_zone
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create table t_abinitio__std_interaction (
  a_std_interaction_aid int unsigned not null auto_increment,
  -- 2026-05-27 jj5 - it's hard to get good info about what the best datatype to use here is,
  -- and I don't like using bigint unsigned because PHP can't represent it natively. the numbers I see for
  -- connection_id() are in the tens of thousands, so signed 64-bit int should be safe enough.
  a_std_interaction_connection_id bigint not null default ( connection_id() ),
  a_std_interaction_interaction_time_zone_rid smallint unsigned not null,
  a_std_interaction_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_interaction_aid ),
  foreign key ( a_std_interaction_interaction_time_zone_rid )
    references t_abinitio__std_interaction_time_zone ( a_std_interaction_time_zone_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_abinitio__std_interaction
before update on t_abinitio__std_interaction
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create procedure sp_std_new_interaction()
begin

  -- 2026-05-28 jj5 - THINK: if we already allocated an interaction id do we still want to allocate a new one if asked?
  -- for now we do.

  declare var_interaction_time_zone varchar( 255 ) collate ascii_bin;

  set var_interaction_time_zone = @@session.time_zone;

  insert ignore into t_abinitio__std_interaction_time_zone ( a_std_interaction_time_zone_name )
  values ( var_interaction_time_zone );

  set @a_std_interaction_time_zone_rid = (
    select
      a_std_interaction_time_zone_aid
    from
      t_abinitio__std_interaction_time_zone
    where
      a_std_interaction_time_zone_name = var_interaction_time_zone
  );

  insert into t_abinitio__std_interaction ( a_std_interaction_interaction_time_zone_rid )
  values ( @a_std_interaction_time_zone_rid );

  set @a_std_interaction_rid = last_insert_id();

end;

call sp_std_new_interaction();

create table t_particle__std_schema_name (
  a_std_schema_name_aid smallint unsigned not null auto_increment,
  a_std_schema_name varchar( 255 ) collate ascii_bin not null,
  a_std_schema_name_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_schema_name_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_schema_name_aid ),
  unique key ( a_std_schema_name ),
  foreign key ( a_std_schema_name_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_particle__std_schema_name
before update on t_particle__std_schema_name
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create table t_journal__std_schema_migration (
  a_std_schema_migration_aid int unsigned not null auto_increment,
  a_std_schema_migration_schema_name_rid smallint unsigned not null,
  a_std_schema_migration_revision datetime not null,
  a_std_schema_migration_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_schema_migration_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_schema_migration_aid ),
  unique key ( a_std_schema_migration_schema_name_rid, a_std_schema_migration_revision ),
  foreign key ( a_std_schema_migration_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

-- create trigger bu_t_about__std_schema_migration
-- before update on t_about__std_schema_migration
-- for each row
-- begin
--   set new.a_std_schema_migration_updated_in = @a_std_interaction_rid;
-- end;

create trigger bu_t_journal__std_schema_migration
before update on t_journal__std_schema_migration
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create trigger bd_t_journal__std_schema_migration
before delete on t_journal__std_schema_migration
for each row
begin
  signal sqlstate '45000' set message_text = 'deletes are not allowed.';
end;

create table t_particle__std_software_code (
  a_std_software_code_aid smallint unsigned not null auto_increment,
  a_std_software_code varchar( 255 ) collate ascii_bin not null,
  a_std_software_code_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_software_code_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  primary key ( a_std_software_code_aid ),
  unique key ( a_std_software_code ),
  foreign key ( a_std_software_code_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_particle__std_software_code
before update on t_particle__std_software_code
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create table t_ident__std_iid (
  a_std_iid_from int unsigned not null primary key,
  a_std_iid_thru int unsigned not null unique key,
  a_std_iid_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_iid_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  foreign key ( a_std_iid_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bu_t_ident__std_iid
before update on t_ident__std_iid
for each row
begin
  signal sqlstate '45000' set message_text = 'updates are not allowed.';
end;

create trigger bd_t_ident__std_iid
before delete on t_ident__std_iid
for each row
begin
  signal sqlstate '45000' set message_text = 'deletes are not allowed.';
end;

insert into t_ident__std_iid ( a_std_iid_from, a_std_iid_thru ) values ( 0, 0 );

create table t_history__std_user (
  a_std_user_hid int unsigned not null auto_increment,
  a_std_user_iid int unsigned not null,
  a_std_user_password_hash varchar( 255 ) collate ascii_bin not null,
  a_std_user_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  a_std_user_updated_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_updated_on datetime( 6 ) not null default current_timestamp( 6 ) on update current_timestamp( 6 ),
  primary key ( a_std_user_hid ),
  foreign key ( a_std_user_hid )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_updated_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create table t_entity__std_user (
  a_std_user_iid int unsigned not null,
  a_std_user_rowversion int unsigned not null,
  a_std_user_password_hash varchar( 255 ) collate ascii_bin not null,
  a_std_user_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  a_std_user_updated_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_updated_on datetime( 6 ) not null default current_timestamp( 6 ) on update current_timestamp( 6 ),
  a_std_user_deleted_in int unsigned null default null,
  a_std_user_deleted_on datetime( 6 ) null default null,
  primary key ( a_std_user_iid ),
  foreign key ( a_std_user_rowversion )
    references t_history__std_user ( a_std_user_hid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_updated_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bi_t_entity__std_user
before insert on t_entity__std_user
for each row
begin

  insert into t_history__std_user (
    a_std_user_iid,
    a_std_user_password_hash,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on
  )
  values (
    new.a_std_user_iid,
    new.a_std_user_password_hash,
    new.a_std_user_created_in,
    new.a_std_user_created_on,
    new.a_std_user_updated_in,
    new.a_std_user_updated_on
  );

  set new.a_std_user_rowversion = last_insert_id();

end;

create trigger bu_t_entity__std_user
before update on t_entity__std_user
for each row
begin

  insert into t_history__std_user (
    a_std_user_iid,
    a_std_user_password_hash,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on
  )
  values (
    new.a_std_user_iid,
    new.a_std_user_password_hash,
    new.a_std_user_created_in,
    new.a_std_user_created_on,
    new.a_std_user_updated_in,
    new.a_std_user_updated_on
  );

  set new.a_std_user_rowversion = last_insert_id();

end;

create trigger bd_t_entity__std_user
before delete on t_entity__std_user
for each row
begin

  insert into t_history__std_user (
    a_std_user_iid,
    a_std_user_password_hash,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on,
    a_std_user_deleted_in,
    a_std_user_deleted_on
  )
  values (
    old.a_std_user_iid,
    old.a_std_user_password_hash,
    old.a_std_user_created_in,
    old.a_std_user_created_on,
    old.a_std_user_updated_in,
    old.a_std_user_updated_on,
    @a_std_interaction_rid,
    current_timestamp( 6 )
  );

end;

create table t_history__std_user_pii (
  a_std_user_hid int unsigned not null auto_increment,
  a_std_user_iid int unsigned not null,
  a_std_user_username varchar( 255 ) collate ascii_bin not null,
  a_std_user_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  a_std_user_updated_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_updated_on datetime( 6 ) not null default current_timestamp( 6 ) on update current_timestamp( 6 ),
  primary key ( a_std_user_hid ),
  foreign key ( a_std_user_hid )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_updated_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create table t_entity__std_user_pii (
  a_std_user_iid int unsigned not null,
  a_std_user_rowversion int unsigned not null,
  a_std_user_username varchar( 255 ) collate ascii_bin not null,
  a_std_user_created_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_created_on datetime( 6 ) not null default current_timestamp( 6 ),
  a_std_user_updated_in int unsigned not null default ( @a_std_interaction_rid ),
  a_std_user_updated_on datetime( 6 ) not null default current_timestamp( 6 ) on update current_timestamp( 6 ),
  a_std_user_deleted_in int unsigned null default null,
  a_std_user_deleted_on datetime( 6 ) null default null,
  primary key ( a_std_user_iid ),
  foreign key ( a_std_user_iid )
    references t_entity__std_user ( a_std_user_iid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_rowversion )
    references t_history__std_user_pii ( a_std_user_hid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_created_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict,
  foreign key ( a_std_user_updated_in )
    references t_abinitio__std_interaction ( a_std_interaction_aid )
    on update restrict
    on delete restrict
);

create trigger bi_t_entity__std_user_pii
before insert on t_entity__std_user_pii
for each row
begin

  insert into t_history__std_user_pii (
    a_std_user_iid,
    a_std_user_username,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on
  )
  values (
    new.a_std_user_iid,
    new.a_std_user_username,
    new.a_std_user_created_in,
    new.a_std_user_created_on,
    new.a_std_user_updated_in,
    new.a_std_user_updated_on
  );

  set new.a_std_user_rowversion = last_insert_id();

end;

create trigger bu_t_entity__std_user_pii
before update on t_entity__std_user_pii
for each row
begin

  insert into t_history__std_user_pii (
    a_std_user_iid,
    a_std_user_username,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on
  )
  values (
    new.a_std_user_iid,
    new.a_std_user_username,
    new.a_std_user_created_in,
    new.a_std_user_created_on,
    new.a_std_user_updated_in,
    new.a_std_user_updated_on
  );

  set new.a_std_user_rowversion = last_insert_id();

end;

create trigger bd_t_entity__std_user_pii
before delete on t_entity__std_user_pii
for each row
begin

  insert into t_history__std_user_pii (
    a_std_user_iid,
    a_std_user_username,
    a_std_user_created_in,
    a_std_user_created_on,
    a_std_user_updated_in,
    a_std_user_updated_on,
    a_std_user_deleted_in,
    a_std_user_deleted_on
  )
  values (
    old.a_std_user_iid,
    old.a_std_user_username,
    old.a_std_user_created_in,
    old.a_std_user_created_on,
    old.a_std_user_updated_in,
    old.a_std_user_updated_on,
    @a_std_interaction_rid,
    current_timestamp( 6 )
  );

end;
