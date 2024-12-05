<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../115-error/mud_error.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleExit.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_EXIT_NAME_IS_REQUIRED', 'exit name is required.' );
mud_define_error( 'MUD_ERR_EXIT_NAME_IS_DUPLICATE', 'duplicate exit name.' );
mud_define_error(
  'MUD_ERR_EXIT_LIMIT_EXCEEDED',
  'too many exit error levels have been defined.',
  'you may need to talk to the package maintainer about this.'
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - process error levels...
//

mud_define_exit( 'MUD_EXIT_SUCCESS',                0, 'success',           'success!' );
mud_define_exit( 'MUD_EXIT_CANNOT_CONTINUE',       10, 'logic exit',        'cannot continue; but nothing is abnormal or wrong',                                                'consider EXIT_SPECIAL_SUCCESS' );
mud_define_exit( 'MUD_EXIT_BAD_DATA',              20, 'input error',       'there was a problem with inputs' );
mud_define_exit( 'MUD_EXIT_BAD_FORMAT',            21, 'input error',       'data was in an invalid format' );
mud_define_exit( 'MUD_EXIT_BAD_VALUE',             22, 'input error',       'data nominated an invalid value (but was in correct format)' );
mud_define_exit( 'MUD_EXIT_BAD_COMMAND',           30, 'user error',        'invalid command-line or options' );
mud_define_exit( 'MUD_EXIT_NO_FILE',               31, 'user error',        'a required file/directory path not nominated' );
mud_define_exit( 'MUD_EXIT_WRONG_FILE',            32, 'user error',        'user nominated file (or directory) missing; use EXIT_FILE_MISSING for system files' );
mud_define_exit( 'MUD_EXIT_BAD_FILE',              33, 'user error',        'user nominated file (or directory) cannot be accessed due to invalid permissions',                 'use EXIT_NO_ACCESS for system files' );
mud_define_exit( 'MUD_EXIT_USER_CANCEL',           34, 'user error',        'user canceled' );
mud_define_exit( 'MUD_EXIT_BAD_ENVIRONMENT',       40, 'environment error', 'invalid run-time environment; cannot run' );
mud_define_exit( 'MUD_EXIT_FILE_MISSING',          41, 'environment error', 'a file (or directory) that is expected to always be available is not available',                   'use EXIT_WRONG_FILE for user nominated files' );
mud_define_exit( 'MUD_EXIT_NO_ACCESS',             42, 'environment error', 'a file (or directory) that should be accessible cannot be accessed due to invalid permissions',    'use EXIT_BAD_FILE for user nominated files' );
mud_define_exit( 'MUD_EXIT_BAD_CONFIG',            43, 'environment error', 'invalid configuration; config file missing or invalid' );
mud_define_exit( 'MUD_EXIT_NO_LOCK',               44, 'environment error', 'could not acquire lock' );
mud_define_exit( 'MUD_EXIT_NO_SERVICE',            56, 'environment error', 'cannot establish connection to a required service',                                                'prefer EXIT_NO_DATABASE for database services' );
mud_define_exit( 'MUD_EXIT_NO_DATABASE',           57, 'environment error', 'cannot establish connection to a required database' );
mud_define_exit( 'MUD_EXIT_EXHAUSTED',             58, 'environment error', 'resources exhausted; out of memory, disk space, inodes, etc' );
mud_define_exit( 'MUD_EXIT_OFFLINE',               59, 'environment error', 'system offline; as configured by administrator' );
mud_define_exit( 'MUD_EXIT_BAD_PROGRAM',           70, 'program error',     'an unhandled and fatal situation encountered' );
mud_define_exit( 'MUD_EXIT_ERROR',                 71, 'program error',     'an error caused process termination' );
mud_define_exit( 'MUD_EXIT_EXCEPTION',             72, 'program error',     'an unhandled exception caused process termination' );
mud_define_exit( 'MUD_EXIT_ASSERT',                73, 'program error',     'an assertion violation caused process termination' );
mud_define_exit( 'MUD_EXIT_TEST_FAILED',           74, 'program error',     'test failed; unit-test did not succeed' );
mud_define_exit( 'MUD_EXIT_INVALID',               75, 'program error',     'invalid error level; the programmer nominated an invalid error level and the host exited with 85 instead' );
mud_define_exit( 'MUD_EXIT_NOT_IMPLEMENTED',       80, 'program error',     'functionality not implemented' );
mud_define_exit( 'MUD_EXIT_NOT_SUPPORTED',         81, 'program error',     'situation not supported' );
mud_define_exit( 'MUD_EXIT_NOT_POSSIBLE',          82, 'program error',     'situation is supposed to be impossible' );
mud_define_exit( 'MUD_EXIT_DEBUG',                 88, 'program error',     'programmer exited for debugging purposes' );
mud_define_exit( 'MUD_EXIT_ABORT',                 89, 'program error',     'programmer aborted with error message' );
mud_define_exit( 'MUD_EXIT_SPECIAL_SUCCESS',       90, 'special purpose',   'special operation successful; used for safety (in case improperly invoked)' );
mud_define_exit( 'MUD_EXIT_OPTIONS_LISTED',        98, 'special purpose',   'program options listed; use when programs can be invoked to list their options in a machine readable format' );
mud_define_exit( 'MUD_EXIT_HELP',                  99, 'special purpose',   'help or version number requested ' );
mud_define_exit( 'MUD_EXIT_UNIX_BAD_PERMISSION',  126, 'UNIX error',        'command was found but could not be executed due to permissions' );
mud_define_exit( 'MUD_EXIT_UNIX_BAD_COMMAND',     127, 'UNIX error',        'command not found or could not be executed' );
mud_define_exit( 'MUD_EXIT_TERMINATED_BY_SIGNAL', 128, 'UNIX error',        'process terminated by signal' );
mud_define_exit( 'MUD_EXIT_TERMINATED_BY_CTRLC',  130, 'UNIX error',        'process terminated by Ctrl+C' );
mud_define_exit( 'MUD_EXIT_GENERIC_1',              1, 'general error',     'error during processing' );
mud_define_exit( 'MUD_EXIT_GENERIC_2',              2, 'general error',     'error during processing' );
mud_define_exit( 'MUD_EXIT_GENERIC_255',          255, 'general error',     'error during processing' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//

function mud_define_exit( string $name, int $code, string $category, string $description, string|null $hint = null ) : void {

  mud_module_exit()->define_exit( $name, $code, $category, $description, $hint );

}

function mud_abort( string $message ) {

  mud_module_exit()->abort( $message );

  assert( false );

}

function mud_exit( $code_or_name ) {

  mud_module_exit()->exit( $code_or_name );

  assert( false );

}

function mud_get_exit_error_level() {

  return mud_module_exit()->get_exit_error_level();

}

function mud_exit_get_code( $code_or_name ) {

  return mud_module_exit()->get_code( $code_or_name );

}

function mud_exit_get_name( $code_or_name ) {

  return mud_module_exit()->get_name( $code_or_name );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - service locator...
//

function mud_module_exit() : MudModuleExit {

  return mud_locator()->get_module( MudModuleExit::class );

}
