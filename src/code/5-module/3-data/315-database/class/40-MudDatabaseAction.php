<?php

abstract class MudDatabaseAction {

  private static int $next_action_id = 1;

  protected int $action_id;
  protected MudDatabaseConnection $connection;
  protected string $sql;

  public function __construct( MudDatabaseConnection $connection, string $sql ) {
    $this->action_id = self::$next_action_id++;
    $this->connection = $connection;
    $this->sql = $sql;
  }

  public abstract function get_type() : MudDatabaseMutation;
  public abstract function execute() : int|false;

  public function print() {
    echo "Action ID: " . $this->action_id . "\n";
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
