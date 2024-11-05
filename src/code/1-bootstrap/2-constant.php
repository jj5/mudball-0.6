<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-10 jj5 - load dependencies...
//

require_once __DIR__ . '/1-library.php';

require_once __DIR__ . '/../../../inc/version.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - core library constants...
//

// 2021-03-18 jj5 - you can change the name but not the code...
//
//define( 'MUDBALL_NAME', 'Mudball: Web Framework and Toolkit for PHP' );
//define( 'MUDBALL_CODE', 'mudball' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - path info...
//

define( 'MUDBALL_PATH', realpath( __DIR__ . '/../../../' ) );
define( 'MUDBALL_CONFIG_FILE', 'config.php' );
define( 'MUDBALL_CONFIG_PATH', MUDBALL_PATH . '/' . MUDBALL_CONFIG_FILE );

(function() {

  if ( file_exists( MUDBALL_CONFIG_PATH ) ) { require_once MUDBALL_CONFIG_PATH; }

  // 2024-07-07 jj5 - NOTE: we load the debug config file here, if it exists. This is so that we can get access to
  // DEBUG and DEV constants while we are loading...

  $app_dir = realpath( __DIR__ . '/../../../../../' );
  $app_config = $app_dir . '/debug.php';

  if ( file_exists( $app_config ) ) { require_once $app_config; }

  // 2024-07-07 jj5 - having now loaded both of the debug config file (if it exists) we can now define the DEBUG and DEV
  // constants if they haven't already been defined...

  if ( ! defined( 'DEBUG' ) ) { define( 'DEBUG',  false ); }

  if ( ! defined( 'DEV'   ) ) { define( 'DEV',    false ); }

  if ( ! defined( 'BETA'  ) ) { define( 'BETA',   false ); }

  if ( ! defined( 'PROD'  ) ) { define( 'PROD',   ( ! DEV ) && ( ! BETA ) ); }

  if ( ! defined( 'TEST'  ) ) { define( 'TEST',   false ); }

})();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - maintainer info...
//

define( 'MUDBALL_MAINTAINER_USERNAME',  'jj5'           );
define( 'MUDBALL_MAINTAINER_EMAIL',     'jj5@jj5.net'   );
define( 'MUDBALL_MAINTAINER_NAME',      'John Elliot V' );
define(
  'MUDBALL_MAINTAINER',
  MUDBALL_MAINTAINER_NAME . ' <' . MUDBALL_MAINTAINER_EMAIL . '>'
);

define(
  'MUDBALL_PLEASE_INFORM',
  'please let the maintainer know: ' . MUDBALL_MAINTAINER
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - timing info...
//

(function() {

  define( 'APP_START_MICROTIME', microtime( $get_as_float = true ) );

})();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-10 jj5 - load generated constants, but support the case where they are missing...
//

(function( $includes ) {

  foreach ( $includes as $include ) {

    if ( is_file( $include ) ) { require_once $include; }

  }

})([
  __DIR__ . '/../../gen/country-code/country-code-consts.php',
  __DIR__ . '/../../gen/uri-scheme/uri-scheme-consts.php'
]);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2023-02-22 jj5 - external ID range...
//

define( 'MUD_EXTERNAL_ID_MIN', 500_000_000_000_000 );
define( 'MUD_EXTERNAL_ID_MAX', 599_999_999_999_999 );

// 2023-03-13 jj5 - SEE:
// https://numerologist.com/numerology/13-occult-numbers-and-their-terrifying-meanings/
//
// 2023-03-13 jj5 - NOTE: the replacements make sure the following numbers aren't possible:
// 4, 9, 11, 13, 14, 16, 17, 19, 39, 69, 666, 888, 911;
//
// 2023-03-13 jj5 - NOTE: 19, 39, 69, and 911 are't possible because 9 isn't possible; 14 isn't
// possible because 4 isn't possible. I left in 3 & 7 because they seemed harmless enough. :)
//
define( 'MUD_UNLUCKY_REPLACEMENT', [
      // [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
    4 => [    1, 2, 3,    5, 6, 7, 8    ],
    9 => [    1, 2, 3,    5, 6, 7, 8    ],
   11 => [ 0,    2,       5,       8    ],
   13 => [ 0,    2,       5,       8    ],
   16 => [ 0,    2,       5,       8    ],
   17 => [ 0,    2,       5,       8    ],
  666 => [ 0,    2, 3,    5,    7, 8,   ],
  888 => [ 0,    2, 3,    5,    7,      ],
]);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-27 jj5 - schema info...
//

define( 'MUD_SCHEMA', 'mudballdb' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-24 jj5 - floating point support...
//

define( 'MUD_EPSILON', 0.0000001 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-24 jj5 - build types...
//

define(
  'MUD_BUILD_TYPES',
  [
    'dev',
    'beta',
    'rc1', 'rc2', 'rc3', 'rc4', 'rc5', 'rc6', 'rc7', 'rc8', 'rc9',
    'prod',
  ]
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - HTML <form> names...
//

define( 'APP_FORM_SIGNUP', 'signup' );
define( 'APP_FORM_LOGIN', 'login' );
define( 'APP_FORM_LOGOUT', 'logout' );
define( 'APP_FORM_CREDENTIAL_FORGOT', 'credential-forgot' );
define( 'APP_FORM_CREDENTIAL_RESET', 'credential-reset' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-03-20 jj5 - HTML <form> element (or API) inputs...
//

define( 'APP_INPUT_XSRF', 'xsrf' );

define( 'APP_INPUT_ACTION_DEFAULT', 'action-default' );
define( 'APP_INPUT_ACTION', 'action' );
define( 'APP_INPUT_TOKEN', 'token' );

define( 'APP_INPUT_USERNAME', 'username' );
define( 'APP_INPUT_PASSWORD', 'password' );
define( 'APP_INPUT_PASSWORD_CONFIRM', 'password-confirm' );
define( 'APP_INPUT_EMAIL_ADDRESS', 'email-address' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-10 jj5 - web categories are the first part of the facility or action path / name.
//

define( 'MUD_WEB_CATEGORY_ADMIN',  'admin' );
define( 'MUD_WEB_CATEGORY_DEV',    'dev'   );
define( 'MUD_WEB_CATEGORY_UTIL',   'util'  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-21 jj5 - app actions implemented by Mudball...
//

// 2022-03-20 jj5 - NOTE: the following constants are not prefixed with APP_ or MUD_ because we
// share the namespace with the application.
//
// 2020-04-07 jj5 - format is 'section.noun.verb', where section and
// noun are optional.

define( 'APP_ACTION_DEV_COMPLEX_IDEA_TEST', 'dev.complex-idea.test' );
define( 'APP_ACTION_DEV_FIELD_VALIDATE',    'dev.field.validate' );

define( 'APP_ACTION_ADMIN_USER_CREATE',     'admin.user.create' );
define( 'APP_ACTION_ADMIN_USER_UPDATE',     'admin.user.update' );
define( 'APP_ACTION_ADMIN_USER_DELETE',     'admin.user.delete' );

define( 'APP_ACTION_UTIL_USER_SIGNUP',          'util.user.signup' );
define( 'APP_ACTION_UTIL_USER_LOGIN',           'util.user.login' );
define( 'APP_ACTION_UTIL_USER_LOGOUT',          'util.user.logout' );

define( 'APP_ACTION_UTIL_USER_CREDENTIAL_FORGOT', 'util.user.credential.forgot' );
define( 'APP_ACTION_UTIL_USER_CREDENTIAL_RESET',  'util.user.credential.reset' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - standard facility modes...
//

define( 'APP_FACILITY_MODE_INDEX',  'index' );
define( 'APP_FACILITY_MODE_LIST',   'list'  );
define( 'APP_FACILITY_MODE_VIEW',   'view'  );
define( 'APP_FACILITY_MODE_EDIT',   'edit'  );
define( 'APP_FACILITY_MODE_ADD',    'add'   );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - standard URL query dimensions...
//

define( 'APP_QUERY_SEARCH', 'q'       );
define( 'APP_QUERY_SCHEMA', 'schema'  );
define( 'APP_QUERY_TABLE',  'table'   );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - types of well-known services managed by the service locator...
//

define( 'APP_SERVICE_SCHEMA',       'schema'      );
define( 'APP_SERVICE_INTERACTION',  'interaction' );

define( 'APP_SERVICE_DAL_TRN',      'trn'         );
define( 'APP_SERVICE_DAL_RAW',      'raw'         );
define( 'APP_SERVICE_DAL_EMU',      'emu'         );
define( 'APP_SERVICE_DAL_AUX',      'aux'         );
define( 'APP_SERVICE_DAL_DBA',      'dba'         );

define( 'APP_SERVICE_ORM',          'orm'         );
define( 'APP_SERVICE_REGISTRY',     'registry'    );
define( 'APP_SERVICE_READER',       'reader'      );
define( 'APP_SERVICE_LOGIC',        'logic'       );

define( 'APP_SERVICE_USER',         'user'        );
define( 'APP_SERVICE_BROWSER',      'browser'     );
define( 'APP_SERVICE_SESSION',      'session'     );

define( 'APP_SERVICE_REQUEST',      'request'     );
define( 'APP_SERVICE_RESPONSE',     'response'    );
define( 'APP_SERVICE_URL',          'url'         );

define( 'APP_SERVICE_APP',          'app'         );
define( 'APP_SERVICE_FACTORY',      'factory'     );
define( 'APP_SERVICE_NULL_OBJECT',  'null'        );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - application modules defined by Mudball...
//

function mud_get_module_const_list() {

  $result = [];

  foreach ( glob( '../../../src/code/3-module/*/*' ) as $module_dir ) {

    $parts = explode( '-', $module_dir );

    if ( count( $parts ) !== 2 ) { continue; }

    $module_name = array_pop( $parts );

    // 2022-04-06 jj5 - I'm not sure why we went out of our way to skip these...
    //
    //if ( in_array( $module_name, [ 'module', 'critical', 'basic', 'data', 'web', 'app', 'tool' ] ) ) { continue; }

    $result[] = strtoupper( $module_name );

  }

  return $result;

}

(function() {

  foreach ( mud_get_module_const_list() as $module_const ) {

    $mud_const = "MUD_MODULE_$module_const";
    $app_const = "APP_MODULE_$module_const";

    define( $mud_const, $module_const );
    define( $app_const, $module_const );

  }

})();




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - ANSI escape codes...
//

# 2017-07-03 jj5 - global colour 'constants' are listed here...
#
# 2017-07-03 jj5 - SEE: ANSI escape codes:
# https://stackoverflow.com/a/5947802/868138
#
# 2017-07-06 jj5 - 'L' is for 'light' and 'D' is for 'dark'...
#
define( 'MUD_ANSI_BLACK',   "\033[m" );
define( 'MUD_ANSI_RED',     "\033[0;31m" );
define( 'MUD_ANSI_GREEN',   "\033[0;32m" );
define( 'MUD_ANSI_BROWN',   "\033[0;33m" );
define( 'MUD_ANSI_BLUE',    "\033[0;34m" );
define( 'MUD_ANSI_PURPLE',  "\033[0;35m" );
define( 'MUD_ANSI_CYAN',    "\033[0;36m" );
define( 'MUD_ANSI_LGRAY',   "\033[0;37m" );
define( 'MUD_ANSI_DGRAY',   "\033[1;30m" );
define( 'MUD_ANSI_LRED',    "\033[1;31m" );
define( 'MUD_ANSI_LGREEN',  "\033[1;32m" );
define( 'MUD_ANSI_YELLOW',  "\033[1;33m" );
define( 'MUD_ANSI_LBLUE',   "\033[1;34m" );
define( 'MUD_ANSI_LPURPLE', "\033[1;35m" );
define( 'MUD_ANSI_LCYAN',   "\033[1;36m" );
define( 'MUD_ANSI_WHITE',   "\033[1;37m" );
define( 'MUD_ANSI_END',     "\033[0m" ); # No Colour

# 2017-08-26 jj5 - clear the current line...
define( 'MUD_ANSI_CLEAR', "\033[K" );

# 2017-07-06 jj5 - colour aliases...
define( 'MUD_ANSI_ORANGE', MUD_ANSI_BROWN );
define( 'MUD_ANSI_LGREY', MUD_ANSI_LGRAY );
define( 'MUD_ANSI_DGREY', MUD_ANSI_DGRAY );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-04-16 jj5 - some retry constants...
//

// 2020-04-16 jj5 - the number of times to try...
//
define( 'MUD_DEFAULT_TRY_COUNT', 20 );

// 2020-04-16 jj5 - the delay in microseconds after each failure before a retry...
//
define( 'MUD_DEFAULT_TRY_DELAY', 1000 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-06-18 jj5 - some logging constants...
//
//

define( 'MUD_LOGGER_NULL',    '**null**'   );
define( 'MUD_LOGGER_SYSLOG',  '**syslog**' );
define( 'MUD_LOGGER_FILE',    '**file**'   );

define( 'MUD_LOG_FORMAT_STANDARD',  '**standard**' );
define( 'MUD_LOG_FORMAT_SYSLOG',    '**syslog**'   );
define( 'MUD_LOG_FORMAT_WEB',       '**web**'      );

// 2021-03-04 jj5 - SEE: syslog priority constants:
// https://www.php.net/manual/en/function.syslog.php
//
define( 'MUD_LOG_LEVEL_0_EMERGENCY',  LOG_EMERG );
define( 'MUD_LOG_LEVEL_1_ALERT',      LOG_ALERT );
define( 'MUD_LOG_LEVEL_2_CRITICAL',   LOG_CRIT );
define( 'MUD_LOG_LEVEL_3_ERROR',      LOG_ERR );
define( 'MUD_LOG_LEVEL_4_WARNING',    LOG_WARNING );
define( 'MUD_LOG_LEVEL_5_NOTICE',     LOG_NOTICE );
define( 'MUD_LOG_LEVEL_6_INFO',       LOG_INFO );
define( 'MUD_LOG_LEVEL_7_DEBUG',      LOG_DEBUG );

/*
define( 'MUD_LOG_OPT_LEVEL',  '**level**'  );
define( 'MUD_LOG_OPT_PATH',   '**path**'   );
define( 'MUD_LOG_OPT_STDERR', '**stderr**' );
define( 'MUD_LOG_OPT_WEBLOG', '**weblog**' );
*/

// 2020-04-16 jj5 - in the following defaults 'null' signals auto-detect...
//
define( 'MUD_DEFAULT_LOG_LEVEL',  LOG_WARNING );
/*
define( 'MUD_DEFAULT_LOG_PATH',   null        );
define( 'MUD_DEFAULT_LOG_STDERR', false       );
define( 'MUD_DEFAULT_LOG_WEBLOG', null        );
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-04-16 jj5 - pclog stuff...
//
//

define( 'MUD_PCLOG_DATE_FORMAT', 'D M j Y H:i:s \G\M\TO (T)' );

define( 'MUD_PCLOG_FORM_EXCEPTION', 'php-ex-1' );
define( 'MUD_PCLOG_FORM_ASSERT', 'php-ass-1' );
define( 'MUD_PCLOG_FORM_HTTP', 'php-http-1' );

define( 'MUD_PCLOG_OUTPUT_HTML', 'text/html' );
define( 'MUD_PCLOG_OUTPUT_JSON', 'application/json' );
define( 'MUD_PCLOG_OUTPUT_TEXT', 'text/plain' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-04-16 jj5 - some requirements stuff...
//

define( 'MUD_DEFAULT_VARIABLE', 'value' );
define( 'MUD_DEFAULT_REQUIREMENT', 'is valid' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - schema element types...
//

// 2022-02-24 jj5 - OLD: this is obsolete...
/*
define( 'S_DEF', 'def' );
define( 'S_TAB', 'tab' );
define( 'S_COL', 'col' );
define( 'S_IDX', 'idx' );
define( 'S_DAT', 'dat' );
define( 'S_RUN', 'run' );

define( 'S_REV', 'rev' );
define( 'S_TYPE', 'type' );
define( 'S_NAME', 'name' );

define( 'S_COL_TYPE', 'col-type' );
define( 'S_COL_SPEC', 'col-spec' );
define( 'S_COL_FLAGS', 'col-flags' );
define( 'S_REF_COL', 'ref-col' );

define( 'S_REF_TAB_NAME', 'ref_tab_name' );
define( 'S_REF_COL_NAME', 'ref_col_name' );

define( 'S_COL_FLAG', 'col_flag' );
// 2021-03-28 jj5 - OLD: this was implemented as S_REF_COL_NAME, see above...
//define( 'S_FLAGS_COL_NAME', 'flags_col_name' );
*/

define( 'MUD_SCHEMA_ELEMENT_DEF', 'def' );
define( 'MUD_SCHEMA_ELEMENT_TAB', 'tab' );
define( 'MUD_SCHEMA_ELEMENT_COL', 'col' );
define( 'MUD_SCHEMA_ELEMENT_IDX', 'idx' );
define( 'MUD_SCHEMA_ELEMENT_DAT', 'dat' );
define( 'MUD_SCHEMA_ELEMENT_RUN', 'run' );

define( 'MUD_SCHEMA_COL_IS_KEY', pow( 2, 0 ) );
define( 'MUD_SCHEMA_COL_IS_REF', pow( 2, 1 ) );
define( 'MUD_SCHEMA_COL_IS_VRT', pow( 2, 2 ) );
define( 'MUD_SCHEMA_COL_IS_FLG', pow( 2, 3 ) );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - these are the possible table types (called table patterns):
//

define( 'MUD_TABLE_PATTERN_ABINITIO',     'abinitio'    );
define( 'MUD_TABLE_PATTERN_LOOKUP',       'lookup'      );
define( 'MUD_TABLE_PATTERN_STATIC',       'static'      );
define( 'MUD_TABLE_PATTERN_ABOUT',        'about'       );
define( 'MUD_TABLE_PATTERN_CONFIG',       'config'      );
define( 'MUD_TABLE_PATTERN_DETAIL',       'detail'      );
define( 'MUD_TABLE_PATTERN_IDENT',        'ident'       );
define( 'MUD_TABLE_PATTERN_PARTICLE',     'particle'    );
define( 'MUD_TABLE_PATTERN_PIECE',        'piece'       );
define( 'MUD_TABLE_PATTERN_POT',          'pot'         );
define( 'MUD_TABLE_PATTERN_PRODUCT',      'product'     );
define( 'MUD_TABLE_PATTERN_DOMAIN',       'domain'      );
//define( 'MUD_TABLE_PATTERN_VALUE',      'value'       );
define( 'MUD_TABLE_PATTERN_ENTITY',       'entity'      );
define( 'MUD_TABLE_PATTERN_HISTORY',      'history'     );
define( 'MUD_TABLE_PATTERN_EPHEMERAL',    'ephemeral'   );
define( 'MUD_TABLE_PATTERN_EVENT',        'event'       );
define( 'MUD_TABLE_PATTERN_LOG',          'log'         );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are the possible index types...
//

//define( 'MUD_IDX_PRIMARY',  'IDX_PRIMARY' );
define( 'MUD_IDX_UNIQUE',   'IDX_UNIQUE'  );
define( 'MUD_IDX_INDEX',    'IDX_INDEX'   );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are schema config constants... we rarely omit the MUD_ or APP_
// constant prefix, but we do in this case.
//

define( 'SPEC_MIN',       'min'       );
define( 'SPEC_MAX',       'max'       );
define( 'SPEC_NULLABLE',  'nullable'  );

// 2020-03-26 jj5 - NOTE: default values should be one of the valid sentinels
// (listed below) or otherwise be in database format...
//
define( 'SPEC_DEFAULT', 'default' );

define( 'SPEC_VALID',     'valid'     );
define( 'SPEC_INVALID',   'invalid'   );

// 2021-10-17 jj5 - this is the column we get added after
//
define( 'SPEC_AFTER', 'after' );

// 2022-02-28 jj5 - this is if the new column is first
//
define( 'SPEC_FIRST', 'first' );

// 2022-02-24 jj5 - this holds the list of valid values for the enum...
//
define( 'SPEC_ENUM', 'enum' );

/*
// 2020-09-26 jj5 - for auto-increment columns and sequences the initval is the initial value...
//
define( 'SPEC_INITVAL',   'initval'   );

// 2020-09-26 jj5 - for sequences the increment is the number added to create the
// next identity... we don't support this yet.
//
define( 'SPEC_INCREMENT', 'increment' );
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-26 jj5 - these are Mudball sentinel values...
//

define( 'MUD_DELETED', '**deleted**' );
define( 'MUD_UNSPECIFIED', '**unspecified**' );
define( 'MUD_CURRENT_TIMESTAMP', '**current-timestamp**' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are some typical varchar column sizes...
//

// 2020-03-09 jj5 - SEE: https://dev.blackbrick.com/wiki/Databases#Strings
//
define( 'MUD_SIZE_ASCII_255', 255 );
define( 'MUD_SIZE_ASCII_767', 767 );
define( 'MUD_SIZE_ASCII_60000', 60000 );
define( 'MUD_SIZE_UTF8_63', 63 );
define( 'MUD_SIZE_UTF8_190', 190 );
define( 'MUD_SIZE_UTF8_15000', 15000 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-26 jj5 - these are supported column classes...
//

define( 'MUD_DATABASE_CLASS_ID',        'id'        );
define( 'MUD_DATABASE_CLASS_BOOL',      'bool'      );
define( 'MUD_DATABASE_CLASS_INT',       'int'       );
define( 'MUD_DATABASE_CLASS_FLOAT',     'float'     );
define( 'MUD_DATABASE_CLASS_DATETIME',  'datetime'  );
define( 'MUD_DATABASE_CLASS_TIMEZONE',  'timezone'  );
define( 'MUD_DATABASE_CLASS_HASH',      'hash'      );
define( 'MUD_DATABASE_CLASS_TOKEN',     'token'     );
define( 'MUD_DATABASE_CLASS_ASCII',     'ascii'     );
define( 'MUD_DATABASE_CLASS_UNICODE',   'unicode'   );
define( 'MUD_DATABASE_CLASS_TEXT',      'text'      );
define( 'MUD_DATABASE_CLASS_BINARY',    'binary'    );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are supported database column types...
//

// 2019-09-25 jj5 - NOTE: the 'DBT_' prefix below stands for "database type"

// 2019-09-26 jj5 - boolean...
//
define( 'DBT_BOOL', 'BOOL' );

// 2019-10-16 jj5 - unsigned integers for IDs (auto-increment)...
//
define( 'DBT_ID8',  'ID8'  );
define( 'DBT_ID16', 'ID16' );
define( 'DBT_ID24', 'ID24' );
define( 'DBT_ID32', 'ID32' );
define( 'DBT_ID64', 'ID64' );

// 2019-09-22 jj5 - unsigned integers...
//
define( 'DBT_UINT8',  'UINT8'  );
define( 'DBT_UINT16', 'UINT16' );
define( 'DBT_UINT24', 'UINT24' );
define( 'DBT_UINT32', 'UINT32' );
define( 'DBT_UINT64', 'UINT64' );

// 2019-09-22 jj5 - signed integers...
//
define( 'DBT_INT8',  'INT8'  );
define( 'DBT_INT16', 'INT16' );
define( 'DBT_INT24', 'INT24' );
define( 'DBT_INT32', 'INT32' );
define( 'DBT_INT64', 'INT64' );

// 2019-10-20 jj5 - floats...
//
define( 'DBT_SINGLE', 'SINGLE' );
define( 'DBT_DOUBLE', 'DOUBLE' );

// 2019-09-22 jj5 - datetimes...
//
define( 'DBT_CREATED_ON', 'CREATED_ON' );
define( 'DBT_UPDATED_ON', 'UPDATED_ON' );
// 2020-03-18 jj5 - OLD: there are only two types of timestamp column supported,
// being DBT_CREATED_ON and DBT_UPDATED_ON, as above.
//define( 'DBT_TIMESTAMP',  'TIMESTAMP' );
define( 'DBT_DATETIME_UTC', 'DATETIME_UTC' );
define( 'DBT_DATETIME_SYD', 'DATETIME_SYD' );
define( 'DBT_DATETIME_SRV', 'DATETIME_SRV' );
// 2020-03-23 jj5 - if a datetime is not in UTC then it should have an
// associated timezone...
define( 'DBT_DATETIME',   'DATETIME' );
define( 'DBT_TIMEZONE',   'TIMEZONE' );

// 2019-11-06 jj5 - SHA512/224 hashes in various formats...
//
define( 'DBT_HASH_BIN', 'HASH_BIN' );
define( 'DBT_HASH_HEX', 'HASH_HEX' );

// 2019-11-06 jj5 - tokens are 48 char case-sensitive alphanumerics...
//
define( 'DBT_TOKEN', 'TOKEN' );

// 2019-09-22 jj5 - ASCII...
//
define( 'DBT_ASCII_BIN', 'ASCII_BIN' );
define( 'DBT_ASCII_CI', 'ASCII_CI' );
define( 'DBT_ASCII_CHAR_BIN', 'ASCII_CHAR_BIN' );
define( 'DBT_ASCII_CHAR_CI', 'ASCII_CHAR_CI' );

// 2020-03-09 jj5 - Unicode...
//
define( 'DBT_UTF8_BIN', 'UTF8_BIN' );
define( 'DBT_UTF8_CI', 'UTF8_CI' );
define( 'DBT_UTF8_CHAR_BIN', 'UTF8_CHAR_BIN' );
define( 'DBT_UTF8_CHAR_CI', 'UTF8_CHAR_CI' );

// 2020-03-26 jj5 - text...
//
define( 'DBT_TEXT', 'TEXT' );


// 2020-03-17 jj5 - A "BMOB" is a "Binary Medium Object" (16 MB)
//
define( 'DBT_BMOB', 'BMOB' );
define( 'DBT_BLOB', 'BLOB' );


// 2022-02-24 jj5 - I'm thinking I'll add support for 'enum' types as supported by MySQL...
//
define( 'DBT_ENUM', 'ENUM' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-09-25 jj5 - some MySQL stuff...
//

define( 'MUD_MYSQL_TINYBLOB_MAX',   pow( 2,  8 ) - 1 );
define( 'MUD_MYSQL_BLOB_MAX',       pow( 2, 16 ) - 1 );
define( 'MUD_MYSQL_MEDIUMBLOB_MAX', pow( 2, 24 ) - 1 );
define( 'MUD_MYSQL_LONGBLOB_MAX',   pow( 2, 32 ) - 1 );

define( 'MUD_MYSQL_TINYTEXT_ASCII_MAX',   pow( 2,  8 ) - 1 );
define( 'MUD_MYSQL_TEXT_ASCII_MAX',       pow( 2, 16 ) - 1 );
define( 'MUD_MYSQL_MEDIUMTEXT_ASCII_MAX', pow( 2, 24 ) - 1 );
define( 'MUD_MYSQL_LONGTEXT_ASCII_MAX',   pow( 2, 32 ) - 1 );

define( 'MUD_MYSQL_TINYTEXT_UTF8_MAX',   intval( MUD_MYSQL_TINYTEXT_ASCII_MAX / 4 ) );
define( 'MUD_MYSQL_TEXT_UTF8_MAX',       intval( MUD_MYSQL_TEXT_ASCII_MAX / 4 ) );
define( 'MUD_MYSQL_MEDIUMTEXT_UTF8_MAX', intval( MUD_MYSQL_MEDIUMTEXT_ASCII_MAX / 4 ) );
define( 'MUD_MYSQL_LONGTEXT_UTF8_MAX',   intval( MUD_MYSQL_LONGTEXT_ASCII_MAX / 4 ) );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-08-05 jj5 - we construct some special floats here...
//

// 2022-11-09 jj5 - OLD: these are gone, they create fatal errors while trying to generate the
// values...
/*
(function() {

  $tmp_errors = error_reporting( 0 );

  define( 'MUD_NEG_ZERO', -0.0 );
  define( 'MUD_NEG_INF', log( 0 ) );
  define( 'MUD_POS_INF', abs( MUD_NEG_INF ) );
  define( 'MUD_NAN', 0 / 0 );

  error_reporting( $tmp_errors );

})();
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - we define some limits here...
//

define( 'MUD_MIN_UINT8',  0 );
define( 'MUD_MAX_UINT8',  255 );
define( 'MUD_MIN_UINT16', 0 );
define( 'MUD_MAX_UINT16', 65535 );
define( 'MUD_MIN_UINT24', 0 );
define( 'MUD_MAX_UINT24', 16777215 );
define( 'MUD_MIN_UINT32', 0 );
define( 'MUD_MAX_UINT32', 4294967295 );
define( 'MUD_MIN_UINT64', 0 );
define( 'MUD_MAX_UINT64', PHP_INT_MAX ); // <-- this is a lie! Sort of...

define( 'MUD_MIN_INT8',  -128 );
define( 'MUD_MAX_INT8',  127 );
define( 'MUD_MIN_INT16', -32768 );
define( 'MUD_MAX_INT16', 32767 );
define( 'MUD_MIN_INT24', -8388608 );
define( 'MUD_MAX_INT24', 8388607 );
define( 'MUD_MIN_INT32', -2147483648 );
define( 'MUD_MAX_INT32', 2147483647 );
define( 'MUD_MIN_INT64', PHP_INT_MIN );
define( 'MUD_MAX_INT64', PHP_INT_MAX );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some SQL stuff...
//

define( 'MUD_SQL_DATE_FORMAT',  'Y-m-d H:i:s' );
define( 'MUD_PDO_DATE_FORMAT', MUD_SQL_DATE_FORMAT );
define( 'MUD_SQL_OR',           'or'          );
define( 'MUD_SQL_AND',          'and'         );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some application stuff...
//

define( 'MUD_UTF8', 'UTF-8' );
define( 'MUD_CHARSET', MUD_UTF8 );

// 2019-11-08 jj5 - default cache size is the default size of registration
// and other function internal caches...
//
// 2020-03-20 jj5 - TODO: this should be made a config option...
//
define( 'MUD_DEFAULT_CACHE_SIZE', 1000 );

// 2020-03-20 jj5 - I'm not sure if these usernames are well advised...
//
define( 'MUD_USER_ANONYMOUS', '**anonymous**' );
define( 'MUD_USER_SYSTEM', '**system**' );

// 2022-04-10 jj5 - this is our canonical JSON format which can never be changed (without
// breaking everything that's already using it)... this is a conservative encoding, it escapes
// slashes and unicode. It is not pretty printed.
//
define( 'MUD_JSON_CANONICAL', 0 );

// 2019-09-22 jj5 - this is just for convenience. Note that we do *not* include
// JSON_PARTIAL_OUTPUT_ON_ERROR, if you need that add it yourself...
//
// 2020-04-19 jj5 - TODO: JSON_THROW_ON_ERROR is a PHP 7.3 feature. We're
// currently running on 7.2. But in the future, when 7.3 is available to us,
// we should add JSON_THROW_ON_ERROR to the following three defines.
//
define(
  'MUD_JSON_PRETTY',
  JSON_PRETTY_PRINT      |
  JSON_UNESCAPED_SLASHES |
  JSON_UNESCAPED_UNICODE

);

define(
  'MUD_JSON_COMPACT',
  JSON_UNESCAPED_SLASHES |
  JSON_UNESCAPED_UNICODE
);

define(
  'MUD_JSON_ASCII',
  JSON_UNESCAPED_SLASHES
);

// 2021-03-18 jj5 - NOTE: MUD_JSON_EMBED is the only safe format for embedding JSON data in
// a HTML <script> element. This is because it uses escaped slashes which prevent the malicious
// or accidental inclusion of a script closing tag such as: </script>
//
// 2022-04-09 jj5 - THINK: do I really want Unicode here..?
//
define(
  'MUD_JSON_EMBED',
  JSON_UNESCAPED_UNICODE
);

define( 'MUD_FILE_JSON_FORMAT', MUD_JSON_COMPACT );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some default cookie config settings...
//

// 2019-10-20 jj5 - default browser timeout is fifty years...
//
define( 'MUD_DEFAULT_BROWSER_TIMEOUT', 60 * 60 * 24 * 365 * 50 );

// 2020-03-20 jj5 - browser expiry is rounded down to the day...
//
define( 'MUD_DEFAULT_BROWSER_ROUNDOFF', 60 * 60 * 24 );

// 2019-10-20 jj5 - default session timeout is four days...
// 2019-12-30 jj5 - THINK: doesn't session timeout stick to the browser
// session..? Should review this and see how it's being used...
//
define( 'MUD_DEFAULT_SESSION_TIMEOUT', 60 * 60 * 24 * 4 );

// 2019-10-20 jj5 - session expiry is rounded down to the hour...
//
define( 'MUD_DEFAULT_SESSION_ROUNDOFF', 60 * 60 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-21 jj5 - some XSRF protection settings...
//

// 2019-09-22 jj5 - default XSRF token timeout is four hours...
//
define( 'MUD_DEFAULT_XSRF_TIMEOUT', 60 * 60 * 4 );

// 2020-03-23 jj5 - XSRF expiry is rounded down to the hour...
//
define( 'MUD_DEFAULT_XSRF_ROUNDOFF', 60 * 60 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are possible authentication event codes...
//

define( 'MUD_AUTH_EVENT_SIGNUP',      'signup'      );
define( 'MUD_AUTH_EVENT_LOGIN',       'login'       );
define( 'MUD_AUTH_EVENT_LOGOUT',      'logout'      );
define( 'MUD_AUTH_EVENT_FORGOT',      'forgot'      );
define( 'MUD_AUTH_EVENT_RESET',       'reset'       );
define( 'MUD_AUTH_EVENT_DEACTIVATED', 'deactivated' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible connection type codes...
//

define( 'MUD_CONNECTION_TYPE_TRN', 'trn' );
define( 'MUD_CONNECTION_TYPE_RAW', 'raw' );
define( 'MUD_CONNECTION_TYPE_EMU', 'emu' );
define( 'MUD_CONNECTION_TYPE_AUX', 'aux' );
define( 'MUD_CONNECTION_TYPE_DBA', 'dba' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible cookie type codes...
//

define( 'MUD_COOKIE_TYPE_BROWSER', 'browser' );
define( 'MUD_COOKIE_TYPE_SESSION', 'session' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible CRUD codes...
//

define( 'MUD_CRUD_CREATE',    'create'    );
define( 'MUD_CRUD_RETRIEVE',  'retrieve'  );
define( 'MUD_CRUD_UPDATE',    'update'    );
define( 'MUD_CRUD_DELETE',    'delete'    );
define( 'MUD_CRUD_UNDELETE',  'undelete'  );
define( 'MUD_CRUD_SHRED',     'shred'     );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible database operation codes...
//

define( 'MUD_DATABASE_OPERATION_INSERT',            'insert'            );
define( 'MUD_DATABASE_OPERATION_CREATE_DATABASE',   'create-database'   );
define( 'MUD_DATABASE_OPERATION_CREATE_TABLE',      'create-table'      );
define( 'MUD_DATABASE_OPERATION_CREATE_VIEW',       'create-view'       );
define( 'MUD_DATABASE_OPERATION_CREATE_INDEX',      'create-index'      );
define( 'MUD_DATABASE_OPERATION_CREATE_PROCEDURE',  'create-procedure'  );
define( 'MUD_DATABASE_OPERATION_CREATE_FUNCTION',   'create-function'   );
define( 'MUD_DATABASE_OPERATION_CREATE_OTHER',      'create-other'      );
define( 'MUD_DATABASE_OPERATION_SELECT',            'select'            );
define( 'MUD_DATABASE_OPERATION_UPDATE',            'update'            );
define( 'MUD_DATABASE_OPERATION_ALTER_TABLE',       'alter-table'       );
define( 'MUD_DATABASE_OPERATION_REPLACE',           'replace'           );
define( 'MUD_DATABASE_OPERATION_DELETE',            'delete'            );
define( 'MUD_DATABASE_OPERATION_DROP_DATABASE',     'drop-database'     );
define( 'MUD_DATABASE_OPERATION_DROP_TABLE',        'drop-table'        );
define( 'MUD_DATABASE_OPERATION_DROP_VIEW',         'drop-view'         );
define( 'MUD_DATABASE_OPERATION_DROP_INDEX',        'drop-index'        );
define( 'MUD_DATABASE_OPERATION_DROP_PROCEDURE',    'drop-procedure'    );
define( 'MUD_DATABASE_OPERATION_DROP_FUNCTION',     'drop-function'     );
define( 'MUD_DATABASE_OPERATION_DROP_OTHER',        'drop-other'        );
define( 'MUD_DATABASE_OPERATION_CALL',              'call'              );
define( 'MUD_DATABASE_OPERATION_SET',               'set'               );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-13 jj5 - sort of exception...
//

define( 'MUD_EXCEPTION_PREVIOUS',   'previous'  );
define( 'MUD_EXCEPTION_HANDLED',    'handled'   );
define( 'MUD_EXCEPTION_IGNORED',    'ignored'   );
define( 'MUD_EXCEPTION_FATAL',      'fatal'     );
define( 'MUD_EXCEPTION_UNHANDLED',  'unhandled' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible facility type codes...
//

define( 'MUD_FACILITY_TYPE_API',      'api'       );
define( 'MUD_FACILITY_TYPE_ADMIN',    'admin'     );
define( 'MUD_FACILITY_TYPE_UTILITY',  'utility'   );
define( 'MUD_FACILITY_TYPE_CONTENT',  'content'   );
define( 'MUD_FACILITY_TYPE_IMAGE',    'image'     );
define( 'MUD_FACILITY_TYPE_STYLE',    'style'     );
define( 'MUD_FACILITY_TYPE_SCRIPT',   'script'    );
define( 'MUD_FACILITY_TYPE_RESOURCE', 'resource'  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the top-level media types supported in our
// applications...
//

define( 'MUD_MEDIA_TYPE_TEXT',        'text' );
define( 'MUD_MEDIA_TYPE_IMAGE',       'image' );
define( 'MUD_MEDIA_TYPE_AUDIO',       'audio' );
define( 'MUD_MEDIA_TYPE_VIDEO',       'video' );
define( 'MUD_MEDIA_TYPE_FONT',        'font' );
define( 'MUD_MEDIA_TYPE_APPLICATION', 'application' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are the file extensions that we know about and
// support. Note that they are added to a lookup table (t_lookup_file_type)
// along with other info so if you need to add to this list update the lookup
// data too...
//

define( 'MUD_FILE_EXT_AAC',    'aac'     );
define( 'MUD_FILE_EXT_ABW',    'abw'     );
define( 'MUD_FILE_EXT_ARC',    'arc'     );
define( 'MUD_FILE_EXT_AVI',    'avi'     );
define( 'MUD_FILE_EXT_AZW',    'azw'     );
define( 'MUD_FILE_EXT_BIN',    'bin'     );
define( 'MUD_FILE_EXT_BMP',    'bmp'     );
define( 'MUD_FILE_EXT_BZ',     'bz'      );
define( 'MUD_FILE_EXT_BZ2',    'bz2'     );
define( 'MUD_FILE_EXT_CSH',    'csh'     );
define( 'MUD_FILE_EXT_CSS',    'css'     );
define( 'MUD_FILE_EXT_CSV',    'csv'     );
define( 'MUD_FILE_EXT_DOC',    'doc'     );
define( 'MUD_FILE_EXT_DOCX',   'docx'    );
define( 'MUD_FILE_EXT_EOT',    'eot'     );
define( 'MUD_FILE_EXT_EPUB',   'epub'    );
define( 'MUD_FILE_EXT_GZ',     'gz'      );
define( 'MUD_FILE_EXT_GIF',    'gif'     );
define( 'MUD_FILE_EXT_HTM',    'htm'     );
define( 'MUD_FILE_EXT_HTML',   'html'    );
define( 'MUD_FILE_EXT_ICO',    'ico'     );
define( 'MUD_FILE_EXT_ICS',    'ics'     );
define( 'MUD_FILE_EXT_JAR',    'jar'     );
define( 'MUD_FILE_EXT_JPEG',   'jpeg'    );
define( 'MUD_FILE_EXT_JPG',    'jpg'     );
define( 'MUD_FILE_EXT_JS',     'js'      );
define( 'MUD_FILE_EXT_JSON',   'json'    );
define( 'MUD_FILE_EXT_JSONLD', 'jsonld'  );
define( 'MUD_FILE_EXT_MID',    'mid'     );
define( 'MUD_FILE_EXT_MIDI',   'midi'    );
define( 'MUD_FILE_EXT_MJS',    'mjs'     );
define( 'MUD_FILE_EXT_MP3',    'mp3'     );
define( 'MUD_FILE_EXT_MPEG',   'mpeg'    );
define( 'MUD_FILE_EXT_MPKG',   'mpkg'    );
define( 'MUD_FILE_EXT_ODP',    'odp'     );
define( 'MUD_FILE_EXT_ODS',    'ods'     );
define( 'MUD_FILE_EXT_ODT',    'odt'     );
define( 'MUD_FILE_EXT_OGA',    'oga'     );
define( 'MUD_FILE_EXT_OGV',    'ogv'     );
define( 'MUD_FILE_EXT_OGX',    'ogx'     );
define( 'MUD_FILE_EXT_OPUS',   'opus'    );
define( 'MUD_FILE_EXT_OTF',    'otf'     );
define( 'MUD_FILE_EXT_PNG',    'png'     );
define( 'MUD_FILE_EXT_PDF',    'pdf'     );
define( 'MUD_FILE_EXT_PHP',    'php'     );
define( 'MUD_FILE_EXT_PPT',    'ppt'     );
define( 'MUD_FILE_EXT_PPTX',   'pptx'    );
define( 'MUD_FILE_EXT_RAR',    'rar'     );
define( 'MUD_FILE_EXT_RTF',    'rtf'     );
define( 'MUD_FILE_EXT_SH',     'sh'      );
define( 'MUD_FILE_EXT_SVG',    'svg'     );
define( 'MUD_FILE_EXT_SWF',    'swf'     );
define( 'MUD_FILE_EXT_TAR',    'tar'     );
define( 'MUD_FILE_EXT_TIF',    'tif'     );
define( 'MUD_FILE_EXT_TIFF',   'tiff'    );
define( 'MUD_FILE_EXT_TS',     'ts'      );
define( 'MUD_FILE_EXT_TTF',    'ttf'     );
define( 'MUD_FILE_EXT_TXT',    'txt'     );
define( 'MUD_FILE_EXT_VSD',    'vsd'     );
define( 'MUD_FILE_EXT_WAV',    'wav'     );
define( 'MUD_FILE_EXT_WEBA',   'weba'    );
define( 'MUD_FILE_EXT_WEBM',   'webm'    );
define( 'MUD_FILE_EXT_WEBP',   'webp'    );
define( 'MUD_FILE_EXT_WOFF',   'woff'    );
define( 'MUD_FILE_EXT_WOFF2',  'woff2'   );
define( 'MUD_FILE_EXT_XHTML',  'xhtml'   );
define( 'MUD_FILE_EXT_XLS',    'xls'     );
define( 'MUD_FILE_EXT_XLSX',   'xlsx'    );
define( 'MUD_FILE_EXT_XML',    'xml'     );
define( 'MUD_FILE_EXT_XUL',    'xul'     );
define( 'MUD_FILE_EXT_ZIP',    'zip'     );
define( 'MUD_FILE_EXT_3GP',    '3gp'     );
define( 'MUD_FILE_EXT_3G2',    '3g2'     );
define( 'MUD_FILE_EXT_7Z',     '7z'      );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible gender codes...
//

define( 'MUD_GENDER_FEMALE',      'female'      );
define( 'MUD_GENDER_MALE',        'male'        );
define( 'MUD_GENDER_OTHER',       'other'       );
define( 'MUD_GENDER_UNSPECIFIED', 'unspecified' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - this is a list of HTTP verbs (AKA HTTP methods)...
//

// 2020-03-25 jj5 - SEE: https://annevankesteren.nl/2007/10/http-methods

define( 'MUD_HTTP_VERB_GET',              'GET'               );
define( 'MUD_HTTP_VERB_POST',             'POST'              );
define( 'MUD_HTTP_VERB_PUT',              'PUT'               );
define( 'MUD_HTTP_VERB_DELETE',           'DELETE'            );
define( 'MUD_HTTP_VERB_TRACE',            'TRACE'             );
define( 'MUD_HTTP_VERB_CONNECT',          'CONNECT'           );
define( 'MUD_HTTP_VERB_OPTIONS',          'OPTIONS'           );
define( 'MUD_HTTP_VERB_HEAD',             'HEAD'              );
define( 'MUD_HTTP_VERB_PROPFIND',         'PROPFIND'          );
define( 'MUD_HTTP_VERB_PROPPATCH',        'PROPPATCH'         );
define( 'MUD_HTTP_VERB_MKCOL',            'MKCOL'             );
define( 'MUD_HTTP_VERB_COPY',             'COPY'              );
define( 'MUD_HTTP_VERB_MOVE',             'MOVE'              );
define( 'MUD_HTTP_VERB_LOCK',             'LOCK'              );
define( 'MUD_HTTP_VERB_UNLOCK',           'UNLOCK'            );
define( 'MUD_HTTP_VERB_VERSION_CONTROL',  'VERSION-CONTROL'   );
define( 'MUD_HTTP_VERB_REPORT',           'REPORT'            );
define( 'MUD_HTTP_VERB_CHECKOUT',         'CHECKOUT'          );
define( 'MUD_HTTP_VERB_CHECKIN',          'CHECKIN'           );
define( 'MUD_HTTP_VERB_UNCHECKOUT',       'UNCHECKOUT'        );
define( 'MUD_HTTP_VERB_MKWORKSPACE',      'MKWORKSPACE'       );
define( 'MUD_HTTP_VERB_UPDATE',           'UPDATE'            );
define( 'MUD_HTTP_VERB_LABEL',            'LABEL'             );
define( 'MUD_HTTP_VERB_MERGE',            'MERGE'             );
define( 'MUD_HTTP_VERB_BASELINE_CONTROL', 'BASELINE-CONTROL'  );
define( 'MUD_HTTP_VERB_MKACTIVITY',       'MKACTIVITY'        );
define( 'MUD_HTTP_VERB_ORDERPATCH',       'ORDERPATCH'        );
define( 'MUD_HTTP_VERB_ACL',              'ACL'               );
define( 'MUD_HTTP_VERB_PATCH',            'PATCH'             );
define( 'MUD_HTTP_VERB_SEARCH',           'SEARCH'            );
define( 'MUD_HTTP_VERB_BCOPY',            'BCOPY'             );
define( 'MUD_HTTP_VERB_BDELETE',          'BDELETE'           );
define( 'MUD_HTTP_VERB_BMOVE',            'BMOVE'             );
define( 'MUD_HTTP_VERB_BPROPFIND',        'BPROPFIND'         );
define( 'MUD_HTTP_VERB_BPROPPATCH',       'BPROPPATCH'        );
define( 'MUD_HTTP_VERB_NOTIFY',           'NOTIFY'            );
define( 'MUD_HTTP_VERB_POLL',             'POLL'              );
define( 'MUD_HTTP_VERB_SUBSCRIBE',        'SUBSCRIBE'         );
define( 'MUD_HTTP_VERB_UNSUBSCRIBE',      'UNSUBSCRIBE'       );
define( 'MUD_HTTP_VERB_X_MS_ENUMATTS',    'X-MS-ENUMATTS'     );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - RFC 2616 verbs, the typical HTTP ones that we deal in.
//

define( 'MUD_HTTP_GET',     'GET'     );
define( 'MUD_HTTP_POST',    'POST'    );
define( 'MUD_HTTP_PUT',     'PUT'     );
define( 'MUD_HTTP_DELETE',  'DELETE'  );
define( 'MUD_HTTP_TRACE',   'TRACE'   );
define( 'MUD_HTTP_CONNECT', 'CONNECT' );
define( 'MUD_HTTP_OPTIONS', 'OPTIONS' );
define( 'MUD_HTTP_HEAD',    'HEAD'    );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-10-17 jj5 - HTTP status codes defined here...
//

// 2019-12-30 jj5 - SEE: List of HTTP status codes:
// https://en.wikipedia.org/wiki/List_of_HTTP_status_codes

// 1×× Informational
define( 'MUD_HTTP_100_CONTINUE', 100 );
define( 'MUD_HTTP_101_SWITCHING_PROTOCOLS', 101 );
define( 'MUD_HTTP_102_PROCESSING', 102 );

// 2×× Success
define( 'MUD_HTTP_200_OK', 200 );
define( 'MUD_HTTP_201_CREATED', 201 );
define( 'MUD_HTTP_202_ACCEPTED', 202 );
define( 'MUD_HTTP_203_NON_AUTHORITATIVE_INFORMATION', 203 );
define( 'MUD_HTTP_204_NO_CONTENT', 204 );
define( 'MUD_HTTP_205_RESET_CONTENT', 205 );
define( 'MUD_HTTP_206_PARTIAL_CONTENT', 206 );
define( 'MUD_HTTP_207_MULTI_STATUS', 207 );
define( 'MUD_HTTP_208_ALREADY_REPORTED', 208 );
define( 'MUD_HTTP_226_IM_USED', 226 );

// 3×× Redirection
define( 'MUD_HTTP_300_MULTIPLE_CHOICES', 300 );
define( 'MUD_HTTP_301_MOVED_PERMANENTLY', 301 );
define( 'MUD_HTTP_302_FOUND', 302 );
define( 'MUD_HTTP_303_SEE_OTHER', 303 );
define( 'MUD_HTTP_304_NOT_MODIFIED', 304 );
define( 'MUD_HTTP_305_USE_PROXY', 305 );
define( 'MUD_HTTP_307_TEMPORARY_REDIRECT', 307 );
define( 'MUD_HTTP_308_PERMANENT_REDIRECT', 308 );

// 4×× Client Error
define( 'MUD_HTTP_400_BAD_REQUEST', 400 );
define( 'MUD_HTTP_401_UNAUTHORIZED', 401 );
define( 'MUD_HTTP_402_PAYMENT_REQUIRED', 402 );
define( 'MUD_HTTP_403_FORBIDDEN', 403 );
define( 'MUD_HTTP_404_NOT_FOUND', 404 );
define( 'MUD_HTTP_405_METHOD_NOT_ALLOWED', 405 );
define( 'MUD_HTTP_406_NOT_ACCEPTABLE', 406 );
define( 'MUD_HTTP_407_PROXY_AUTHENTICATION_REQUIRED', 407 );
define( 'MUD_HTTP_408_REQUEST_TIMEOUT', 408 );
define( 'MUD_HTTP_409_CONFLICT', 409 );
define( 'MUD_HTTP_410_GONE', 410 );
define( 'MUD_HTTP_411_LENGTH_REQUIRED', 411 );
define( 'MUD_HTTP_412_PRECONDITION_FAILED', 412 );
define( 'MUD_HTTP_413_PAYLOAD_TOO_LARGE', 413 );
define( 'MUD_HTTP_414_REQUEST_URI_TOO_LONG', 414 );
define( 'MUD_HTTP_415_UNSUPPORTED_MEDIA_TYPE', 415 );
define( 'MUD_HTTP_416_REQUESTED_RANGE_NOT_SATISFIABLE', 416 );
define( 'MUD_HTTP_417_EXPECTATION_FAILED', 417 );
define( 'MUD_HTTP_418_IM_A_TEAPOT', 418 );
define( 'MUD_HTTP_421_MISDIRECTED_REQUEST', 421 );
define( 'MUD_HTTP_422_UNPROCESSABLE_ENTITY', 422 );
define( 'MUD_HTTP_423_LOCKED', 423 );
define( 'MUD_HTTP_424_FAILED_DEPENDENCY', 424 );
define( 'MUD_HTTP_426_UPGRADE_REQUIRED', 426 );
define( 'MUD_HTTP_428_PRECONDITION_REQUIRED', 428 );
define( 'MUD_HTTP_429_TOO_MANY_REQUESTS', 429 );
define( 'MUD_HTTP_431_REQUEST_HEADER_FIELDS_TOO_LARGE', 431 );
define( 'MUD_HTTP_444_CONNECTION_CLOSED_WITHOUT_RESPONSE', 444 );
define( 'MUD_HTTP_451_UNAVAILABLE_FOR_LEGAL_REASONS', 451 );
define( 'MUD_HTTP_499_CLIENT_CLOSED_REQUEST', 499 );

// 5×× Server Error
define( 'MUD_HTTP_500_INTERNAL_SERVER_ERROR', 500 );
define( 'MUD_HTTP_501_NOT_IMPLEMENTED', 501 );
define( 'MUD_HTTP_502_BAD_GATEWAY', 502 );
define( 'MUD_HTTP_503_SERVICE_UNAVAILABLE', 503 );
define( 'MUD_HTTP_504_GATEWAY_TIMEOUT', 504 );
define( 'MUD_HTTP_505_HTTP_VERSION_NOT_SUPPORTED', 505 );
define( 'MUD_HTTP_506_VARIANT_ALSO_NEGOTIATES', 506 );
define( 'MUD_HTTP_507_INSUFFICIENT_STORAGE', 507 );
define( 'MUD_HTTP_508_LOOP_DETECTED', 508 );
define( 'MUD_HTTP_510_NOT_EXTENDED', 510 );
define( 'MUD_HTTP_511_NETWORK_AUTHENTICATION_REQUIRED', 511 );
define( 'MUD_HTTP_599_NETWORK_CONNECT_TIMEOUT_ERROR', 599 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - various types of 'rectangles' supported in the
// database...
//

define( 'MUD_RECTANGLE_TYPE_TABLE',  'table'   );
define( 'MUD_RECTANGLE_TYPE_VIEW',   'view'    );
define( 'MUD_RECTANGLE_TYPE_PRETTY', 'pretty'  );
define( 'MUD_RECTANGLE_TYPE_OTHER',  'other'   );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - various types of user roles... these can be extended by applications.
//

define( 'MUD_ROLE_USER',          'user'          );
define( 'MUD_ROLE_ADMINISTRATOR', 'administrator' );
define( 'MUD_ROLE_PROGRAMMER',    'programmer'    );
define( 'MUD_ROLE_TESTER',        'tester'        );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - available membership statues, used as role statuses...
//

define( 'MUD_MEMBERSHIP_STATUS_UNSET',      'unset'     );
define( 'MUD_MEMBERSHIP_STATUS_NONMEMBER',  'nonmember' );
define( 'MUD_MEMBERSHIP_STATUS_MEMBER',     'member'    );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-30 jj5 - process status codes...
//

define( 'MUD_PROCESS_STATUS_LIVE',  'live'  );
define( 'MUD_PROCESS_STATUS_DONE',  'done' );
define( 'MUD_PROCESS_STATUS_FAIL',  'fail' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - serialization types...
//

define( 'MUD_SERIALIZATION_TYPE_JSON', 'json' );
define( 'MUD_SERIALIZATION_TYPE_PHP', 'php' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - service types...
//

define( 'MUD_SERVICE_TYPE_STANDARD',  'standard'  );
define( 'MUD_SERVICE_TYPE_CUSTOM',    'custom'    );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - token status codes...
//

define( 'MUD_TOKEN_STATUS_OPEN',    'open'    );
define( 'MUD_TOKEN_STATUS_USED',    'used'    );
define( 'MUD_TOKEN_STATUS_EXPIRED', 'expired' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - token type codes...
//

define( 'MUD_TOKEN_TYPE_BROWSER',           'browser'         );
define( 'MUD_TOKEN_TYPE_SESSION',           'session'         );
define( 'MUD_TOKEN_TYPE_XSRF',              'xsrf'            );
define( 'MUD_TOKEN_TYPE_CREDENTIAL_RESET',  'credential-reset'  );
define( 'MUD_TOKEN_TYPE_EMAIL_VERIFY',      'email-verify'    );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - URL schemes...
//

define( 'MUD_URL_SCHEME_HTTPS', 'https' );
define( 'MUD_URL_SCHEME_HTTP',  'http'  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-09-22 jj5 - we define ASCII control characters here...
//

// 2019-09-22 jj5 - SEE: ASCII Control Characters:
// http://ascii-table.com/control-chars.php

define( 'MUD_ASCII_NUL', "\x00" ); // Null
define( 'MUD_ASCII_STX', "\x01" ); // Start of Header
define( 'MUD_ASCII_SOT', "\x02" ); // Start of Text
define( 'MUD_ASCII_ETX', "\x03" ); // End of Text
define( 'MUD_ASCII_EOT', "\x04" ); // End of Transmission
define( 'MUD_ASCII_ENQ', "\x05" ); // Enquiry
define( 'MUD_ASCII_ACK', "\x06" ); // Acknowledge
define( 'MUD_ASCII_BEL', "\x07" ); // Bell (\a)
define( 'MUD_ASCII_BS' , "\x08" ); // Backspace (\b)
define( 'MUD_ASCII_VT' , "\x0b" ); // Vertical Tabulation (\v)
define( 'MUD_ASCII_FF' , "\x0c" ); // Form Feed (\f)
define( 'MUD_ASCII_SO' , "\x0e" ); // Shift Out
define( 'MUD_ASCII_SI' , "\x0f" ); // Shift In
define( 'MUD_ASCII_DLE', "\x10" ); // Data Link Escape
define( 'MUD_ASCII_DC1', "\x11" ); // Device Control 1 (XON)
define( 'MUD_ASCII_DC2', "\x12" ); // Device Control 2
define( 'MUD_ASCII_DC3', "\x13" ); // Device Control 3 (XOFF)
define( 'MUD_ASCII_DC4', "\x14" ); // Device Control 4
define( 'MUD_ASCII_NAK', "\x15" ); // Negative Acknowledge
define( 'MUD_ASCII_SYN', "\x16" ); // Synchronous Idle
define( 'MUD_ASCII_ETB', "\x17" ); // End of Transmission Block
define( 'MUD_ASCII_CAN', "\x18" ); // Cancel
define( 'MUD_ASCII_EM' , "\x19" ); // End of Medium
define( 'MUD_ASCII_SUB', "\x1a" ); // Substitute
define( 'MUD_ASCII_ESC', "\x1b" ); // Escape
define( 'MUD_ASCII_FS' , "\x1c" ); // File Separator
define( 'MUD_ASCII_GS' , "\x1d" ); // Group Separator
define( 'MUD_ASCII_RS' , "\x1e" ); // Record Separator
define( 'MUD_ASCII_US' , "\x1f" ); // Unit Separator
define( 'MUD_ASCII_DEL', "\x7f" ); // Delete

// 2019-09-22 jj5 - these control chars etc are various types of whitespace...

define( 'MUD_ASCII_HT' , "\x09" ); // Horizontal Tabulation (\t)
define( 'MUD_ASCII_LF' , "\x0a" ); // Line Feed (\n)
define( 'MUD_ASCII_CR' , "\x0d" ); // Carriage Return (\r)

define( 'MUD_UTF8_NBSP', "\xc2\xa0" ); // Non-breaking space



// 2017-06-02 jj5 - TODO: we need currency codes.


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-11-12 jj5 - some data validation constants...
//
//

// 2022-02-21 jj5 - NEW:
// 2022-02-21 jj5 - SEE: https://html.spec.whatwg.org/multipage/input.html#valid-e-mail-address
//
define( 'MUD_REGEX_VALID_EMAIL', "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/" );
//
// 2022-02-21 jj5 - OLD:
// 2019-11-12 jj5 - SEE: email validation regex:
// http://emailregex.com/
//
//define( 'MUD_REGEX_VALID_EMAIL', '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD' );



// 2019-11-12 jj5 - SEE: StackOverflow How to validate a user name with regex?:
// https://stackoverflow.com/a/37658211
//
define( 'MUD_REGEX_VALID_USERNAME', '/^[a-z]+([-\.]?[a-z0-9])*$/' );

// 2020-09-13 jj5 - valid slug...
//
// 2020-09-22 jj5 - NOTE: this isn't the last word on slug validation. For example a slug
// shouldn't end in a slash or have duplicate slashes but this regular expression doesn't
// capture that...
//
// 2020-09-22 jj5 - THINK: is it important that a slug doesn't start with a number..?
//
define( 'MUD_REGEX_VALID_SLUG', '/^[a-z][a-z0-9\-]*$/' );

// 2020-03-24 jj5 - valid format for PDO...
//
define( 'MUD_REGEX_VALID_DATETIME', '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/' );

// 2020-03-24 jj5 - valid format for hexadecimal hashes...
//
define( 'MUD_REGEX_VALID_HASH_HEX', '/^[0-9a-f]{56}$/' );

// 2020-03-24 jj5 - valid format for tokens...
//
define( 'MUD_REGEX_VALID_TOKEN', '/^[A-Za-z0-9]{48}$/' );

// 2020-03-24 jj5 - NOTE: no allowed control chars, not even \n (line feed)...
//
define( 'MUD_REGEX_VALID_ASCII', '/^[\x20-\x7E]*$/' );

// 2020-03-24 jj5 - NOTE: no allowed control chars, not even \n (line feed)...
//
define( 'MUD_REGEX_VALID_UTF8', '/^[^\x00-\x1f\x7f]*$/' );

// 2021-03-31 jj5 - NOTE: cannot start or end with space or contain two sequential spaces...
//
define( 'MUD_REGEX_INVALID_CORD', '/^\s|\s\s|\s$/' );

// 2020-03-24 jj5 - NOTE: only allowed control char is \n (line feed)...
//
// 2020-03-26 jj5 - NOTE: any \r (carriage return) values are removed during
// read so that line endings are normalized to \n.
//
// 2020-03-26 jj5 - THINK: allow \t .. ?
//
define( 'MUD_REGEX_VALID_TEXT', '/^[^\x00-\x09\x0b-\x1f\x7f]*$/' );

// 2020-03-26 jj5 - valid format for app codes...
//
define( 'MUD_REGEX_VALID_APP_CODE', '/^[a-z][a-z0-9]*$/' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-08-14 jj5 - some UUID matching patterns...
//
//

//
// 2018-08-14 jj5 - SEE: UUID patterns below stolen from StackOverflow:
// https://stackoverflow.com/a/38191104/868138
//

define(
  'MUD_REGEX_UUID_ANY',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);

define(
  'MUD_REGEX_UUID_V1',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[1][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);

define(
  'MUD_REGEX_UUID_V2',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[2][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);

define(
  'MUD_REGEX_UUID_V3',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[3][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);

define(
  'MUD_REGEX_UUID_V4',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);

define(
  'MUD_REGEX_UUID_V5',
  '/^[0-9a-f]{8}-[0-9a-f]{4}-[5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i'
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-06 jj5 - HTML <input> types...
//

// 2022-04-06 jj5 - SEE: https://www.w3schools.com/html/html_form_input_types.asp

define( 'MUD_HTML_INPUT_TYPE_BUTTON',         'button'          );
define( 'MUD_HTML_INPUT_TYPE_CHECKBOX',       'checkbox'        );
define( 'MUD_HTML_INPUT_TYPE_COLOR',          'color'           );
define( 'MUD_HTML_INPUT_TYPE_DATE',           'date'            );
define( 'MUD_HTML_INPUT_TYPE_DATETIME_LOCAL', 'datetime-local'  );
define( 'MUD_HTML_INPUT_TYPE_EMAIL',          'email'           );
define( 'MUD_HTML_INPUT_TYPE_FILE',           'file'            );
define( 'MUD_HTML_INPUT_TYPE_HIDDEN',         'hidden'          );
define( 'MUD_HTML_INPUT_TYPE_IMAGE',          'image'           );
define( 'MUD_HTML_INPUT_TYPE_MONTH',          'month'           );
define( 'MUD_HTML_INPUT_TYPE_NUMBER',         'number'          );
define( 'MUD_HTML_INPUT_TYPE_PASSWORD',       'password'        );
define( 'MUD_HTML_INPUT_TYPE_RADIO',          'radio'           );
define( 'MUD_HTML_INPUT_TYPE_RANGE',          'range'           );
define( 'MUD_HTML_INPUT_TYPE_RESET',          'reset'           );
define( 'MUD_HTML_INPUT_TYPE_SEARCH',         'search'          );
define( 'MUD_HTML_INPUT_TYPE_SUBMIT',         'submit'          );
define( 'MUD_HTML_INPUT_TYPE_TEL',            'tel'             );
define( 'MUD_HTML_INPUT_TYPE_TEXT',           'text'            );
define( 'MUD_HTML_INPUT_TYPE_TIME',           'time'            );
define( 'MUD_HTML_INPUT_TYPE_URL',            'url'             );
define( 'MUD_HTML_INPUT_TYPE_WEEK',           'week'            );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some constants for the HTML library...
//

// 2017-06-01 jj5 - SEE: Recommended list of Doctype declarations:
// https://www.w3.org/QA/2002/04/valid-dtd-list.html
//
// 2017-06-01 jj5 - THINK: add support for other doctypes... hah! one day.
// 2019-09-13 jj5 - NOTE: I don't think we'll ever support anything less than
// HTML5...
//
define( 'MUD_DOCTYPE_HTML5', 'html'  );
define( 'MUD_DOCTYPE_XML',   'xml'   );

define( 'MUD_CONTENT_TYPE_HTML',  'text/html' );
define( 'MUD_CONTENT_TYPE_JSON',  'application/json' );
define( 'MUD_CONTENT_TYPE_TEXT',  'text/plain' );
define( 'MUD_CONTENT_TYPE_CSV',   'text/csv' );
define( 'MUD_CONTENT_TYPE_XML',   'application/xml' );
define( 'MUD_CONTENT_TYPE_XHTML', 'application/xhtml+xml' );
define( 'MUD_CONTENT_TYPE_RSS',   'application/rss+xml' );

// 2019-09-13 jj5 - table formatting options...
//
define( 'MUD_HTML_TABLE_FLAG_SHOW_COUNTER', pow( 2,  0 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_HELP',    pow( 2,  1 ) );
define( 'MUD_HTML_TABLE_FLAG_NICE_TABLE',   pow( 2,  2 ) );
define( 'MUD_HTML_TABLE_FLAG_SORTABLE',     pow( 2,  3 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_FOOTER',  pow( 2,  4 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_TOTALS',  pow( 2,  5 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_STATS',   pow( 2,  6 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_CSV',     pow( 2,  7 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_NULL',    pow( 2,  8 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_TRUE',    pow( 2,  9 ) );
define( 'MUD_HTML_TABLE_FLAG_SHOW_FALSE',   pow( 2, 10 ) );

define(
  'MUD_HTML_TABLE_FLAG_SHOW_BOOL',
  MUD_HTML_TABLE_FLAG_SHOW_TRUE |
  MUD_HTML_TABLE_FLAG_SHOW_FALSE
);

// 2019-09-12 jj5 - case-insensitive column types...
//
define( 'MUD_HTML_COL_TYPE_HTML', 'html' );
define( 'MUD_HTML_COL_TYPE_BOOL', 'bool' ); // formated 'true', 'false'.
define( 'MUD_HTML_COL_TYPE_YES', 'yes' );
define( 'MUD_HTML_COL_TYPE_NO', 'no' );
define( 'MUD_HTML_COL_TYPE_YESNO', 'yesno' );
define( 'MUD_HTML_COL_TYPE_TEXT', 'text' );
define( 'MUD_HTML_COL_TYPE_STRING', 'string' );
define( 'MUD_HTML_COL_TYPE_EMAIL', 'email' );
define( 'MUD_HTML_COL_TYPE_IP', 'ip' );
define( 'MUD_HTML_COL_TYPE_URL', 'url' );
define( 'MUD_HTML_COL_TYPE_LINK', 'link' );
define( 'MUD_HTML_COL_TYPE_URLENCODED', 'x-www-form-urlencoded' );
define( 'MUD_HTML_COL_TYPE_HTTP_VERB', 'http-verb' );

// 2019-09-12 jj5 - numeric column types...
//
define( 'MUD_HTML_COL_TYPE_ID', 'id' );
define( 'MUD_HTML_COL_TYPE_INT', 'int' );
define( 'MUD_HTML_COL_TYPE_FLOAT', 'float' );
define( 'MUD_HTML_COL_TYPE_COUNT', 'count' );
define( 'MUD_HTML_COL_TYPE_AVERAGE', 'average' );
define( 'MUD_HTML_COL_TYPE_PERCENT', 'percent' );
define( 'MUD_HTML_COL_TYPE_HTTP_CODE', 'http-code' );

// 2019-09-12 jj5 - currency column types... (these are a bit stupid and aren't
// properly implemented... needs more thought.)
//
define( 'MUD_HTML_COL_TYPE_CURRENCY', 'currency' );
define( 'MUD_HTML_COL_TYPE_DOLLARS', 'dollars' );

// 2019-09-12 jj5 - date/time column types...
//
define( 'MUD_HTML_COL_TYPE_DATE', 'date' );
define( 'MUD_HTML_COL_TYPE_TIME', 'time' );
define( 'MUD_HTML_COL_TYPE_DATETIME', 'datetime' );

// 2019-09-13 jj5 - special column type which indicates the column type will
// be inferred from its value...
//
define( 'MUD_HTML_COL_TYPE_INFER', 'infer' );

// 2019-09-13 jj5 - HTML output defaults...
//
define( 'MUD_HTML_DEFAULT_DOCTYPE', MUD_DOCTYPE_HTML5 );
define( 'MUD_HTML_DEFAULT_LANG', 'en' );
define( 'MUD_HTML_DEFAULT_CHARSET', MUD_UTF8 );
define( 'MUD_HTML_DEFAULT_CONTENT_TYPE', MUD_CONTENT_TYPE_HTML );
define(
  'MUD_HTML_DEFAULT_TABLE_FLAGS',
  MUD_HTML_TABLE_FLAG_SHOW_COUNTER |
  // 2019-09-13 jj5 - THINK: do we want to show help by default? I think not,
  // because often it probably won't even be implemented... :P
  //MUD_HTML_TABLE_FLAG_SHOW_HELP |
  MUD_HTML_TABLE_FLAG_NICE_TABLE |
  MUD_HTML_TABLE_FLAG_SORTABLE |
  MUD_HTML_TABLE_FLAG_SHOW_FOOTER |
  MUD_HTML_TABLE_FLAG_SHOW_NULL |
  MUD_HTML_TABLE_FLAG_SHOW_BOOL
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-09-21 jj5 - some stagger options for use in the workspace module...
//

define( 'MUD_STAGGER_NONE', false );
//define( 'MUD_STAGGER_NAME', 'name' );
define( 'MUD_STAGGER_NAME_1', 1 );
define( 'MUD_STAGGER_NAME_2', 2 );
define( 'MUD_STAGGER_NAME_3', 3 );
define( 'MUD_STAGGER_DATE', 'date' );
define( 'MUD_STAGGER_MONTH', 'month' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some I/O limits...
//

define( 'MUD_COLS_MIN', 80 );
define( 'MUD_COLS_MAX', 512 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-09-22 jj5 - some PHP data types...
//

// 2017-06-03 jj5 - 'datatypes' are things which PHP understands natively
// (well, that's almost true... we define is_$type() functions for things
// that are missing...)
define( 'MUD_DATATYPE_NULL', 'null' );
define( 'MUD_DATATYPE_BOOL', 'bool' );
define( 'MUD_DATATYPE_INT', 'int' );
define( 'MUD_DATATYPE_FLOAT', 'float' );
define( 'MUD_DATATYPE_DATETIME', 'datetime' );
define( 'MUD_DATATYPE_BINARY', 'binary' );
define( 'MUD_DATATYPE_STRING', 'string' );
define( 'MUD_DATATYPE_UTF8', 'utf8' );
define( 'MUD_DATATYPE_ASCII', 'ascii' );
define( 'MUD_DATATYPE_ARRAY', 'array' );
define( 'MUD_DATATYPE_OBJECT', 'object' );
define( 'MUD_DATATYPE_CALLABLE', 'callable' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-30 jj5 - string types...
//
define( 'MUD_STRING_TYPE_ASCII', 'ascii' );
define( 'MUD_STRING_TYPE_UNICODE', 'unicode' );
define( 'MUD_STRING_TYPE_BINARY', 'binary' );
define( 'MUD_STRING_TYPE_OTHER', 'other' );


// 2021-03-18 jj5 - OLD: the following code is out for now, it might be re-included if the
// modules that use it are migrated from PHPBOM to Mudball...
//
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-09-22 jj5 - some application data types, listed in a hierarchy...
//

// 2017-06-03 jj5 - types to think about:
//* hash
//* base64
//* url
//* relative url ..? (can be full too?)
//* data URI
//* email? (i.e. subject, body, to, cc, etc.)
//* pattern (i.e. regex)

// a password or secret
define( 'MUD_TYPE_SECRET', 'secret' );

// binary string
define( 'MUD_TYPE_BLOB', 'blob' );
  // PHP string in UTF-8 format
  define( 'MUD_TYPE_UTF8', 'utf8' );
    // PHP string in 7-bit ASCII format
    define( 'MUD_TYPE_ASCII', 'ascii' );

// 'simple' values are 'null', 'bool', 'number', 'datetime', 'string'.
define( 'MUD_TYPE_SIMPLE', 'simple' );

  define( 'MUD_TYPE_NULL', 'null' );

  define( 'MUD_TYPE_BOOL', 'bool' );

  // int or float
  define( 'MUD_TYPE_NUMBER', 'number' );
    // 64-bit integer
    define( 'MUD_TYPE_INT', 'int' );
      // 2017-06-03 jj5 - TODO: ID (format without commas)
      define( 'MUD_TYPE_ID', 'id' );
      // integral seconds since epoch
      define( 'MUD_TYPE_TIMESTAMP', 'timestamp' );
      // 2017-06-03 jj5 - THINK: do we allow negative count/bytes? If not
      // perhaps define a 'postive int' type..?
      define( 'MUD_TYPE_COUNT', 'count' );
      define( 'MUD_TYPE_BYTES', 'bytes' );
    // 64-bit float
    define( 'MUD_TYPE_FLOAT', 'float' );
      // float seconds since epoch
      define( 'MUD_TYPE_MICROTIME', 'microtime' );

  // a date/time
  define( 'MUD_TYPE_DATETIME', 'datetime' );

  // UTF-8 w/o control chars except {\t,\n}
  define( 'MUD_TYPE_STRING', 'string' );
    // trimmed str w/o tabs
    define( 'MUD_TYPE_TEXT', 'text' );
      // text w/o (much) whitespace (single spaces are OK)
      define( 'MUD_TYPE_CORD', 'cord' );
        // cord of first line from text
        define( 'MUD_TYPE_LINEONE', 'lineone' );
        // uppercase cord
        define( 'MUD_TYPE_UPPER', 'upper' );
        // lowercase cord
        define( 'MUD_TYPE_LOWER', 'lower' );
        // a string to use in URLs
        define( 'MUD_TYPE_SLUG', 'slug' );
        // money is a string format
        define( 'MUD_TYPE_MONEY', 'money' );
        // a variable name (most languages)
        define( 'MUD_TYPE_VARNAME', 'varname' );
          // PascalCase cord
          define( 'MUD_TYPE_PASCAL', 'pascal' );
          // camelCase cord
          define( 'MUD_TYPE_CAMEL', 'camel' );
          // Title Case cord
          define( 'MUD_TYPE_TITLECASE', 'titlecase' );

// 2017-06-03 jj5 - TODO: we probably want INT_MAP, INT_LIST, etc. So much
// to do!
define( 'MUD_TYPE_ARRAY', 'array' ); // any array
  // an array with string keys
  define( 'MUD_TYPE_MAP', 'map' );
    // a 'map' with simple values. See above for what simple values are.
    define( 'MUD_TYPE_SMAP', 'smap' );
  // array with integral keys in sequence from zero...
  define( 'MUD_TYPE_LIST', 'list' );
    // a 'list' with simple values. See above for what simple values are.
    define( 'MUD_TYPE_SLIST', 'slist' );
    // a list of smaps
    define( 'MUD_TYPE_TABLE', 'table' );

// 2017-06-03 jj5 - an 'OBJ' is a PHP object...
define( 'MUD_TYPE_OBJ', 'obj' );
// 2017-06-03 jj5 - a 'FUNC' is something PHP can call, e.g. a string with
// a function name, an array with an object and the method name to call on it
// or a closure.
define( 'MUD_TYPE_FUNC', 'func' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some formatting options...
//

// 2020-03-20 jj5 - TODO: these should be reviewed along with the code that
// uses them...

define( 'MUD_FORMAT_NULL', MUD_TYPE_NULL );
define( 'MUD_FORMAT_BOOL', MUD_TYPE_BOOL );
define( 'MUD_FORMAT_NUMBER', MUD_TYPE_NUMBER );
define( 'MUD_FORMAT_INT', MUD_TYPE_INT );
define( 'MUD_FORMAT_COUNT', MUD_TYPE_COUNT );
define( 'MUD_FORMAT_BYTES', MUD_TYPE_BYTES );
define( 'MUD_FORMAT_TIMESTAMP', MUD_TYPE_TIMESTAMP );
define( 'MUD_FORMAT_FLOAT', MUD_TYPE_FLOAT );
define( 'MUD_FORMAT_MICROTIME', MUD_TYPE_MICROTIME );
define( 'MUD_FORMAT_DATETIME', MUD_TYPE_DATETIME );
define( 'MUD_FORMAT_DATETIMEZ', 'datetimez' );
define( 'MUD_FORMAT_DATE', 'date' );
define( 'MUD_FORMAT_TIME', 'time' );
// 2017-06-03 jj5 - you can't format secrets!
//define( 'MUD_FORMAT_SECRET', MUD_TYPE_SECRET );
define( 'MUD_FORMAT_BLOB', MUD_TYPE_BLOB );
define( 'MUD_FORMAT_STRING', MUD_TYPE_STRING );
define( 'MUD_FORMAT_TEXT', MUD_TYPE_TEXT );
define( 'MUD_FORMAT_CORD', MUD_TYPE_CORD );
define( 'MUD_FORMAT_LINEONE', MUD_TYPE_LINEONE );
define( 'MUD_FORMAT_UPPER', MUD_TYPE_UPPER );
define( 'MUD_FORMAT_LOWER', MUD_TYPE_LOWER );
define( 'MUD_FORMAT_PASCAL', MUD_TYPE_PASCAL );
define( 'MUD_FORMAT_CAMEL', MUD_TYPE_CAMEL );
define( 'MUD_FORMAT_TITLECASE', MUD_TYPE_TITLECASE );
define( 'MUD_FORMAT_VARNAME', MUD_TYPE_VARNAME );
define( 'MUD_FORMAT_SLUG', MUD_TYPE_SLUG );
define( 'MUD_FORMAT_MONEY', MUD_TYPE_MONEY );
define( 'MUD_FORMAT_MAP', MUD_TYPE_MAP );
define( 'MUD_FORMAT_SMAP', MUD_TYPE_SMAP );
define( 'MUD_FORMAT_LIST', MUD_TYPE_LIST );
define( 'MUD_FORMAT_SLIST', MUD_TYPE_SLIST );
define( 'MUD_FORMAT_TABLE', MUD_TYPE_TABLE );
define( 'MUD_FORMAT_TABSUM', 'tabsum' );


// 2017-06-03 jj5 - 'options' (MUD_OPT_*) can be specified for convert_*()
// and format_*() functions. Not all options apply in each type of function.
// Perhaps this is a really bad idea and we should differentiate...?

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2017-06-03 jj5 - options that apply to both format_*() and convert_*():
//

// 2017-06-03 jj5 - the number of decimal places to use,
// for conversion: null for no rounding.
// for formatting: null for 'auto'.

define( 'MUD_OPT_PRECISION', 'precision' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2017-06-03 jj5 - options that apply to convert_*() (note that format_*()
// functions use convert_*() functions, so the options pass-through.
//

define( 'MUD_OPT_ALLOW_NULL', 'allow-null' );
define( 'MUD_OPT_ALLOW_FALSE', 'allow-false' );
define( 'MUD_OPT_ALLOW_TRUE', 'allow-true' );
define( 'MUD_OPT_ALLOW_ZERO', 'allow-zero' );
// 2017-06-03 jj5 - the valid range [ min, max ]
define( 'MUD_OPT_RANGE', 'range' );
// 2017-06-03 jj5 - min/max override range
define( 'MUD_OPT_MIN', 'min' );
define( 'MUD_OPT_MAX', 'max' );
// 2017-06-03 jj5 - boolean values to require positive/negative. These are
// checked in addition to range.
define( 'MUD_OPT_POSITIVE', 'positive' );
define( 'MUD_OPT_NEGATIVE', 'negative' );
// 2017-06-03 jj5 - the valid and invalid regex patterns
define( 'MUD_OPT_VALID', 'valid' );
define( 'MUD_OPT_INVALID', 'invalid' );

// 2017-06-03 jj5 - NOTE: if you don't throw, and you don't default, then
// you take what you get!

// 2017-06-02 jj5 - NOTE: 'throw' gets processed before 'use-default'
// 2017-06-02 jj5 - throw exceptions... if set it enables the more specific
// options...
define( 'MUD_OPT_THROW', 'throw' );
// 2017-06-02 jj5 - throw an exception if input is not already valid without
// conversion.
define( 'MUD_OPT_THROW_ON_INVALID_INPUT', 'throw-on-invalid-input' );
// 2017-06-02 jj5 - throw an exception if the input is null...
define( 'MUD_OPT_THROW_ON_NULL', 'throw-on-null' );
// 2017-06-02 jj5 - throw an exception if the input is empty...
define( 'MUD_OPT_THROW_ON_EMPTY', 'throw-on-empty' );
// 2017-06-02 jj5 - throw an exception if input is not the expected datatype...
define( 'MUD_OPT_THROW_ON_DATATYPE', 'throw-on-datatype' );
// 2017-06-02 jj5 - throw an exception if converted value is not not valid
define( 'MUD_OPT_THROW_ON_INVALID_PROSPECT', 'throw-on-invalid-prospect' );

// 2017-06-02 jj5 - the default value to use, if we're using defaults...
// 2017-06-03 jj5 - NOTE: the default value is not validated. This is
// by-design, we assume we know what we're doing... hopefully that doesn't
// turn out to be a very bad idea!
define( 'MUD_OPT_DEFAULT', 'default' );
// 2017-06-03 jj5 - emit a warning if the default value is used...
define( 'MUD_OPT_WARN_ON_DEFAULT', 'warn-on-default' );
// 2017-06-02 jj5 - use the default value there's an issue... if set it enables
// the more specific options...
define( 'MUD_OPT_USE_DEFAULT', 'use-default' );
// 2017-06-02 jj5 - use the default value if input is not already valid
// without conversion.
define( 'MUD_OPT_USE_DEFAULT_ON_INVALID_INPUT', 'use-default-on-invalid-input' );
// 2017-06-02 jj5 - use the default value if input is null...
define( 'MUD_OPT_USE_DEFAULT_ON_NULL', 'use-default-on-null' );
// 2017-06-02 jj5 - use the default value if input is empty...
define( 'MUD_OPT_USE_DEFAULT_ON_EMPTY', 'use-default-on-empty' );
// 2017-06-02 jj5 - use the default value if input is not expected datatype...
define( 'MUD_OPT_USE_DEFAULT_ON_DATATYPE', 'use-default-on-datatype' );
// 2017-06-02 jj5 - use the default value if converted value is not valid
define( 'MUD_OPT_USE_DEFAULT_ON_INVALID_PROSPECT', 'use-default-on-invalid-prospect' );

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2017-06-03 jj5 - options that apply to format_*() only:
//
// 2017-06-03 jj5 - which 'format' to use (at the moment for date/time)...
define( 'MUD_OPT_FORMAT', 'format' );
// 2017-06-03 jj5 - the precision to use for array keys...
define( 'MUD_OPT_KEY_PRECISION', 'key-precision' );
// 2017-06-03 jj5 - the precision to use for array values...
define( 'MUD_OPT_VAL_PRECISION', 'val-precision' );
// 2017-06-03 jj5 - whether to use binary (or decimal) encoding for bytes...
define( 'MUD_OPT_BINARY', 'binary' );
// 2017-06-03 jj5 - what units to use (e.g. for bytes).
define( 'MUD_OPT_UNITS', 'units' );
// 2017-06-03 jj5 - the number of spaces to use for tabs...
define( 'MUD_OPT_SPACES', 'spaces' );
// 2017-06-03 jj5 - whether to convert spaces to &nbsp;
define( 'MUD_OPT_NBSP', 'nbsp' );
// 2017-06-03 jj5 - the delimiter to use to separate array items...
define( 'MUD_OPT_DELIMITER', 'delimiter' );
// 2017-06-03 jj5 - the separator to use between key/val pairs...
define( 'MUD_OPT_SEPARATOR', 'separator' );
// 2017-06-03 jj5 - the padding to use on both sides (applied before PAD_LEFT
// and PAD_RIGHT, you probably don't want all of them!)
define( 'MUD_OPT_PAD', 'pad' );
// 2017-06-03 jj5 - the padding to use on the left (if non-empty)...
define( 'MUD_OPT_PAD_LEFT', 'pad-left' );
// 2017-06-03 jj5 - the padding to use on the right (if non-empty)...
define( 'MUD_OPT_PAD_RIGHT', 'pad-right' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - some data type problems that can happen...
//

// 2017-06-02 jj5 - if no throw and no default type conversion is attempted.
// And if conversion fails we use a global default for the data type.

define( 'MUD_PROBLEM_INVALID_TYPE',     'is invalid type'         );
define( 'MUD_PROBLEM_INVALID_DATATYPE', 'is invalid data type'    );
define( 'MUD_PROBLEM_IS_NULL',          'is null'                 );
define( 'MUD_PROBLEM_IS_EMPTY',         'is empty'                );
define( 'MUD_PROBLEM_IS_FALSE',         'is false'                );
define( 'MUD_PROBLEM_IS_TRUE',          'is true'                 );
define( 'MUD_PROBLEM_IS_ZERO',          'is zero'                 );
define( 'MUD_PROBLEM_IS_NOT_POSITIVE',  'is not positive'         );
define( 'MUD_PROBLEM_IS_NOT_NEGATIVE',  'is not negative'         );
define( 'MUD_PROBLEM_BELOW_MIN',        'is below minimum'        );
define( 'MUD_PROBLEM_ABOVE_MIN',        'is above minimum'        );
define( 'MUD_PROBLEM_VAILD_MISMATCH',   'is not in valid format'  );
define( 'MUD_PROBLEM_INVALID_MATCH',    'is in an invalid format' );

define( 'MUD_WARNING_DEFAULT_USED',     'default value used'      );
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-08-03 jj5 - some constants for the currency facility...
//

define( 'MUD_DEFAULT_CURRENCY', 'AUD' );
