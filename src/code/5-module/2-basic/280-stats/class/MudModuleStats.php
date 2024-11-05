<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - class definition...
//

class MudModuleStats extends MudModuleBasic {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleStats|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-01-28 jj5 - public interface...
  //

  public function is_float_equal( float $a, float $b ) {

    static $epsilon = 0.0000000000001;

    return ( abs( $a - $b ) < $epsilon );

  }

  public function identity( $value ) { return $value; }

  public function get_stats( $input, $type = null ) {

    $stats = [

      // 2022-01-29 jj5 - the type of values in the input list... if not specified it is
      // automatically detected.
      //
      MUD_STATS_TYPE                          => null,

      // 2022-01-28 jj5 - number of null or NaN values...
      //
      MUD_STATS_NULL                          => 0,

      //2022-01-28 jj5 - number of non-null non-NaN values...
      //
      MUD_STATS_COUNT                         => 0,

      // 2022-01-29 jj5 - number of distinct non-null non-NaN values...
      //
      MUD_STATS_DISTINCT                      => 0,

      MUD_STATS_MINIMUM                       => null,
      MUD_STATS_MAXIMUM                       => null,
      MUD_STATS_RANGE                         => null,
      MUD_STATS_MEAN_ARITHMETIC               => null,
      MUD_STATS_MEAN_HARMONIC                 => null,
      MUD_STATS_MEAN_GEOMETRIC                => null,
      MUD_STATS_MEDIANS                       => [],
      MUD_STATS_MODES                         => [],
      MUD_STATS_MODE_FREQUENCY                => 0,
      MUD_STATS_STANDARD_DEVIATION_POPULATION => null,
      MUD_STATS_STANDARD_DEVIATION_ESTIMATE   => null,

    ];

    if ( is_array( $input ) ) {

      // 2022-01-29 jj5 - that will do

    }
    else if ( is_object( $input ) && is_a( $input, 'Traversable' ) ) {

      // 2022-01-29 jj5 - that will do

    }
    else {

      mud_fail( MUD_ERR_STATS_INPUT_IS_NOT_TRAVERSABLE );

    }

    if ( $type === null ) {

      if ( $this->is_list_of_int( $input ) ) {

        $type = MUD_STATS_TYPE_INT;

      }
      else if ( $this->is_list_of_float( $input ) ) {

        $type = MUD_STATS_TYPE_FLOAT;

      }
      else if ( $this->is_list_of_ascii( $input ) ) {

        $type = MUD_STATS_TYPE_ASCII;

      }
      else if ( $this->is_list_of_utf8( $input ) ) {

        $type = MUD_STATS_TYPE_UTF8;

      }
      else if ( $this->is_list_of_object( $input ) ) {

        $type = MUD_STATS_TYPE_OBJECT;

      }
      else if ( $this->is_list_of_null( $input ) ) {

        // 2022-01-29 jj5 - if all the value are null the type can be pretty much anything,
        // we say float because there may be NaN values which are technically floats.

        $type = MUD_STATS_TYPE_FLOAT;

      }
      else {

        mud_fail( MUD_ERR_STATS_UNKNOWN_TYPE );

      }
    }

    $stats[ MUD_STATS_TYPE ] = $type;

    $sum_x = 0;
    $sum_x2 = 0;

    $parser = MUD_STATS_PARSER[ $type ];

    // 2022-01-28 jj5 - non-null input
    //
    $data = [];

    if ( $type === MUD_STATS_TYPE_OBJECT ) {

      $distinct = new_php_spl_object_storage();

    }
    else {

      $distinct = [];

    }

    // 2022-01-28 jj5 - we don't calculate geometric and harmonic means if any input <= 0
    //
    $calc_means = $type !== MUD_STATS_TYPE_OBJECT;

    foreach ( $input as $input_value ) {

      $value = $input_value;

      if ( $this->is_null_value( $value ) ) {

        $stats[ MUD_STATS_NULL ]++;

      }
      else {

        $value = $parser( $value );

        if ( count( $data ) === 0 ) {

          $stats[ MUD_STATS_MINIMUM ] = $value;
          $stats[ MUD_STATS_MAXIMUM ] = $value;

        }

        $stats[ MUD_STATS_MINIMUM ] = min( [ $value, $stats[ MUD_STATS_MINIMUM ] ] );
        $stats[ MUD_STATS_MAXIMUM ] = max( [ $value, $stats[ MUD_STATS_MAXIMUM ] ] );

        $data[] = $value;
        $distinct[ $input_value ] = true;

        if ( $type === MUD_STATS_TYPE_OBJECT || $value <= 0 ) { $calc_means = false; }

        if ( $type !== MUD_STATS_TYPE_OBJECT ) {

          $sum_x += $value;
          $sum_x2 += $value * $value;

        }
      }
    }

    $count = count( $data );
    $stats[ MUD_STATS_COUNT ] = $count;
    $stats[ MUD_STATS_DISTINCT ] = count( $distinct );

    if ( $count > 0 ) {

      asort( $data );

      $data = array_values( $data );

      $stats[ MUD_STATS_MEDIANS ] = [ $data[ 0 ] ];

      if ( $type !== MUD_STATS_TYPE_OBJECT ) {

        $stats[ MUD_STATS_RANGE ] = $stats[ MUD_STATS_MAXIMUM ] - $stats[ MUD_STATS_MINIMUM ];

        $stats[ MUD_STATS_MEAN_ARITHMETIC ] = $sum_x / ( $count * 1.0 );

        $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] =
        $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] =
          sqrt(
            ( $count * $sum_x2 ) - ( $sum_x * $sum_x )
          ) /
          ( $count );

        if ( $calc_means ) {

          // 2022-01-28 jj5 - harmonic mean:

          $x = 0.0;

          for ( $i = 0, $il = $count; $i < $il; $i++ ) {

            $x += ( 1.0 / $data[ $i ] );

          }

          $stats[ MUD_STATS_MEAN_HARMONIC ] = $count / $x;

          // 2022-01-28 jj5 - geometric mean:

          $x = 1.0;

          for ( $i = 0, $il = $count; $i < $il; $i++ ) {

            $x *= pow( $data[ $i ], 1.0 / $count );

          }

          $stats[ MUD_STATS_MEAN_GEOMETRIC ] = $x;

        }
      }

      // 2022-01-28 jj5 - mode calculation:

      $x = $data[ 0 ];
      $tally = 1;

      for ( $i = 1, $il = $count; $i < $il; $i++ ) {

        if ( $data[ $i ] === $x ) {

          $tally++;

        }
        else {

          if ( $tally === $stats[ MUD_STATS_MODE_FREQUENCY ] ) {

            $stats[ MUD_STATS_MODES ][] = $x;

          }
          else if( $tally > $stats[ MUD_STATS_MODE_FREQUENCY ] ) {

            $stats[ MUD_STATS_MODES ] = [ $x ];
            $stats[ MUD_STATS_MODE_FREQUENCY ] = $tally;

          }

          $x = $data[ $i ];
          $tally = 1;

        }
      }

      if ( $tally === $stats[ MUD_STATS_MODE_FREQUENCY ] ) {

        $stats[ MUD_STATS_MODES ][] = $x;

      }
      elseif ( $tally > $stats[ MUD_STATS_MODE_FREQUENCY ] ) {

        $stats[ MUD_STATS_MODES ] = [ $x ];
        $stats[ MUD_STATS_MODE_FREQUENCY ] = $tally;

      }
    }

    if ( $count > 1 ) {

      // 2022-01-28 jj5 - median:

      $i = floor( $count / 2 );

      if( ( $count % 2 ) === 1 ) {

        // 2022-01-28 jj5 - if count is odd center point is known

        $stats[ MUD_STATS_MEDIANS ] = [ $data[ $i ] ];

      }
      else {

        // 2022-01-28 jj5 - this doesn't objects...
        //$medians = array_unique( [ $data[ $i - 1 ], $data[ $i ] ] );

        $a = $data[ $i - 1 ];
        $b = $data[ $i ];

        if ( $a === $b ) {

          $medians = [ $a ];

        }
        else {

          $medians = [ $a, $b ];

        }

        // 2022-01-28 jj5 - if count is even interpolate to get a "center" point

        $stats[ MUD_STATS_MEDIANS ] = $medians;

      }

      if ( $type !== MUD_STATS_TYPE_OBJECT ) {

        // 2022-01-28 jj5 - estimated standard deviation is only valid when count > 1 to avoid
        // divide by zero.

        $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] =
          sqrt(
            (
              ( $count * $sum_x2 ) - ( $sum_x * $sum_x )
            ) /
            ( $count * ( $count - 1 ))
          );

      }
    }

    return $stats;

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-01-28 jj5 - protected methods...
  //

  protected function is_list_of_int( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $value === null ) { continue; }

      if ( ! is_numeric( $value ) ) { return false; }

      if ( is_float( $value ) ) { return false; }

      if ( strpos( $value, '.' ) !== false ) { return false; }

      $count++;

    }

    return $count !== 0;

  }

  protected function is_list_of_float( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $value === null ) { continue; }

      if ( ! is_numeric( $value ) ) { return false; }

      $count++;

    }

    return $count !== 0;

  }

  protected function is_list_of_ascii( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $value === null ) { continue; }

      if ( ! is_string( $value ) ) { return false; }

      if ( ! mud_is_ascii( $value ) ) { return false; }

      $count++;

    }

    return $count !== 0;

  }

  protected function is_list_of_utf8( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $value === null ) { continue; }

      if ( ! is_string( $value ) ) { return false; }

      if ( ! mud_is_utf8( $value ) ) { return false; }

      $count++;

    }

    return $count !== 0;

  }

  protected function is_list_of_object( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $value === null ) { continue; }

      if ( ! is_object( $value ) ) { return false; }

      $count++;

    }

    return $count !== 0;

  }

  protected function is_list_of_null( $array ) {

    $count = 0;

    foreach ( $array as $value ) {

      if ( $this->is_null_value( $value ) ) {

        $count++;

      }
      else {

        return false;

      }
    }

    return $count !== 0;

  }

  protected function is_null_value( $value ) {

    return ( $value === null || ( is_float( $value ) && is_nan( $value ) ) );

  }
}
