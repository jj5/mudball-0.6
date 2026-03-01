<?php

abstract class MudDatabaseWork {

  protected MudDatabaseConnection $connection;
  protected string $note;
  protected array $operation_list = [];

  use MudDatabaseValidation;

  public abstract function process() : void;

  public function __construct( MudDatabaseConnection $connection, string $note = '' ) {
    $this->connection = $connection;
    $this->note = $note;
  }

  public function register_operation( MudDatabaseAction $operation ) : void {
    $this->operation_list[] = $operation;
  }

  protected function do_process() : void {
    // 2026-01-23 jj5 - TODO: count number of errors/successes and log them somewhere...
    $operation_list = $this->operation_list;
    $error_count = 0;
    while ( $operation = array_shift( $operation_list ) ) {
      try {
        $operation->print();
        $operation->execute();
        $error_count = 0;
      }
      catch ( PDOException $ex ) {
        echo $ex->getMessage() . "\n\n";
        list( $code, $error, $message ) = $ex->errorInfo;
        if ( ++$error_count > count( $operation_list ) ) {
          $this->report_foreign_keys( 't_place' ); exit;
          throw new RuntimeException(
            "Could not complete all database operations due to constraint violations.",
            (int)$code,
            $ex
          );
        }
        if ( $code === "23000" && in_array( $error, [ 1451, 1452 ] ) ) {
          // 2026-01-24 jj5 - foreign key constraint violation; re-queue the operation.
          array_push( $operation_list, $operation );
          continue;
        }
        if ( $code === "42S01" && in_array( $error, [ 1050 ] ) ) {
          // 2026-01-24 jj5 - table already exists
          array_push( $operation_list, $operation );
          continue;
        }
        var_dump(
          $ex->errorInfo
        );
        throw $ex;
      }
    }
    $this->operation_list = [];
  }

  protected function get_pdo() : PDO {
    return $this->connection->get_pdo();
  }

  protected function report_foreign_keys( string $table_name ) {
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
        -- prefer reporting constraints on child tables first
        case when rc.table_name = rc.referenced_table_name then 1 else 0 end,
        rc.table_name,
        rc.constraint_name,
        kcu.ordinal_position
    ";
    $sql = "
      select
        rc.constraint_schema,
        rc.constraint_name,
        kcu.table_name        as child_table,
        group_concat(kcu.column_name order by kcu.ordinal_position) as child_cols,
        kcu.referenced_table_name as parent_table,
        group_concat(kcu.referenced_column_name order by kcu.ordinal_position) as parent_cols,
        rc.update_rule,
        rc.delete_rule
      from information_schema.referential_constraints rc
      join information_schema.key_column_usage kcu
        on  kcu.constraint_schema = rc.constraint_schema
        and kcu.constraint_name   = rc.constraint_name
      where rc.constraint_schema = :schema
        and rc.referenced_table_name = :table_name
      group by
        rc.constraint_schema, rc.constraint_name, kcu.table_name, kcu.referenced_table_name,
        rc.update_rule, rc.delete_rule
      order by child_table, rc.constraint_name;
    ";

    $stmt = $this->get_pdo()->prepare($sql);
    $stmt->execute([ 'schema' => $dbname, 'table_name' => $table_name ]);

    $constraints = [];

    foreach ($stmt as $row) {
        $constraints[] = $row;
    }

    var_dump( $constraints );

  }

}
