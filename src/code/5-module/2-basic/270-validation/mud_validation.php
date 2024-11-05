<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../265-ensure/mud_ensure.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_VALIDATION_URL_SCHEME_SPEC_IS_INVALID', 'invalid scheme requirements.' );
mud_define_error( 'MUD_ERR_VALIDATION_URL_HOST_SPEC_IS_INVALID', 'invalid host requirements.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleValidation.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-11-12 jj5 - functional interface...
//
//

function mud_is_valid_url(
  string $url,
  &$problem = null,
  bool $required = true,
  $require_scheme = [ 'https', 'http' ],
  $require_host = true
) {

  return mud_module_validation()->is_valid_url(
    $url,
    $problem,
    $required,
    $require_scheme,
    $require_host
  );

}

function mud_is_valid_email_address(
  string $email_address,
  &$problem = null,
  bool $required = true
) {

  return mud_module_validation()->is_valid_email_address(
    $email_address,
    $problem,
    $required
  );

}

function mud_is_valid_username(
  string $username,
  &$problem = null,
  bool $required = true
) {

  return mud_module_validation()->is_valid_username(
    $username,
    $problem,
    $required
  );

}

function mud_is_trimmed(
  string $value,
  &$problem = null
) {

  return mud_module_validation()->is_trimmed( $value, $problem );

}

function mud_is_ascii_structure(
  string $value,
  &$problem = null
) {

  return mud_module_validation()->is_ascii_structure( $value, $problem );

}

function mud_is_ascii_printable(
  string $value,
  &$problem = null
) {

  return mud_module_validation()->is_ascii_printable( $value, $problem );

}

function mud_is_ascii(
  string $value,
  &$problem = null
) {

  return mud_module_validation()->is_ascii( $value, $problem );

}

function mud_is_utf8(
  string $value,
  &$problem = null
) {

  return mud_module_validation()->is_utf8( $value, $problem );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_validation() : MudModuleValidation {

  return mud_locator()->get_module( MudModuleValidation::class );

}
