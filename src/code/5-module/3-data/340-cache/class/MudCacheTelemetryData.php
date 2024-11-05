<?php

class MudCacheTelemetryData extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - private pre-calculated feilds...
  //

  private $duration;
  private $duration_formatted;
  private $row_count;
  private $row_count_formatted;
  private $serialization_type_enum;
  private $serialization_type_code;

  private $op_count;
  private $op_count_formatted;
  private $op_rate;
  private $op_rate_formatted;
  private $op_time;
  private $op_time_formatted;

  private $read_count;
  private $read_count_formatted;
  private $read_rate;
  private $read_rate_formatted;
  private $read_time;
  private $read_time_formatted;

  private $write_count;
  private $write_count_formatted;
  private $write_rate;
  private $write_rate_formatted;
  private $write_time;
  private $write_time_formatted;

  private $hit_count;
  private $hit_count_formatted;
  private $hit_rate;
  private $hit_rate_formatted;
  private $hit_ratio;
  private $hit_ratio_formatted;

  private $miss_count;
  private $miss_count_formatted;
  private $miss_rate;
  private $miss_rate_formatted;
  private $miss_ratio;
  private $miss_ratio_formatted;

  private $write_race_lost_count;
  private $write_race_lost_count_formatted;
  private $new_table_count;
  private $new_table_count_formatted;

  private $error_count;
  private $error_count_formatted;
  private $contention_count;
  private $contention_count_formatted;
  private $reconnect_count;
  private $reconnect_count_formatted;
  private $reset_count;
  private $reset_count_formatted;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - constructor...
  //

  public function __construct(
    $duration,
    $row_count,
    $serialization_type_enum,
    $op_count,
    $op_time,
    $read_count,
    $read_time,
    $write_count,
    $write_time,
    $hit_count,
    $miss_count,
    $write_race_lost_count,
    $new_table_count,
    $error_count,
    $contention_count,
    $reconnect_count,
    $reset_count,
  ) {

    parent::__construct();

    $this->duration = round( $duration, 2 );
    $this->duration_formatted = number_format( $this->duration, 2 );

    $this->row_count = intval( $row_count );
    $this->row_count_formatted = number_format( $this->row_count );

    $this->serialization_type_enum = $serialization_type_enum;
    $this->serialization_type_code = MudSerializationType::GetCode( $serialization_type_enum );


    $this->op_count = intval( $op_count );
    $this->op_count_formatted = number_format( $this->op_count );

    $this->op_rate = $duration ? round( $op_count / $duration ) : null;
    $this->op_rate_formatted = number_format( $this->op_rate );

    $this->op_time = round( $op_time, 2 );
    $this->op_time_formatted = number_format( $this->op_time, 2 );


    $this->read_count = intval( $read_count );
    $this->read_count_formatted = number_format( $this->read_count );

    $this->read_rate = $duration ? round( $read_count / $duration ) : null;
    $this->read_rate_formatted = number_format( $this->read_rate );

    $this->read_time = round( $read_time, 2 );
    $this->read_time_formatted = number_format( $this->read_time, 2 );


    $this->write_count = intval( $write_count );
    $this->write_count_formatted = number_format( $this->write_count );

    $this->write_rate = $duration ? round( $write_count / $duration ) : null;
    $this->write_rate_formatted = number_format( $this->write_rate );

    $this->write_time = round( $write_time, 2 );
    $this->write_time_formatted = number_format( $this->write_time, 2 );


    $this->hit_count = intval( $hit_count );
    $this->hit_count_formatted = number_format( $this->hit_count );

    $this->hit_rate = $duration ? round( $hit_count / $duration ) : null;
    $this->hit_rate_formatted = number_format( $this->hit_rate );

    $this->hit_ratio = $read_count ? round( $hit_count / $read_count, 2 ) : null;
    $this->hit_ratio_formatted = number_format( $this->hit_ratio, 2 );


    $this->miss_count = intval( $miss_count );
    $this->miss_count_formatted = number_format( $this->miss_count );

    $this->miss_rate = $duration ? round( $miss_count / $duration ) : null;
    $this->miss_rate_formatted = number_format( $this->miss_rate );

    $this->miss_ratio = $read_count ? round( $miss_count / $read_count, 2 ) : null;
    $this->miss_ratio_formatted = number_format( $this->miss_ratio, 2 );


    $this->write_race_lost_count = intval( $write_race_lost_count );
    $this->write_race_lost_count_formatted = number_format( $this->write_race_lost_count );

    $this->new_table_count = intval( $new_table_count );
    $this->new_table_count_formatted = number_format( $this->new_table_count );


    $this->error_count = intval( $error_count );
    $this->error_count_formatted = number_format( $this->error_count );

    $this->contention_count = intval( $contention_count );
    $this->contention_count_formatted = number_format( $this->contention_count );

    $this->reconnect_count = intval( $reconnect_count );
    $this->reconnect_count_formatted = number_format( $this->reconnect_count );

    $this->reset_count = intval( $reset_count );
    $this->reset_count_formatted = number_format( $this->reset_count );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - magic methods...
  //

  public function __toString() { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-11 jj5 - public interface...
  //


  public function get_duration() { return $this->duration; }
  public function format_duration() { return $this->duration_formatted; }

  public function get_row_count() { return $this->row_count; }
  public function format_row_count() { return $this->row_count_formatted; }


  public function get_op_count() { return $this->op_count; }
  public function format_op_count() { return $this->op_count_formatted; }

  public function get_op_rate() { return $this->op_rate; }
  public function format_op_rate() { return $this->op_rate_formatted; }

  public function get_op_time() { return $this->op_time; }
  public function format_op_time() { return $this->op_time_formatted; }


  public function get_read_count() { return $this->read_count; }
  public function format_read_count() { return $this->read_count_formatted; }

  public function get_read_rate() { return $this->read_rate; }
  public function format_read_rate() { return $this->read_rate_formatted; }

  public function get_read_time() { return $this->read_time; }
  public function format_read_time() { return $this->read_time_formatted; }


  public function get_write_count() { return $this->write_count; }
  public function format_write_count() { return $this->write_count_formatted; }

  public function get_write_rate() { return $this->write_rate; }
  public function format_write_rate() { return $this->write_rate_formatted; }

  public function get_write_time() { return $this->write_time; }
  public function format_write_time() { return $this->write_time_formatted; }


  public function get_hit_count() { return $this->hit_count; }
  public function format_hit_count() { return $this->hit_count_formatted; }

  public function get_hit_rate() { return $this->hit_rate; }
  public function format_hit_rate() { return $this->hit_rate_formatted; }

  public function get_hit_ratio() { return $this->hit_ratio; }
  public function format_hit_ratio() { return $this->hit_ratio_formatted; }


  public function get_miss_count() { return $this->miss_count; }
  public function format_miss_count() { return $this->miss_count_formatted; }

  public function get_miss_rate() { return $this->miss_rate; }
  public function format_miss_rate() { return $this->miss_rate_formatted; }

  public function get_miss_ratio() { return $this->miss_ratio; }
  public function format_miss_ratio() { return $this->miss_ratio_formatted; }


  public function get_write_race_lost_count() { return $this->write_race_lost_count; }
  public function format_write_race_lost_count() { return $this->write_race_lost_count_formatted; }

  public function get_new_table_count() { return $this->new_table_count; }
  public function format_new_table_count() { return $this->new_table_count_formatted; }


  public function get_error_count() { return $this->error_count; }
  public function format_error_count() { return $this->error_count_formatted; }

  public function get_contention_count() { return $this->contention_count; }
  public function format_contention_count() { return $this->contention_count_formatted; }

  public function get_reconnect_count() { return $this->reconnect_count; }
  public function format_reconnect_count() { return $this->reconnect_count_formatted; }

  public function get_reset_count() { return $this->reset_count; }
  public function format_reset_count() { return $this->reset_count_formatted; }


  public function to_string() {

    return "
      duration..........: {$this->duration_formatted} sec
      row count.........: {$this->row_count_formatted}
      serialization.....: {$this->serialization_type_code}

      op count..........: {$this->op_count_formatted}
      op rate...........: {$this->op_rate_formatted} / sec
      op time...........: {$this->op_time_formatted} sec

      read count........: {$this->read_count_formatted}
      read rate.........: {$this->read_rate_formatted} / sec
      read time.........: {$this->read_time_formatted} sec

      write count.......: {$this->write_count_formatted}
      write rate........: {$this->write_rate_formatted} / sec
      write time........: {$this->write_time_formatted} sec

      hit count.........: {$this->hit_count_formatted}
      hit rate..........: {$this->hit_rate_formatted} / sec
      hit ratio.........: {$this->hit_ratio_formatted}

      miss count........: {$this->miss_count_formatted}
      miss rate.........: {$this->miss_rate_formatted} / sec
      miss ratio........: {$this->miss_ratio_formatted}

      write race lost...: {$this->write_race_lost_count_formatted}
      new table count...: {$this->new_table_count_formatted}

      error count.......: {$this->error_count_formatted}
      contention count..: {$this->contention_count_formatted}
      reconnect count...: {$this->reconnect_count_formatted}
      reset count.......: {$this->reset_count_formatted}\n";

  }
}
