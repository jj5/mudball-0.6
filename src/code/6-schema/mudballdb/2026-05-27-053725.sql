
-- 2026-05-27 jj5 - different types of identities:
-- AID - auto incrementing integer primary key
-- IID - internal ID
-- RID - foreign key pointing to AID or IID
-- XID - external ID

-- 2026-05-27 jj5 - namespace -> schema
-- bus -> mudballdb
-- std -> myappdb

create table t_abinitio_std_interaction (
  a_std_interaction_aid int unsigned not null auto_increment,
  -- 2026-05-27 jj5 - it's hard to get good info about what the best datatype to use here is,
  -- and I don't like using bigint unsigned because PHP can't represent it natively
  a_std_interaction_connection_id bigint unsigned not null,
  customer_name varchar( 255 ) collate utf8mb4_unicode_ci not null,
  customer_phone varchar( 50 ) collate ascii_general_ci not null,
  primary key ( a_std_interaction_aid ),
  unique index idx_customer_name ( customer_name )
)