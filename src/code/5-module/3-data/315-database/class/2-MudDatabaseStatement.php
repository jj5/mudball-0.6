<?php

// 2021-04-06 jj5 - this class is just a little experiemnt. Was thinking I might override
// fetchAll() to automatically closeCursor()... not sure if that's useful or wise. Otherwise at
// the moment this class serves little purpose...

class MudDatabaseStatement extends PDOStatement {

  private static $count = 0;

  private $database;

  private function __construct( $database ) {

    $this->database = $database;

    //parent::__construct();

    self::$count++;

    //mud_stderr( self::class . '::' . __FUNCTION__ . " called.\n" );
    //mud_stderr( self::$count . " made.\n" );

  }

  /*
  public function __destruct() {

    //mud_stderr( self::class . '::' . __FUNCTION__ . " called.\n" );

  }
  */

  public function execute( $params = null ) : bool {

    try {

      return parent::execute( $params );

    }
    catch ( PDOException $ex ) {

      $this->database->rethrow( $ex );

    }
  }

  // 2022-11-09 jj5 - NEW:
  //
  public function fetchAll( int $fetch_style = PDO::FETCH_DEFAULT, mixed ...$args ): array {
  //
  // 2021-04-06 jj5 - OLD:
  //
  //public function fetchAll( $fetch_style = null, $fetch_argument = null, $ctor_args = null ) {
  //
  // 2021-04-06 jj5 - OLD: I had this based on the PDOStatement documentation but got the error:
  // Declaration of MudDatabaseStatement::fetchAll(int $fetch_style, mixed $fetch_argument, array $ctor_args = Array)
  // should be compatible with PDOStatement::fetchAll($how = NULL, $class_name = NULL, $ctor_args = NULL)
  //
  //public function fetchAll( int $fetch_style, mixed $fetch_argument, array $ctor_args = [] ) {

    $fetch_argument = $args[ 0 ] ?? null;
    $ctor_args = $args[ 1 ] ?? null;

    // 2021-04-07 jj5 - NOTE: there's a PDO bug which makes us do this as we do...
    //
    // 2021-04-07 jj5 - SEE: https://github.com/doctrine/dbal/issues/3975
    //
    if ( $ctor_args !== null ) {

      $result = parent::fetchAll( $fetch_style, $fetch_argument, $ctor_args );

    }
    elseif ( $fetch_argument !== null ) {

      $result = parent::fetchAll( $fetch_style, $fetch_argument );

    }
    elseif ( $fetch_style !== null ) {

      $result = parent::fetchAll( $fetch_style );

    }
    else {

      $result = parent::fetchAll();

    }

    $this->closeCursor();

    return $result;

  }
}
