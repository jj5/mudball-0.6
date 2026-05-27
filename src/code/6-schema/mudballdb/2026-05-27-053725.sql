
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
  a_std_interaction_connection_id bigint unsigned not null default ( connection_id() ),
  primary key ( a_std_interaction_aid )
);
