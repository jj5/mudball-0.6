<?php

abstract class MudActionLite_Statement extends MudActionLite {

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
