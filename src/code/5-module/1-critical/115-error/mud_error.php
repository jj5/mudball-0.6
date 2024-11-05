<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../110-environment/mud_environment.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

//
// 2022-02-23 jj5 - NOTE: because this is the error module we must load our components before
// we define our module errors.
//

require_once __DIR__ . '/class/MudModuleError.php';
require_once __DIR__ . '/class/MudException.php';

// 2022-02-21 jj5 - the error module and the exit module are symbiotic...
//
require_once __DIR__ . '/../115-exit/mud_exit.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_GENERAL', 'an error occurred.' );
mud_define_error( 'MUD_ERR_NOT_IMPLEMENTED', 'functionality not implemented.' );
mud_define_error( 'MUD_ERR_NOT_SUPPORTED', 'situation not supported.' );
mud_define_error( 'MUD_ERR_NOT_POSSIBLE', 'situation not possible.' );
mud_define_error( 'MUD_ERR_REQUIREMENT_VIOLATED', 'requirement violated.' );

mud_define_error( 'MUD_ERR_ERROR_NAME_IS_REQUIRED', 'error name is required.' );
mud_define_error( 'MUD_ERR_ERROR_NAME_IS_DUPLICATE', 'duplicate error name.' );
mud_define_error(
  'MUD_ERR_ERROR_LIMIT_EXCEEDED',
  'too many errors have been defined in this scope.',
  'you may need to talk to the package maintainer to increase the tranche size.'
);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_exception(
  string $message,
  int $code,
  Throwable|null $previous,
  string $name,
  string $hint,
  mixed $data
)
: MudException {

  return mud_module_error()->new_mud_exception( $message, $code, $previous, $name, $hint, $data );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//

function mud_get_error_text( int $code ) : string { return mud_module_error()->get_error_text( $code ); }

function mud_get_error_name( int $code ) : string { return mud_module_error()->get_error_name( $code ); }

function mud_get_error_hint( int $code ) : string { return mud_module_error()->get_error_hint( $code ); }

function mud_define_error(
  string $name,
  string $text,
  string $hint = '',
  string $scope = MUDBALL_CODE
) {

  return mud_module_error()->define_error( $name, $text, $hint, $scope );

}

function mud_fail(
  int|string $code_or_message,
  mixed $data = null,
  Throwable|null $previous = null,
  int|null &$code = null,
  string|null &$name = null,
  string|null &$message = null,
  string|null &$hint = null
) {

  return mud_module_error()->fail(
    $code_or_message,
    $data,
    $previous,
    $code,
    $name,
    $message,
    $hint
  );

}

function mud_not_implemented( mixed $data = null ) : MudException {

  return mud_module_error()->not_implemented( $data );

}

function mud_not_supported( mixed $data = null ) : MudException {

  return mud_module_error()->not_supported( $data );

}

function mud_not_possible( mixed $data = null ) : MudException {

  return mud_module_error()->not_possible( $data );

}

// 2019-11-10 jj5 - this function makes a best-efforts endeavour to remove
// secret/sensitive info, for use prior to logging...
//
function mud_redact_secrets(
  mixed $input,
  array $whitelist = [],
  array $blacklist = []
)
: mixed {

  return mud_module_error()->redact_secrets( $input, $whitelist, $blacklist );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - service locator...
//

function mud_module_error() : MudModuleError {

  return mud_locator()->get_module( MudModuleError::class );

}
