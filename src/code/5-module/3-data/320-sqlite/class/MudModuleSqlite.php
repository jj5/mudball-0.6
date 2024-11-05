<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - class definition...
//

class MudModuleSqlite extends MudModuleData {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleSqlite|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function create_pdo( $path, $fetch_mode = PDO::FETCH_NUM, $opt = [] ) {

    $opt[ PDO::ATTR_EMULATE_PREPARES    ] = $opt[ PDO::ATTR_EMULATE_PREPARES    ] ?? false;
    $opt[ PDO::ATTR_ERRMODE             ] = $opt[ PDO::ATTR_ERRMODE             ] ?? PDO::ERRMODE_EXCEPTION;
    $opt[ PDO::ATTR_DEFAULT_FETCH_MODE  ] = $opt[ PDO::ATTR_DEFAULT_FETCH_MODE  ] ?? $fetch_mode;

    $dsn = "sqlite:$path";

    for ( $try = 1; $try < 10; $try++ ) {

      try {

        $pdo = new_php_pdo( $dsn, '', '', $opt );

        // 2021-04-10 jj5 - SEE: SQLite Write-Ahead Logging: https://www.sqlite.org/wal.html
        //
        $pdo->exec( 'PRAGMA journal_mode = WAL' );

        // 2021-04-10 jj5 - SEE: https://www.sqlite.org/pragma.html#pragma_temp_store
        //
        $pdo->exec( 'PRAGMA temp_store = MEMORY' );

        // 2021-04-10 jj5 - SEE: https://www.sqlite.org/pragma.html#pragma_synchronous
        //
        $pdo->exec( 'PRAGMA synchronous = OFF' );

        // 2021-04-10 jj5 - SEE: https://www.sqlite.org/pragma.html#pragma_automatic_index
        //
        $pdo->exec( 'PRAGMA automatic_index = 0' );

        return $pdo;

      }
      catch( Exception $ex ) {

        mud_log_exception_ignored( $ex );

      }
    }

    mud_fail( MUD_ERR_SQLITE_CANNOT_CREATE_PDO, [ 'dsn' => $dsn ], $ex );

  }

}
