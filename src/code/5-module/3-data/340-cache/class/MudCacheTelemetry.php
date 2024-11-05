<?php

class MudCacheTelemetry extends MudGadget {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - private fields...
  //

  // 2021-04-11 jj5 - the $name is the name of the cache this telemetry is for, e.g. 'dal'...
  //
  private $name;

  // 2021-04-11 jj5 - the $container is the scope this cache is for. Each cache container gets its
  // own database table in the cache...
  //
  private $container;

  // 2021-04-11 jj5 - the $op_count is the number of read or write operations we have conducted...
  //
  private $op_count = 0;

  // 2021-04-11 jj5 - the $read_count is the number of times we attempted to read the cache. A
  // cache read can result in either a cache miss or a cache hit...
  //
  private $read_count = 0;

  // 2021-04-10 jj5 - NOTE: the $write_count is the number of times we added a new item into the
  // cache... the $miss_count and the $write_count should generally always be the same because it
  // we don't find an item in the cache (a miss) we add the item into the cache (a write)...
  //
  private $write_count = 0;

  // 2021-04-11 jj5 - the number of times we found an item when we looked for it...
  //
  private $hit_count = 0;

  // 2021-04-10 jj5 - the $miss_count is the number of times we looked in the cache but didn't
  // find what we were looking for...
  //
  private $miss_count = 0;

  // 2021-04-11 jj5 - the $write_race_lost_count is the number of times we went to insert a new
  // item into the cache but got an integrity constraint violation because, we assume, some other
  // process inserted the same value before us...
  //
  private $write_race_lost_count = 0;

  // 2021-04-10 jj5 - the $new_table_count is the number of times we created a new table for a
  // previously unseen container...
  //
  private $new_table_count = 0;

  // 2021-04-10 jj5 - the $error_count is the number of times we encountered a recoverable error...
  // Recoverable errors are 'contention', 'reconnect', and 'reset', see below for details.
  //
  private $error_count = 0;

  // 2021-04-10 jj5 - the $contention_count is the number of times we had to retry our transaction
  // because the database was in use (and locked) when we tried to access it...
  //
  private $contention_count = 0;

  // 2021-04-11 jj5 - the $reconnect_count is the number of times we received an exception that
  // caused us to reconnect...
  //
  private $reconnect_count = 0;

  // 2021-04-11 jj5 - the $reset_count is the number of times we received an exception that
  // caused us to delete the whole SQLite database due to corruption...
  //
  private $reset_count = 0;

  // 2021-04-11 jj5 - the $duration is the time from when we created the telemetry object
  // until we call complete()...
  //
  private $duration = null;

  // 2021-04-11 jj5 - we record the $start_time so we can calculate the $duration...
  //
  private $start_time;

  // 2021-04-11 jj5 - this is the number of rows in the table for this container...
  //
  private $row_count = null;

  // 2021-04-11 jj5 - this indicates the serialization type that was used for this cache
  // container...
  //
  private $serialization_type_enum = null;

  // 2021-04-11 jj5 - when we complete we store our final telemetry data here for reporting...
  //
  private $telemetry_data = null;

  // 2021-04-11 jj5 - we use $start_time_read and $start_time_write so we can calculate how much
  // time we spend in each type of process...
  //
  private $start_time_read = null;
  private $start_time_write = null;

  // 2021-04-11 jj5 - we record read/write/total time... this is the sum of all time spent
  // handling the particular operations (read, write, or both).
  //
  private $op_time = 0.0;
  private $read_time = 0.0;
  private $write_time = 0.0;


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - constructor...
  //

  public function __construct( string $name, string $container, int $serialization_type_enum ) {

    parent::__construct();

    $this->start_time = $this->get_microtime_now();

    $this->name = $name;
    $this->container = $container;

    $this->serialization_type_enum = $serialization_type_enum;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public methods...
  //

  public function get_name() { return $this->name; }
  public function get_container() { return $this->container; }

  public function get_duration() { return $this->duration; }
  public function get_row_count() { return $this->row_count; }

  public function get_op_count() { return $this->op_count; }
  public function get_op_time() { return $this->op_time; }

  public function get_read_count() { return $this->read_count; }
  public function get_read_time() { return $this->read_time; }

  public function get_write_count() { return $this->write_count; }
  public function get_write_time() { return $this->write_time; }

  public function get_hit_count() { return $this->hit_count; }

  public function get_miss_count() { return $this->miss_count; }

  public function get_write_race_lost_count() { return $this->write_race_lost_count; }
  public function get_new_table_count() { return $this->new_table_count; }

  public function get_error_count() { return $this->error_count; }
  public function get_contention_count() { return $this->contention_count; }
  public function get_reconnect_count() { return $this->reconnect_count; }
  public function get_reset_count() { return $this->reset_count;  }

  public function get_telemetry_data() { return $this->telemetry_data; }

  public function read_init() {

    assert( $this->start_time_read === null );

    $this->start_time_read = $this->get_microtime_now();

  }

  public function write_init() {

    assert( $this->start_time_write === null );

    $this->start_time_write = $this->get_microtime_now();

  }

  public function increment_hit_count() {

    $this->op_count++;
    $this->read_count++;
    $this->hit_count++;

    $this->read_done();

  }

  public function increment_miss_count() {

    $this->op_count++;
    $this->read_count++;
    $this->miss_count++;

    $this->read_done();

  }

  public function increment_write_count() {

    $this->op_count++;
    $this->write_count++;

    $this->write_done();

  }

  public function increment_write_race_lost_count() {

    $this->write_race_lost_count++;

    $this->write_done();

  }

  public function increment_new_table_count() {

    $this->new_table_count++;

  }

  public function increment_contention_count() {

    $this->error_count++;
    $this->contention_count++;

  }

  public function increment_reconnect_count() {

    $this->error_count++;
    $this->reconnect_count++;

  }

  public function increment_reset_count() {

    $this->error_count++;
    $this->reset_count++;

  }

  public function complete( $row_count ) {

    assert( $this->duration === null );
    assert( $this->row_count === null );
    assert( $this->telemetry_data === null );

    $this->duration = $this->get_microtime_now() - $this->start_time;

    $this->row_count = $row_count;

    $this->telemetry_data = new_mud_cache_telemetry_data(
      $this->duration,
      $this->row_count,
      $this->serialization_type_enum,
      $this->op_count,
      $this->op_time,
      $this->read_count,
      $this->read_time,
      $this->write_count,
      $this->write_time,
      $this->hit_count,
      $this->miss_count,
      $this->write_race_lost_count,
      $this->new_table_count,
      $this->error_count,
      $this->contention_count,
      $this->reconnect_count,
      $this->reset_count
    );

  }

  public function report() {

    $container = $this->container;

    $pid = getmypid();

    $telemetry = $this->get_telemetry_data();

    echo "{$container}:\n\n      pid...............: {$pid}\n{$telemetry}\n";

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - protected methods...
  //

  protected function read_done() {

    assert( $this->start_time_read );

    $duration = $this->get_microtime_now() - $this->start_time_read;

    $this->op_time += $duration;
    $this->read_time += $duration;

    $this->start_time_read = null;

  }

  protected function write_done() {

    assert( $this->start_time_write );

    $duration = $this->get_microtime_now() - $this->start_time_write;

    $this->op_time += $duration;
    $this->write_time += $duration;

    $this->start_time_write = null;

  }
}
