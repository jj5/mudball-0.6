<?php

abstract class MudConnectionLite extends MudService {

  protected MudDatabaseLite $database;
  protected MudPdoLite $pdo;

  protected int $connection_id;
  //use MudDatabaseValidation;

  public function __construct( MudDatabaseLite $database, MudPdoLite $pdo ) {

    parent::__construct();

    $this->database = $database;
    $this->pdo = $pdo;

    $statement_class = $pdo->getAttribute( PDO::ATTR_STATEMENT_CLASS )[ 0 ];

    assert( is_a( $statement_class, MudStatementLite::class, true ) );

    $this->connection_id = $pdo->query( 'select connection_id() as cid' )->fetchAll()[ 0 ][ 'cid' ];
    $this->pdo = $pdo;
    $this->initialize();

  }

  public function get_connection_id() : int {
    return $this->connection_id;
  }
  public function get_isolation_level() : string {
    return $this->get_pdo()->query( 'select @@tx_isolation as txi' )->fetchAll()[ 0 ][ 'txi' ];
  }
  abstract public function get_connection_type() : MudConnectionTypeLite;
  public function get_pdo() : MudPdoLite {
    return $this->pdo;
  }
  public function quote( $value ) { return $this->get_pdo()->quote( $value ); }
  public function exec( string $sql ) : int|false {
    $sql = $this->dedent( $sql );
    return $this->get_pdo()->exec( $sql );
  }
  public function query( string $sql, $mode = PDO::FETCH_ASSOC ) : array {
    $sql = $this->dedent( $sql );
    $stmt = $this->get_pdo()->query( $sql );
    return $stmt->fetchAll( $mode );
  }
  public function prepare( string $sql, array $options = [] ) : MudStatementLite|false {
    $sql = $this->dedent( $sql );
    return $this->get_pdo()->prepare( $sql, $options );
  }
  public function fetch(
    string $sql,
    array $args = [],
    array $options = [],
    $mode = PDO::FETCH_ASSOC
  ) : array {
    $stmt = $this->prepare( $sql, $options );
    $stmt->execute( $args );
    return $stmt->fetchAll( $mode );
  }
  public function get_auto_increment_id() : int {
    return $this->get_pdo()->lastInsertId();
  }
  public function is_in_transaction() : bool {
    return $this->get_pdo()->inTransaction();
  }
  public function begin() {
    $this->get_pdo()->beginTransaction();
  }
  public function commit() {
    $this->get_pdo()->commit();
  }
  public function cancel() {
    if ( ! $this->is_in_transaction() ) { return; }
    $this->rollback();
  }
  public function rollback() {
    $this->get_pdo()->rollBack();
  }
  public function schema_work() : MudWorkLite_Schema {
    return MudWorkLite_Schema::Create( $this );
  }
  public function privilege_work() : MudWorkLite_Privilege {
    return MudWorkLite_Privilege::Create( $this );
  }
  public function data_work() : MudWorkLite_Data {
    return MudWorkLite_Data::Create( $this );
  }
  protected function initialize() { ; }
  public function set_a_std_interaction_rid( $a_std_interaction_rid ) {
    $sql = "set @a_std_interaction_rid := $a_std_interaction_rid";
    echo $sql . "\n";
    $this->exec( $sql );
  }
  public function get_a_std_interaction_rid() {
    $sql = "select @a_std_interaction_rid as a_std_interaction_rid";
    return $this->query( $sql )[ 0 ][ 'a_std_interaction_rid' ];
  }
  public function print_info() {

    $conn_id = $this->get_connection_id();
    $conn_tx = $this->get_isolation_level();

    mud_stderr( "\n" );
    mud_stderr( "class..: " . get_class( $this ) . "\n" );
    mud_stderr( "id conn: $conn_id\n" );
    mud_stderr( "db type: " . $this->get_connection_type()->name . "\n" );
    mud_stderr( "db tran: " . ( $this->is_in_transaction() ? 'yes' : 'no' ) . "\n" );
    mud_stderr( "db name: " . DB_NAME . "\n" );
    mud_stderr( "db host: " . DB_HOST . "\n" );
    mud_stderr( "db user: " . DB_USER . "\n" );
    mud_stderr( "db conn: $conn_tx\n\n" );

  }
  public function dedent( string $text ) : string {
    $lines = explode("\n", $text);
    $minIndent = null;
    foreach ($lines as $line) {
        // Skip blank lines
        if (trim($line) === '') {
            continue;
        }
        preg_match('/^( *)/', $line, $matches);
        $indent = strlen($matches[1]);

        if ($minIndent === null || $indent < $minIndent) {
            $minIndent = $indent;
        }
    }
    if ($minIndent === null || $minIndent === 0) {
        return $text;
    }
    foreach ($lines as &$line) {
        $line = preg_replace('/^ {0,' . $minIndent . '}/', '', $line);
    }
    return trim( implode("\n", $lines) );
  }
  public function has_table( string $table_name ) : bool {
    $sql = "select 1 from information_schema.tables where table_schema = database() and table_name = :table_name";
    $result = $this->fetch( $sql, [ ':table_name' => $table_name ] );
    return count( $result ) > 0;
  }
}
