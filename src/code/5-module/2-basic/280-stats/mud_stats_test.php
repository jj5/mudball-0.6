<?php


/////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - include dependencies...
//

require_once __DIR__ . '/../../../../host/dev/test.php';
require_once __DIR__ . '/mud_stats.php';


/////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - declare tests...
//

declare_tests([

  'test small float' => function() {

    $epsilon = 0.0000000000001;

    assert( mud_is_float_equal( $epsilon, $epsilon ) );

    return 0;

  },

  'test invalid input bool' => function() {

    try {

      $stats = mud_get_stats( [ false ] );

      assert( false );

    }
    catch ( MudException $ex ) {

      assert( $ex->getCode() === MUD_ERR_STATS_UNKNOWN_TYPE );

      return 0;

    }

    assert( false );

  },

  'test list null' => function() {

    $stats = mud_get_stats( [ null, null, null ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 3 );
    assert( $stats[ MUD_STATS_COUNT ] === 0 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 0 );
    assert( $stats[ MUD_STATS_MINIMUM ] === null );
    assert( $stats[ MUD_STATS_MAXIMUM ] === null );
    assert( $stats[ MUD_STATS_RANGE ] === null );
    assert( $stats[ MUD_STATS_MEAN_ARITHMETIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [] );
    assert( $stats[ MUD_STATS_MODES ] === [] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 0 );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] === null );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] === null );

    return 0;

  },

  'test list NaN' => function() {

    $stats = mud_get_stats( [ NAN, NAN, NAN ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 3 );
    assert( $stats[ MUD_STATS_COUNT ] === 0 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 0 );
    assert( $stats[ MUD_STATS_MINIMUM ] === null );
    assert( $stats[ MUD_STATS_MAXIMUM ] === null );
    assert( $stats[ MUD_STATS_RANGE ] === null );
    assert( $stats[ MUD_STATS_MEAN_ARITHMETIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [] );
    assert( $stats[ MUD_STATS_MODES ] === [] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 0 );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] === null );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] === null );

    return 0;

  },

  'test list null and NaN' => function() {

    $stats = mud_get_stats( [ NAN, null, NAN ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 3 );
    assert( $stats[ MUD_STATS_COUNT ] === 0 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 0 );
    assert( $stats[ MUD_STATS_MINIMUM ] === null );
    assert( $stats[ MUD_STATS_MAXIMUM ] === null );
    assert( $stats[ MUD_STATS_RANGE ] === null );
    assert( $stats[ MUD_STATS_MEAN_ARITHMETIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [] );
    assert( $stats[ MUD_STATS_MODES ] === [] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 0 );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] === null );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] === null );

    return 0;

  },

  'test int zero' => function() {

    $stats = mud_get_stats( [ 0 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 1 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 0 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 0 );
    assert( $stats[ MUD_STATS_RANGE ] === 0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test int list zero' => function() {

    $stats = mud_get_stats( [ 0, 0, 0 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 0 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 0 );
    assert( $stats[ MUD_STATS_RANGE ] === 0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test int list' => function() {

    $stats = mud_get_stats( [ 1, 2, 3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 2 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.6363636363636 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.8171205928321 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.81649658092773 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1 ) );

    return 0;

  },

  'test int list same' => function() {

    $stats = mud_get_stats( [ 1, 1, 1 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 1 );
    assert( $stats[ MUD_STATS_RANGE ] === 0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 1.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.0 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 1 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test int list negative' => function() {

    $stats = mud_get_stats( [ -3, -2, -1, 0, 1, 2, 3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 7 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 7 );
    assert( $stats[ MUD_STATS_MINIMUM ] === -3 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 6 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ -3, -2, -1, 0, 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 2.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 2.1602468994693 ) );

    return 0;

  },

  'test int list negative descending' => function() {

    $stats = mud_get_stats( [ 3, 2, 1, 0, -1, -2, -3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 7 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 7 );
    assert( $stats[ MUD_STATS_MINIMUM ] === -3 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 6 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ -3, -2, -1, 0, 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 2.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 2.1602468994693 ) );

    return 0;

  },

  'test float zero' => function() {

    $stats = mud_get_stats( [ 0.0 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 1 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 0.0 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 0.0 );
    assert( $stats[ MUD_STATS_RANGE ] === 0.0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test float list zero' => function() {

    $stats = mud_get_stats( [ 0.0, 0.0, 0.0 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 0.0 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 0.0 );
    assert( $stats[ MUD_STATS_RANGE ] === 0.0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test float list' => function() {

    $stats = mud_get_stats( [ 1.1, 2.2, 3.3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1.1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3.3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_RANGE ], 2.2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2.2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.8 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.9988326521154 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2.2 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1.1, 2.2, 3.3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.8981462390205 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1.1 ) );

    return 0;

  },

  'test float list same' => function() {

    $stats = mud_get_stats( [ 1.1, 1.1, 1.1 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 1 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1.1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 1.1 );
    assert( $stats[ MUD_STATS_RANGE ] === 0.0 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 1.1 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.1 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.1 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 1.1 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1.1 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 0.0 ) );

    return 0;

  },

  'test float list negative' => function() {

    $stats = mud_get_stats( [ -3.3, -2.2, -1.1, 0.0, 1.1, 2.2, 3.3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 7 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 7 );
    assert( $stats[ MUD_STATS_MINIMUM ] === -3.3 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3.3 );
    assert( $stats[ MUD_STATS_RANGE ] === 6.6 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ -3.3, -2.2, -1.1, 0.0, 1.1, 2.2, 3.3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 2.2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 2.3762715894162 ) );

    return 0;

  },

  'test float list negative descending' => function() {

    $stats = mud_get_stats( [ 3.3, 2.2, 1.1, 0.0, -1.1, -2.2, -3.3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 7 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 7 );
    assert( $stats[ MUD_STATS_MINIMUM ] === -3.3 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3.3 );
    assert( $stats[ MUD_STATS_RANGE ] === 6.6 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 0.0 ) );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ -3.3, -2.2, -1.1, 0.0, 1.1, 2.2, 3.3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 2.2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 2.3762715894162 ) );

    return 0;

  },

  'test mixed numeric list' => function() {

    $stats = mud_get_stats( [ 3.3, 2, 1.1, 0, -1.1, -2, -3.3 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 7 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 7 );
    assert( $stats[ MUD_STATS_MINIMUM ] === -3.3 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3.3 );
    assert( $stats[ MUD_STATS_RANGE ] === 6.6 );

    // 2022-01-29 jj5 - NOTE: LibreOffice Calc says this should be zero, but we just have a very
    // small value... floating point is weird...
    //
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 1.2688263138573E-16 ) );

    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 0.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ -3.3, -2.0, -1.1, 0.0, 1.1, 2.0, 3.3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 2.1447610589527 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 2.3166067138525 ) );

    return 0;

  },

  'test mixed positive numeric list' => function() {

    $stats = mud_get_stats( [ 3.3, 2, 1.1 ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_FLOAT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1.1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3.3 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_RANGE ], 2.2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2.1333333333333 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.7522123893805 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.9363277681966 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2.0 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1.1, 2.0, 3.3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.9030811456096 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1.1060440015358 ) );

    return 0;

  },

  'test ASCII list' => function() {

    $stats = mud_get_stats( [ 'a', 'ab', 'abc' ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_ASCII );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 2 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.6363636363636 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.8171205928321 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.81649658092773 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1.0 ) );

    return 0;

  },

  'test UTF-8 list' => function() {

    $stats = mud_get_stats( [ '一', '一二', '一二三' ] );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_UTF8 );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 2 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2.0 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.6363636363636 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.8171205928321 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.81649658092773 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1.0 ) );

    return 0;

  },

  'test datetime list' => function() {

    $a = new DateTime;
    $b = new DateTime;
    $c = new DateTime;

    $stats = mud_get_stats( [ $a, $b, $b, $c ], MUD_STATS_TYPE_OBJECT );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_OBJECT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 4 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === $a );
    assert( $stats[ MUD_STATS_MAXIMUM ] === $c );
    assert( $stats[ MUD_STATS_RANGE ] === null );
    assert( $stats[ MUD_STATS_MEAN_ARITHMETIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ $b ] );
    assert( $stats[ MUD_STATS_MODES ] === [ $b ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 2 );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] === null );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] === null );

    return 0;

  },

  'test object list' => function() {

    class TestVal {

      public $val;

      public function __construct( $val ) {

        parent::__construct();

        $this->val = $val;

      }

    }

    $a = new TestVal( 123 );
    $b = new TestVal( 456 );
    $c = new TestVal( 789 );

    $stats = mud_get_stats( [ $a, $b, $b, $c ], MUD_STATS_TYPE_OBJECT );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_OBJECT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 4 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === $a );
    assert( $stats[ MUD_STATS_MAXIMUM ] === $c );
    assert( $stats[ MUD_STATS_RANGE ] === null );
    assert( $stats[ MUD_STATS_MEAN_ARITHMETIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_HARMONIC ] === null );
    assert( $stats[ MUD_STATS_MEAN_GEOMETRIC ] === null );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ $b ] );
    assert( $stats[ MUD_STATS_MODES ] === [ $b ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 2 );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ] === null );
    assert( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ] === null );

    return 0;

  },

  'test array interface' => function() {

    class TestList implements IteratorAggregate {

      private $list = [ 1, 2, 3 ];

      public function getIterator() { return new ArrayIterator( $this->list ); }

    }

    $list = new TestList();

    $stats = mud_get_stats( $list );

    // 2022-01-29 jj5 - var_dump( $stats );

    assert( $stats[ MUD_STATS_TYPE ] === MUD_STATS_TYPE_INT );
    assert( $stats[ MUD_STATS_NULL ] === 0 );
    assert( $stats[ MUD_STATS_COUNT ] === 3 );
    assert( $stats[ MUD_STATS_DISTINCT ] === 3 );
    assert( $stats[ MUD_STATS_MINIMUM ] === 1 );
    assert( $stats[ MUD_STATS_MAXIMUM ] === 3 );
    assert( $stats[ MUD_STATS_RANGE ] === 2 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_ARITHMETIC ], 2 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_HARMONIC ], 1.6363636363636 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_MEAN_GEOMETRIC ], 1.8171205928321 ) );
    assert( $stats[ MUD_STATS_MEDIANS ] === [ 2 ] );
    assert( $stats[ MUD_STATS_MODES ] === [ 1, 2, 3 ] );
    assert( $stats[ MUD_STATS_MODE_FREQUENCY ] === 1 );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_POPULATION ], 0.81649658092773 ) );
    assert( mud_is_float_equal( $stats[ MUD_STATS_STANDARD_DEVIATION_ESTIMATE ], 1 ) );

    return 0;

  },

]);
