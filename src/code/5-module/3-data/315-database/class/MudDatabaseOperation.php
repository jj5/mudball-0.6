<?php

abstract class MudDatabaseOperation {

  private static int $next_operation_id = 1;

  protected int $operation_id;
  protected MudDatabaseConnection $connection;
  protected string $sql;

  public function __construct( MudDatabaseConnection $connection, string $sql ) {
    $this->operation_id = self::$next_operation_id++;
    $this->connection = $connection;
    $this->sql = $sql;
  }

  public abstract function get_type() : MudDatabaseMutation;
  public abstract function execute() : int|false;

  public function print() {
    echo "Operation ID: " . $this->operation_id . "\n";
    echo "Type: " . $this->get_type()->name . "\n";
    echo "SQL: " . $this->trim_sql( $this->sql ) . "\n\n";
  }

  protected function trim_sql( string $sql ) : string {
    $trimmed = preg_replace( '/\s+/', ' ', trim( $sql ) );
    return $trimmed;
    return $this->ellipsis( $trimmed ) ?? $sql;
  }
  protected function ellipsis( string $text, int $max_length = 99 ) : string {
    if ( strlen( $text ) <= $max_length ) {
      return $text;
    }
    return substr( $text, 0, $max_length - 3 ) . '...';
  }

  public function is_ddl() : bool {

    return mud_is_ddl( $this->sql );

  }

  public function is_dcl() : bool {

    return mud_is_dcl( $this->sql );

  }

  public function is_dml() : bool {

    return mud_is_dml( $this->sql );

  }

  protected function get_sql_start() {

    $start = substr( $this->sql, 0, 64 );

    return strtoupper( preg_replace( '/\s+/', ' ', trim( $start ) ) );

  }

}

class MudDatabaseExec extends MudDatabaseOperation {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::EXEC;
  }

  public function execute() : int|false {
    //$sql = $this->connection->dedent( $this->sql );
    return $this->connection->exec( $this->sql );
    //$records_affected = $this->connection->get_pdo()->exec( $this->sql );
  }
}

abstract class MudDatabaseOperationBase extends MudDatabaseOperation {

  protected MudDatabaseStatement $statement;
  protected array $data;

  public function __construct(
    MudDatabaseConnection $connection,
    string $sql,
    MudDatabaseStatement $statement,
    array $data = []
  ) {
    parent::__construct( $connection, $sql );
    $this->statement = $statement;
    $this->data = $data;
  }

  public function execute() : int|false {
    return $this->statement->execute( $this->data );
  }
}

class MudDatabaseInsert extends MudDatabaseOperationBase {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::INSERT;
  }
}

class MudDatabaseUpdate extends MudDatabaseOperationBase {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::UPDATE;
  }
}

class MudDatabaseDelete extends MudDatabaseOperationBase {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::DELETE;
  }
}

class MudDatabaseSchema extends MudDatabaseOperationBase {

  public function get_type() : MudDatabaseMutation {
    return MudDatabaseMutation::SCHEMA;
  }
}
