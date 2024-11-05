<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - class definition...
//

abstract class MudDalBase extends MudService {

  use MudDatabaseTraits;
  //use MudDalHousekeeping;
  //use MudDalProcedures;


  // 2019-12-02 jj5 - our cache object...
  //
  protected $cache;

  /*
  // 2019-07-08 jj5 - pdo_raw is for logging, it uses autocommit transactions...
  //
  private $pdo_raw;

  // 2021-04-14 jj5 - pdo_emu uses emulated prepared statements and autocommit transactions...
  //
  private $pdo_emu;

  // 2019-07-08 jj5 - pdo_trn is for transactions, it doesn't use autocommit
  // and has REPEATABLE READ transaction isolation...
  //
  private $pdo_trn;

  // 2021-03-30 jj5 - we can disable the trn connection when it is no longer needed, for example
  // you could disable trn before rendering your views.
  //
  private $pdo_trn_disable = false;
  */

  private $database;


  private $entity_id_list = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudDalBase|null $previous = null ) {

    parent::__construct( $previous );

  }



  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-10 jj5 - public methods...
  //

  public function is_online() {

    return app()->is_online();

  }

  public function get_interaction_id() { return mud_interaction()->get_interaction_id(); }

  public function new_entity_id() {

    if ( ! $this->entity_id_list ) { $this->entity_id_list = $this->run_p_gen_mud_entity_id(); }

    return array_shift( $this->entity_id_list );

  }

  public function is_in_transaction() {

    return $this->get_database()->is_in_transaction();

  }

  public function has_table( $tab_name ) {

    $full_tab_name = "{$this->get_prefix()}{$tab_name}";

    return $this->get_database()->has_table( $full_tab_name );

  }

  public function get_prefix() { return $this->get_database()->get_prefix(); }

  public function get_cache() {

    if ( ! $this->cache ) { $this->cache = new_mud_cache( 'dal' ); }

    return $this->cache;

  }

  public function get_database() {

    if ( ! $this->database ) {

      $this->database = $this->new_database();

    }

    return $this->database;

  }

  public function query( string $sql, array $params = [] ) {

    return $this->get_database()->query( $sql, $params )->fetchAll();

  }

  /*
  // 2019-10-16 jj5 - the raw database connection is available to the public...
  //
  public function get_raw() {

    if ( ! $this->pdo_raw ) {

      $pdo = mud_factory()->get_raw();

      $pdo->set_logger( $this );

      $this->pdo_raw = $pdo;

    }

    return $this->pdo_raw;

  }

  // 2021-04-14 jj5 - the emu database connection is available to the public...
  //
  public function get_emu() {

    if ( ! $this->pdo_emu ) {

      $pdo = mud_factory()->get_emu();

      $pdo->set_logger( $this );

      $this->pdo_emu = $pdo;

    }

    return $this->pdo_emu;

  }

  // 2019-10-16 jj5 - the trn database connection must be accessed via the
  // use_trn() method which will verify an open transaction exists...
  //
  // 2019-10-20 jj5 - NOTE: this was made public because there are use cases
  // for having the client manage the transaction, but be careful if you
  // use this, make sure you start a transaction before operating on the DB...
  //
  // 2019-11-04 jj5 - NOTE: this was made protected again...
  //
  // 2019-11-13 jj5 - fuck it, let's make this private... call use_trn() for
  // access.
  //
  private function get_trn() {

    if ( $this->pdo_trn_disable ) { mud_fail( MUD_ERR_DAL_TRN_DISABLED ); }

    if ( ! $this->pdo_trn ) {

      $pdo = mud_factory()->get_trn();

      $pdo->set_logger( $this );

      $this->pdo_trn = $pdo;

    }

    return $this->pdo_trn;

  }
  */


  public function get_row( string $tab_name, array $query_map ) {

    $this->use_database( $prefix, $pdo );

    return $this->get_row_pdo(
      $tab_name,
      $query_map,
      $prefix,
      $pdo
    );

  }

  public function get_row_pdo(
    string $tab_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    //var_dump( $query_map );

    $this->validate_map( $query_map );

    //var_dump( $query_map ); exit;

    $sql = $this->get_sql_select(
      $tab_name,
      '*',
      $query_map,
      $prefix,
      $params
    );

    $result = $pdo->get_row( $sql, $params );

    return $result;

  }

  public function get_field_cached(
    string $tab_name,
    string $col_name,
    array $query_map
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->get_field_cached_pdo(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $pdo
    );

  }

  public function get_field_cached_pdo(
    string $tab_name,
    string $col_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $query_map );

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name );

    $cache_name = "$tab_name-$col_name";
    $query = mud_hash_hex( serialize( $query_map ) );

    if ( $this->get_cache()->read( $cache_name, $query, $cache_key, $result ) ) {

      return $result;

    }

    $result = $this->get_field_pdo(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $pdo
    );

    if ( $result === null ) { return null; }

    $this->get_cache()->write( $cache_name, $cache_key, $result );

    return $result;

  }

  public function get_field_cached_binary(
    string $tab_name,
    string $col_name,
    array $query_map
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->get_field_cached_binary_pdo(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $pdo
    );

  }

  public function get_field_cached_binary_pdo(
    string $tab_name,
    string $col_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $query_map );

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name );

    $cache_name = "$tab_name-$col_name";
    $query = mud_hash_hex( serialize( $query_map ) );

    if ( $this->get_cache()->read( $cache_name, $query, $cache_key, $result ) ) {

      return base64_decode( $result );

    }

    $result = $this->get_field_pdo(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $pdo
    );

    if ( $result === null ) { return null; }

    $this->get_cache()->write( $cache_name, $cache_key, base64_encode( $result ) );

    return $result;

  }

  public function get_field(
    string $tab_name,
    string $col_name,
    array $query_map
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->get_field_pdo(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $pdo
    );

  }

  public function get_field_pdo(
    string $tab_name,
    string $col_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $query_map );

    $sql = $this->get_sql_select(
      $tab_name,
      $col_name,
      $query_map,
      $prefix,
      $params
    );

    $result = $pdo->get_field( $sql, $params, $col_name );

    $result = mud_get_db_value( $col_name, $result );

    return $result;

  }

  public function insert_id(
    string $tab_name,
    array $row
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->insert_id_pdo(
      $tab_name,
      $row,
      $prefix,
      $pdo
    );

  }

  public function insert_id_pdo(
    string $tab_name,
    array $row,
    string $prefix,
    $pdo
  ) {

    return $this->insert_pdo( $tab_name, $row, $prefix, $pdo, 'run_insert_id' );

  }

  public function insert(
    string $tab_name,
    array $row
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->insert_pdo(
      $tab_name,
      $row,
      $prefix,
      $pdo
    );

  }

  public function insert_pdo(
    string $tab_name,
    array $row,
    string $prefix,
    $pdo,
    $method = 'run_insert'
  ) {

    $this->validate_map( $row );

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $cols = [];
    $values = [];
    $params = [];

    foreach ( $row as $column => $value ) {

      $this->ensure_safe( $column );

      $cols[] = $column;
      $param = ":$column";
      $values[] = $param;

      if ( is_bool( $value ) ) { $value = $value ? 1 : 0; }

      $params[ $param ] = $value;

    }

    $sql_cols = implode( ', ', $cols );
    $sql_values = implode( ', ', $values );

    $sql = "insert into {$table} ( $sql_cols ) values ( $sql_values )";

    //var_dump( $params ); mud_exit();

    $result = $pdo->$method( $sql, $params );

    return $result;

  }

  public function upsert(
    string $tab_name,
    array $row
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->upsert_pdo(
      $tab_name,
      $row,
      $prefix,
      $pdo
    );

  }

  public function upsert_pdo(
    string $tab_name,
    array $row,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $row );

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $cols = [];
    $values = [];
    $params = [];
    $update = [];

    foreach ( $row as $column => $value ) {

      $this->ensure_safe( $column );

      $cols[] = $column;
      $param = ":$column";
      $values[] = $param;
      $update[] = "$column = VALUES( $column )";

      if ( is_bool( $value ) ) { $value = $value ? 1 : 0; }

      $params[ $param ] = $value;

    }

    $sql_cols = implode( ', ', $cols );
    $sql_values = implode( ', ', $values );
    $sql_update = implode( ', ', $update );

    $sql = "
      insert into {$table} (
        $sql_cols
      )
      values (
        $sql_values
      )
      on duplicate key update
        $sql_update
    ";

    //var_dump( $params ); mud_exit();

    $result = $pdo->run_upsert( $sql, $params );

    return $result;

  }

  public function update(
    string $tab_name,
    array $row
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->update_pdo(
      $tab_name,
      $row,
      $prefix,
      $pdo
    );

  }

  public function update_pdo(
    string $tab_name,
    array $row,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $row );

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $cols = [];
    $values = [];
    $params = [];
    $first = true;
    $id_col = null;
    $id_val = null;

    foreach ( $row as $column => $value ) {

      $this->ensure_safe( $column );

      // 2019-11-05 jj5 - we skip the first column, which is the ID column...
      //
      if ( $first ) {

        $id_col = $column;
        $id_val = $value;

        $first = false;

        continue;

      }

      $cols[] = $column;
      $param = ":$column";
      $values[] = $param;

      if ( is_bool( $value ) ) { $value = $value ? 1 : 0; }

      $params[ $param ] = $value;

    }

    $assignments = [];

    for ( $i = 0; $i < count( $cols ); $i++ ) {

      $assignments[] = "{$cols[ $i ]} = {$values[ $i ]}";

    }

    $sql_assignments = implode( ', ', $assignments );

    $sql =
      "update {$table} set {$sql_assignments} where {$id_col} = :id";

    $params[ ':id' ] = $id_val;

    $result = $pdo->run_update( $sql, $params );

    return $result;

  }

  public function delete(
    string $tab_name,
    array $spec
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->delete_pdo(
      $tab_name,
      $spec,
      $prefix,
      $pdo
    );

  }

  public function delete_pdo(
    string $tab_name,
    array $spec,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $spec );

    // 2020-03-24 jj5 - note that a $spec can indicate a key or an entire
    // row...

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $sql = "
      delete from
        {$table}
      where
    ";

    $query_list = [];
    $params = [];

    foreach ( $spec as $col_name => $value ) {

      $this->ensure_safe( $col_name );

      $query_list[] = "$col_name = :$col_name";
      $params[ ":$col_name" ] = $value;

    }

    $sql .= implode( "\n      and ", $query_list );

    return $pdo->run_delete( $sql, $params );

  }

  public function load(
    string $tab_name,
    array $query
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->load_pdo( $tab_name, $query, $prefix, $pdo );

  }

  public function load_pdo(
    string $tab_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $query_map );

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $sql = "
      select
        *
      from
        {$table}
      where
    ";

    $query_list = [];
    $params = [];

    foreach ( $query_map as $col_name => $value ) {

      $this->ensure_safe( $col_name );

      $query_list[] = "$col_name = :$col_name";
      $params[ ":$col_name" ] = $value;

    }

    $sql .= implode( "\n      and ", $query_list );

    $sql .= " order by 1";

    $result = $pdo->get_row( $sql, $params );

    //var_dump( $sql );
    //var_dump( $params );
    //var_dump( $result );

    return $result;

  }

  // 2022-05-22 jj5 - I'm not sure this was ever a good idea... it's both too general and not
  // general enough.
  //
  /*
  public function query(
    string $tab_name,
    array $query
  ) {

    $this->use_database( $prefix, $pdo );

    return $this->query_pdo( $tab_name, $query, $prefix, $pdo );

  }
  */

  public function query_pdo(
    string $tab_name,
    array $query_map,
    string $prefix,
    $pdo
  ) {

    $this->validate_map( $query_map );

    $table = "{$prefix}{$tab_name}";

    $this->ensure_safe( $table );

    $sql = "
      select
        *
      from
        {$table}
    ";

    if ( count( $query_map ) ) {

      $sql .= "
        where
      ";

    }

    $query_list = [];
    $params = [];

    foreach ( $query_map as $col_name => $value ) {

      $this->ensure_safe( $col_name );

      $query_list[] = "$col_name = :$col_name";
      $params[ ":$col_name" ] = $value;

    }

    $sql .= implode( "\n      and ", $query_list );

    $sql .= " order by 1";

    $result = $pdo->get_table( $sql, $params );

    return $result;

  }

  // 2022-02-20 jj5 - THINK: move this to MudDalRaw..?
  //
  public function log(
    string $tab_name,
    array $row
  ) {

    $this->validate_map( $row );

    if ( ! ( $row[ A_STD_INTERACTION_ID ] ?? null ) ) {

      return $this->log_missing_interaction( $tab_name, $row );

    }

    return $this->insert( $tab_name, $row );

  }

  public function log_missing_interaction( string $tab_name, array $row ) {

    $this->validate_map( $row );

    // 2020-03-23 jj5 - THINK: we could cherry pick data out of the $row
    // data for explicit inclusing in the missing logs...

    $table_name_id = $this->register_any_table_name( $tab_name );
    $log_data_zjson = mud_zjson_encode( $row );

    //var_dump( $table_name_id ); mud_exit();

    $this->log_mud_missing_interaction( $table_name_id, $log_data_zjson );

  }

  public function validate_map( &$map ) {

    foreach ( $map as $col_name => $value ) {

      $this->validate_field( $col_name, $value );

    }
  }

  public function validate_field( $col_name, $value ) {

    return mud_validate( $col_name, $value );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-14 jj5 - protected methods...
  //

  abstract protected function new_database();

  protected function get_duration() {

    return round( microtime( $as_float = true ) - APP_START_MICROTIME, 3 );

  }

  // 2021-03-30 jj5 - this function is a template method for wrapping a transaction around the
  // database connection... usually we don't use transactions on $raw etc but it's okay to do so
  // if you're careful to restore the autocommit setting at the end.
  //
  public function wrap( $func ) {

    $this->use_database( $prefix, $database );

    assert( ! $database->is_in_transaction() );
    assert( 1 === $database->get_attr( 'select @@autocommit' ) );

    $last_ex = null;

    try {

      for ( $try = 0; $try < 32; $try++ ) {

        $database->begin();

        try {

          $result = $func( $this, $database, $prefix );

          $database->commit();

          return $result;

        }
        catch ( Throwable $ex ) {

          $last_ex = $ex;

          $database->rollback();

        }
      }

      mud_fail( MUD_ERR_DAL_TRANSACTION_FAILED, null, $last_ex );

    }
    finally {

      //$database->exex( 'set autocommit = 1' );

      assert( ! $database->is_in_transaction() );
      assert( 1 === $database->get_attr( 'select @@autocommit' ) );

    }
  }

  protected function get_sql_select(
    string $tab_name,
    string $col_name,
    array $query_map,
    string $prefix,
    &$params,
    string $operator = 'and'
  ) {

    static $operator_list = [ 'and', 'or' ];

    if ( ! in_array( $operator, $operator_list ) ) {

      mud_fail(
        MUD_ERR_DAL_SQL_OPERATOR_INVALID,
        [
          'operator' => $operator,
        ]
      );

    }

    $this->validate_map( $query_map );

    $this->ensure_safe( $tab_name );

    if ( $col_name !== '*' ) {

      $this->ensure_safe( $col_name );

    }

    $sql = "
      select
        {$col_name}
      from
        {$prefix}{$tab_name}
      where
    ";

    $query_list = [];
    $params = [];

    foreach ( $query_map as $col_name => $value ) {

      $this->ensure_safe( $col_name );

      $query_list[] = "$col_name = :$col_name";
      $params[ ":$col_name" ] = $value;

    }

    $sql .= implode( "\n      $operator ", $query_list );

    $sql .= " order by 1";

    return $sql;

  }

  protected function get_lookup_enum(
    string $tab_name,
    string $col_name_enum,
    array $query_col_list,
    $query
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_enum );

    if ( $this->get_cache()->read( $tab_name, $query, $cache_key, $result ) ) {

      return $result;

    }

    $this->use_database( $prefix, $pdo );

    $sql = "
      select
        {$col_name_enum}
      from
        {$prefix}{$tab_name}
      where
    ";

    $query_list = [];
    $params = [];

    foreach ( $query_col_list as $col_name ) {

      // 2020-04-17 jj5 - we don't enforce validation for queries any more...
      //$this->validate_field( $col_name, $query );

      $query_list[] = "$col_name = :$col_name";
      $params[ ":$col_name" ] = $query;

    }

    $sql .= implode( "\n      or ", $query_list );

    $sql .= " order by 1";

    $key = $pdo->get_field( $sql, $params, $col_name_enum );

    if ( $key === null ) { return null; }

    $key = intval( $key );

    $this->get_cache()->write( $tab_name, $cache_key, $key );

    return $key;

  }

  protected function get_lookup_detail(
    string $tab_name,
    string $col_name_detail,
    string $col_name_enum,
    $enum
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_detail );
    $this->ensure_safe( $col_name_enum );

    $cache_name = "$tab_name-$col_name_detail";

    if ( $this->get_cache()->read( $cache_name, $enum, $cache_key, $result ) ) {

      return $result;

    }

    $this->use_database( $prefix, $pdo );

    $this->validate_field( $col_name_enum, $enum );

    $sql = "
      select
        {$col_name_detail}
      from
        {$prefix}{$tab_name}
      where
        {$col_name_enum} = :enum
      order by 1
    ";

    $params = [ ':enum' => $enum ];

    $result = $pdo->get_field( $sql, $params, $col_name_detail );

    if ( $result === null ) { return null; }

    $result = mud_get_db_value( $col_name_detail, $result );

    $this->get_cache()->write( $cache_name, $cache_key, $result );

    return $result;

  }

  protected function get_particle_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_value,
    $value,
    &$cache_key = null
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_id );
    $this->ensure_safe( $col_name_value );

    if ( $this->get_cache()->read( $tab_name, $value, $cache_key, $result ) ) {

      return $result;

    }

    $this->validate_field( $col_name_value, $value );

    $this->use_database( $prefix, $pdo );

    $sql = "
      select
        {$col_name_id}
      from
        {$prefix}{$tab_name}
      where
        {$col_name_value} = :value
      order by 1
    ";

    $params = [ ':value' => $value ];

    $key = $pdo->get_field( $sql, $params, $col_name_id );

    if ( $key === null ) { return null; }

    $key = intval( $key );

    $this->get_cache()->write( $tab_name, $cache_key, $key );

    return $key;

  }

  protected function register_particle(
    string $tab_name,
    string $col_name_id,
    string $col_name_value,
    string $col_name_created_in,
    $value
  ) {

    $key = $this->get_particle_id(
      $tab_name,
      $col_name_id,
      $col_name_value,
      $value,
      $cache_key
    );

    if ( $key ) { return $key; }

    $this->validate_field( $col_name_value, $value );
    $this->validate_field( $col_name_created_in, $this->get_interaction_id() );

    try {

      $this->ensure_safe( $tab_name );
      $this->ensure_safe( $col_name_id );
      $this->ensure_safe( $col_name_value );

      $this->use_database( $prefix, $pdo );

      $sql = "
        insert into {$prefix}{$tab_name} (
          {$col_name_value},
          {$col_name_created_in}
        )
        values (
          :value,
          :interaction_id
        )
      ";

      $params = [
        ':value' => $value,
        ':interaction_id' => $this->get_interaction_id(),
      ];

      $key = $pdo->run_insert_id( $sql, $params );

      if ( $key === null ) { return null; }

      return $this->get_cache()->write( $tab_name, $cache_key, $key );

    }
    catch ( MudException $ex ) {

      if ( $ex->getCode() === MUD_ERR_DAL_ENTRY_IS_DUPLICATE ) {

        // 2019-07-09 jj5 - we lost a race, that's okay...

      }
      else {

        throw $ex;

      }
    }

    return $this->get_particle_id(
      $tab_name,
      $col_name_id,
      $col_name_value,
      $value
    );

  }

  protected function get_name_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_value,
    string $value,
    &$cache_key = null
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_id );
    $this->ensure_safe( $col_name_value );

    if ( $this->get_cache()->read( $tab_name, $value, $cache_key, $result ) ) {

      return $result;

    }

    $this->validate_field( $col_name_value, $value );

    $this->use_database( $prefix, $pdo );

    $sql = "
      select
        {$col_name_id}
      from
        {$prefix}{$tab_name}
      where
        {$col_name_value} = :value
      order by 1
    ";

    $params = [ ':value' => $value ];

    $key = $pdo->get_field( $sql, $params, $col_name_id );

    if ( $key === null ) { return null; }

    $key = intval( $key );

    $this->get_cache()->write( $tab_name, $cache_key, $key );

    return $key;

  }

  protected function register_name(
    string $tab_name,
    string $col_name_id,
    string $col_name_value,
    string $col_name_ci,
    string $col_name_created_in,
    string $value
  ) {

    $key = $this->get_name_id(
      $tab_name,
      $col_name_id,
      $col_name_value,
      $value,
      $cache_key
    );

    if ( $key ) { return $key; }

    $this->validate_field( $col_name_value, $value );
    $this->validate_field( $col_name_ci, $value );
    $this->validate_field( $col_name_created_in, $this->get_interaction_id() );

    try {

      $this->ensure_safe( $tab_name );
      $this->ensure_safe( $col_name_id );
      $this->ensure_safe( $col_name_value );
      $this->ensure_safe( $col_name_ci );

      $this->use_database( $prefix, $pdo );

      $sql = "
        insert into {$prefix}{$tab_name} (
          {$col_name_value},
          {$col_name_ci},
          {$col_name_created_in}
        )
        values (
          :value,
          :value_ci,
          :interaction_id
        )
      ";

      $params = [
        ':value' => $value,
        ':value_ci' => $value,
        ':interaction_id' => $this->get_interaction_id(),
      ];

      $key = $pdo->run_insert_id( $sql, $params );

      if ( $key === null ) { return null; }

      return $this->get_cache()->write( $tab_name, $cache_key, $key );

    }
    catch ( MudException $ex ) {

      if ( $ex->getCode() === MUD_ERR_DAL_ENTRY_IS_DUPLICATE ) {

        // 2019-07-09 jj5 - we lost a race, that's okay...

      }
      else {

        throw $ex;

      }
    }

    return $this->get_name_id(
      $tab_name,
      $col_name_id,
      $col_name_value,
      $value
    );

  }

  protected function get_string_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $value,
    &$hash_bin = null,
    &$cache_key = null
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_id );
    $this->ensure_safe( $col_name_hash );

    $hash_bin = mud_hash_bin( $value );

    if ( $this->get_cache()->read( $tab_name, $hash_bin, $cache_key, $result ) ) {

      return $result;

    }

    /*
    if ( $tab_name === T_TEXTDATA_URL_PATH ) {

      var_dump( $hash_bin ); mud_exit();

    }
    */

    //if ( ! $hash_bin ) { var_dump( $value ); mud_exit(); }

    $this->validate_field( $col_name_hash, $hash_bin );

    $this->use_database( $prefix, $pdo );

    $sql = "
      select
        {$col_name_id}
      from
        {$prefix}{$tab_name}
      where
        {$col_name_hash} = :hash
      order by 1
    ";

    $params = [ ':hash' => $hash_bin ];

    $key = $pdo->get_field( $sql, $params, $col_name_id );

    if ( $key === null ) { return null; }

    $key = intval( $key );

    $this->get_cache()->write( $tab_name, $cache_key, $key );

    return $key;

  }

  protected function register_string(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $col_name_created_in,
    string $value
  ) {

    $key = $this->get_string_id(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $value,
      $hash_bin,
      $cache_key
    );

    if ( $key ) { return $key; }

    $this->validate_field( $col_name_hash, $hash_bin );
    $this->validate_field( $col_name_value, $value );
    $this->validate_field( $col_name_created_in, $this->get_interaction_id() );

    try {

      $this->ensure_safe( $tab_name );
      $this->ensure_safe( $col_name_id );
      $this->ensure_safe( $col_name_hash );
      $this->ensure_safe( $col_name_value );

      $this->use_database( $prefix, $pdo );

      $sql = "
        insert into {$prefix}{$tab_name} (
          {$col_name_hash},
          {$col_name_value},
          {$col_name_created_in}
        )
        values (
          :hash,
          :value,
          :interaction_id
        )
      ";

      $params = [
        ':hash' => $hash_bin,
        ':value' => $value,
        ':interaction_id' => $this->get_interaction_id(),
      ];

      $key = $pdo->run_insert_id( $sql, $params );

      if ( $key === null ) { return null; }

      return $this->get_cache()->write( $tab_name, $cache_key, $key );

    }
    catch ( MudException $ex ) {

      if ( $ex->getCode() === MUD_ERR_DAL_ENTRY_IS_DUPLICATE ) {

        // 2019-07-09 jj5 - we lost a race, that's okay...

      }
      else {

        throw $ex;

      }
    }

    return $this->get_string_id(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $value
    );

  }

  protected function get_zjson_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $value,
    &$hash_bin = null,
    &$cache_key = null
  ) {

    return $this->get_string_id(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $value,
      $hash_bin,
      $cache_key
    );

  }

  protected function register_zjson(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $col_name_created_in,
    string $value
  ) {

    return $this->register_string(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $col_name_value,
      $col_name_created_in,
      $value
    );

  }

  protected function get_zblob_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $value,
    &$hash_bin = null,
    &$cache_key = null
  ) {

    return $this->get_string_id(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $col_name_value,
      $value,
      $hash_bin,
      $cache_key
    );

  }

  protected function register_zblob(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $col_name_created_in,
    string $value
  ) {

    return $this->register_string(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $col_name_value,
      $col_name_created_in,
      $value
    );

  }

  protected function get_ztext_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $value,
    &$hash_bin = null,
    &$cache_key = null
  ) {

    return $this->get_string_id(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $col_name_value,
      $value,
      $hash_bin,
      $cache_key
    );

  }

  protected function register_ztext(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash,
    string $col_name_value,
    string $col_name_created_in,
    string $value
  ) {

    return $this->register_string(
      $tab_name,
      $col_name_id,
      $col_name_hash,
      $col_name_value,
      $col_name_created_in,
      $value
    );

  }

  protected function get_upload_id(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash_bin,
    string $hash_bin,
    &$cache_key = null
  ) {

    $this->ensure_safe( $tab_name );
    $this->ensure_safe( $col_name_id );
    $this->ensure_safe( $col_name_hash_bin );

    if ( $this->get_cache()->read( $tab_name, $hash_bin, $cache_key, $result ) ) {

      return $result;

    }

    $this->validate_field( $col_name_hash_bin, $hash_bin );

    $this->use_database( $prefix, $pdo );

    $sql = "
      select
        {$col_name_id}
      from
        {$prefix}{$tab_name}
      where
        {$col_name_hash_bin} = :hash
      order by 1
    ";

    $params = [ ':hash' => $hash_bin ];

    $key = $pdo->get_field( $sql, $params, $col_name_id );

    if ( $key === null ) { return null; }

    $key = intval( $key );

    $this->get_cache()->write( $tab_name, $cache_key, $key );

    return $key;

  }

  protected function register_upload(
    string $tab_name,
    string $col_name_id,
    string $col_name_hash_bin,
    string $col_name_file_name_id,
    string $col_name_file_type_enum,
    string $col_name_created_in,
    string $hash_bin,
    int $file_name_id,
    int $file_type_enum
  ) {

    $key = $this->get_upload_id(
      $tab_name,
      $col_name_id,
      $col_name_hash_bin,
      $hash_bin,
      $cache_key
    );

    if ( $key ) { return $key; }

    $this->validate_field( $col_name_hash_bin, $hash_bin );
    $this->validate_field( $col_name_file_name_id, $file_name_id );
    $this->validate_field( $col_name_file_type_enum, $file_type_enum );
    $this->validate_field( $col_name_created_in, $this->get_interaction_id() );

    try {

      $this->ensure_safe( $tab_name );
      $this->ensure_safe( $col_name_id );
      $this->ensure_safe( $col_name_hash_bin );
      $this->ensure_safe( $col_name_file_name_id );
      $this->ensure_safe( $col_name_file_type_enum );
      $this->ensure_safe( $col_name_created_in );

      $this->use_database( $prefix, $pdo );

      $sql = "
        insert into {$prefix}{$tab_name} (
          {$col_name_hash_bin},
          {$col_name_file_name_id},
          {$col_name_file_type_enum},
          {$col_name_created_in}
        )
        values (
          :hash_bin,
          :file_name_id,
          :file_type_enum,
          :interaction_id
        )
      ";

      $params = [
        ':hash_bin' => $hash_bin,
        ':file_name_id' => $file_name_id,
        ':file_type_enum' => $file_type_enum,
        ':interaction_id' => $this->get_interaction_id(),
      ];

      $key = $pdo->run_insert_id( $sql, $params );

      if ( $key === null ) { return null; }

      return $this->get_cache()->write( $tab_name, $cache_key, $key );

    }
    catch ( MudException $ex ) {

      if ( $ex->getCode() === MUD_ERR_DAL_ENTRY_IS_DUPLICATE ) {

        // 2019-07-09 jj5 - we lost a race, that's okay...

      }
      else {

        throw $ex;

      }
    }

    return $this->get_upload_id(
      $tab_name,
      $col_name_id,
      $col_name_hash_bin,
      $hash_bin
    );

  }

  protected function use_database( &$prefix = null, &$database = null ) {

    $database = $this->get_database();

    $prefix = $database->get_prefix();

    if ( ! $this->is_trn() ) { return $database; }

    if ( ! $database || $database->get_transaction_count() === 0 ) {

      mud_fail(
        MUD_ERR_DAL_OPEN_TRANSACTION_EXPECTED,
        [
          'transaction_count' => $database->get_transaction_count(),
        ]
      );

    }

    return $database;

  }

  protected function ensure_safe( string $name ) {

    //if ( $name === mud_varname( $name ) ) { return; }

    if ( preg_match( '/^[a-z][a-z0-9_]*$/', $name ) ) { return; }

    mud_fail( MUD_ERR_DAL_NAME_UNSAFE, [ 'name' => $name ] );

  }

  protected function read_id( array $spec, &$id_col, &$id_val ) {

    $id_col = null;
    $id_val = null;

    foreach ( $spec as $col => $val ) {

      $id_col = $col;
      $id_val = $val;

      break;

    }

    if ( ! $id_col ) {

      mud_fail(
        MUD_ERR_DAL_ID_COLUMN_UNREAD,
        [
          'spec' => $spec,
        ]
      );

    }

    $this->validate_field( $id_col, $id_val );

  }

  // 2020-03-24 jj5 - I'm not sure this is really useful or interesting, but
  // it's here now and I might come back to it later...
  //
  protected function report_on( $name, array $indexes = [] ) {

    $this->ensure_safe( $name );

    $this->use_database( $prefix, $pdo );

    $report_table = "{$prefix}report_{$name}";
    $report_view = "{$prefix}view_{$name}";

    if ( $pdo->has_table( $report_table ) ) {

      $pdo->drop_table( $report_table );

    }

    $sql = "
      create table $report_table
      select * from $report_view
    ";

    $pdo->exec( $sql );

    foreach ( $indexes as $sql ) {

      $pdo->exec( $sql );

    }
  }

  /*
  protected function commit_open_transaction() {

    if ( ! $this->pdo_trn ) { return; }

    while ( $this->pdo_trn->get_transaction_count() ) {

      $this->pdo_trn->commit();

    }
  }

  protected function rollback_open_transaction() {

    if ( ! $this->pdo_trn ) { return; }

    $this->pdo_trn->rollback();

  }

  protected function complete() {

    //$this->log_complete();

    $this->pdo = null;

  }
  */

  protected function read_logs() {

    return [
      'raw' => $this->read_pdo_logs( $this->pdo_raw ),
      'emu' => $this->read_pdo_logs( $this->pdo_emu ),
      'trn' => $this->read_pdo_logs( $this->pdo_trn ),
    ];

  }

  protected function read_pdo_logs( $pdo ) {

    if ( $pdo ) {

      return $pdo->get_logs();

    }

    return [
      'access_map' => [],
      'operation_map' => [],
      'counts' => [
        'begin_count' => 0,
        'real_begin_count' => 0,
        'commit_count' => 0,
        'real_commit_count' => 0,
        'rollback_count' => 0,
        'real_rollback_count' => 0,
      ],
    ];

  }
}
