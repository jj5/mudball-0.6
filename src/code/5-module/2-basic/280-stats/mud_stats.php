<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - include dependencies...
//

require_once __DIR__ . '/../275-settings/mud_settings.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - module constants...
//

define( 'MUD_STATS_TYPE',                           'type'        );
define( 'MUD_STATS_NULL',                           'null'        );
define( 'MUD_STATS_COUNT',                          'count'       );
define( 'MUD_STATS_DISTINCT',                       'distinct'    );
define( 'MUD_STATS_MINIMUM',                        'min'         );
define( 'MUD_STATS_MAXIMUM',                        'max'         );
define( 'MUD_STATS_RANGE',                          'range'       );
define( 'MUD_STATS_MEAN_ARITHMETIC',                'a_mean'      );
define( 'MUD_STATS_MEAN_HARMONIC',                  'h_mean'      );
define( 'MUD_STATS_MEAN_GEOMETRIC',                 'g_mean'      );
define( 'MUD_STATS_MEDIANS',                        'medians'     );
define( 'MUD_STATS_MODES',                          'modes'       );
define( 'MUD_STATS_MODE_FREQUENCY',                 'mode_freq'   );
define( 'MUD_STATS_STANDARD_DEVIATION_POPULATION',  'std_dev_pop' );
define( 'MUD_STATS_STANDARD_DEVIATION_ESTIMATE',    'std_dev_est' );

define(
  'MUD_STATS_DESCRIPTION',
  [
    MUD_STATS_TYPE                          => 'type',
    MUD_STATS_NULL                          => 'null count',
    MUD_STATS_COUNT                         => 'non-null count',
    MUD_STATS_DISTINCT                      => 'distinct non-null count',
    MUD_STATS_MINIMUM                       => 'minimum value',
    MUD_STATS_MAXIMUM                       => 'maximum value',
    MUD_STATS_RANGE                         => 'value range',
    MUD_STATS_MEAN_ARITHMETIC               => 'arithmetic mean',
    MUD_STATS_MEAN_HARMONIC                 => 'harmonic mean',
    MUD_STATS_MEAN_GEOMETRIC                => 'geometric mean',
    MUD_STATS_MEDIANS                       => 'list of one or two medians',
    MUD_STATS_MODES                         => 'list of one or more modes',
    MUD_STATS_MODE_FREQUENCY                => 'number of times modes occur',
    MUD_STATS_STANDARD_DEVIATION_POPULATION => 'standard deviation of population',
    MUD_STATS_STANDARD_DEVIATION_ESTIMATE   => 'standard deviation estimate',
  ]
);

define( 'MUD_STATS_TYPE_INT',     'int'     );
define( 'MUD_STATS_TYPE_FLOAT',   'float'   );
define( 'MUD_STATS_TYPE_ASCII',   'ascii'   );
define( 'MUD_STATS_TYPE_UTF8',    'unicode' );
define( 'MUD_STATS_TYPE_OBJECT',  'object'  );

define(
  'MUD_STATS_PARSER',
  [
    MUD_STATS_TYPE_INT    => 'intval',
    MUD_STATS_TYPE_FLOAT  => 'floatval',
    MUD_STATS_TYPE_ASCII  => 'strlen',
    MUD_STATS_TYPE_UTF8   => 'mud_utf8_strlen',
    MUD_STATS_TYPE_OBJECT => 'mud_identity',
  ]
);


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-29 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_STATS_INPUT_IS_NOT_TRAVERSABLE', 'input is not traversable.' );
mud_define_error( 'MUD_ERR_STATS_UNKNOWN_TYPE', 'unknown type.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleStats.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-01-28 jj5 - functional interface...
//

// 2022-01-28 jj5 - THINK: should we have a float module..?
//
function mud_is_float_equal( $a, $b ) {

  return mud_module_stats()->is_float_equal( $a, $b );

}

function mud_identity( $value ) {

  return mud_module_stats()->identity( $value );

}

function mud_get_stats( $input, $type = null ) {

  return mud_module_stats()->get_stats( $input, $type );

}


/////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_stats() : MudModuleStats {

  return mud_locator()->get_module( MudModuleStats::class );

}
