<?php

class MudDatabaseWork_Schema extends MudDatabaseWork {

  // 2026-01-28 jj5 - no transactions

  public function drop_table( string $table_name ) : void {
    $this->validate_name( $table_name );
    //$this->drop_foreign_keys( $table_name );
    $ddl = "drop table if exists $table_name";
    $this->register_operation( new MudDatabaseExec( $this->connection, $ddl ) );
  }
  public function drop_foreign_keys( string $table_name ) {
    $this->validate_name( $table_name );
    $dbname = DB_NAME;
    $sql = "
      select
          rc.constraint_name,
          rc.table_name,
          rc.referenced_table_name,
          kcu.ordinal_position
      from information_schema.referential_constraints rc
      join information_schema.key_column_usage kcu
        on kcu.constraint_schema = rc.constraint_schema
      and kcu.constraint_name   = rc.constraint_name
      and kcu.table_name        = rc.table_name
      where rc.constraint_schema = :schema
        and rc.table_name = :table_name
        and kcu.referenced_table_name is not null
      order by
        -- prefer dropping constraints on child tables first
        case when rc.table_name = rc.referenced_table_name then 1 else 0 end,
        rc.table_name,
        rc.constraint_name,
        kcu.ordinal_position
    ";

    $stmt = $this->get_pdo()->prepare($sql);
    $stmt->execute([ 'schema' => $dbname, 'table_name' => $table_name ]);

    // Deduplicate (because KEY_COLUMN_USAGE returns one row per column in a multi-column FK)
    $seen = [];
    $constraints = [];

    foreach ($stmt as $row) {
        $key = $row['table_name'] . "\0" . $row['constraint_name'];
        if (!isset($seen[$key])) {
            $seen[$key] = true;
            $constraints[] = [
                'table' => $row['table_name'],
                'constraint' => $row['constraint_name'],
                'is_self_ref' => ($row['table_name'] === $row['referenced_table_name']),
            ];
        }
    }

    /**
    * Output SQL.
    * - First: non-self-referencing FKs (typical parent/child)
    * - Then: self-referencing FKs
    */

    foreach ([false, true] as $selfRef) {
        foreach ($constraints as $c) {
            if ($c['is_self_ref'] !== $selfRef) continue;
            $table = str_replace('`', '``', $c['table']);
            $fk    = str_replace('`', '``', $c['constraint']);
            $ddl = "ALTER TABLE `{$dbname}`.`{$table}` DROP FOREIGN KEY `{$fk}`";
            $this->register_operation(
              //new MudDatabaseSchema( $ddl, $this->get_pdo()->prepare( $ddl ) )
              new MudDatabaseExec( $this->connection, $ddl )
            );
        }
    }
  }

  public function create_table( string $ddl ) : void {
    $this->register_operation( new MudDatabaseExec( $this->connection, $ddl ) );
  }

  public function create_trigger( string $ddl ) : void {
    $this->register_operation( new MudDatabaseExec( $this->connection, $ddl ) );
  }

  public function create_sproc( string $ddl ) : void {
    $this->register_operation( new MudDatabaseExec( $this->connection, $ddl ) );
  }

  public function process() : void {

    $this->do_process();

  }
}
