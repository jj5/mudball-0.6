<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../400-web/mud_web.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - include components...
//

require_once __DIR__ . '/class/10-MudModuleHttp_Ingress.php';
require_once __DIR__ . '/class/20-MudModuleHttp_IngressNormalization.php';
require_once __DIR__ . '/class/30-MudModuleHttp_IngressHeader.php';
require_once __DIR__ . '/class/40-MudModuleHttp_IngressCookie.php';
require_once __DIR__ . '/class/50-MudModuleHttp_IngressValue.php';
require_once __DIR__ . '/class/60-MudModuleHttp_EgressHeader.php';
require_once __DIR__ . '/class/70-MudModuleHttp_EgressCookie.php';
//require_once __DIR__ . '/class/MudHttpException.php';
require_once __DIR__ . '/class/MudModuleHttp.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - basic HTTP ingress stuff...
//

function mud_http_has_query(string $name): bool {

  return mud_module_http()->has_query($name);

}

function mud_http_has_input(string $name): bool {

  return mud_module_http()->has_input($name);

}

function mud_http_has_server(string $name): bool {

  return mud_module_http()->has_server($name);

}

function mud_http_is_secure() {

  return mud_module_http()->is_secure();

}

function mud_http_is_query() {

  return mud_module_http()->is_query();

}

function mud_http_is_submission() {

  return mud_module_http()->is_submission();

}

function mud_http_get_verb() {

  return mud_module_http()->get_verb();

}

function mud_http_get_raw_input() {

  return mud_module_http()->get_raw_input();

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - ingress normalization...
//

function mud_http_normalize_string(string $value, bool $allow_newlines = false): string {

  return mud_module_http()->normalize_string($value, $allow_newlines);

}

function mud_http_normalize_array(array $values, bool $allow_newlines = false): array {

  return mud_module_http()->normalize_array($values, $allow_newlines);

}

function mud_http_get_query(string $name, ?string $default = null, bool $allow_newlines = false): ?string {

  return mud_module_http()->get_query($name, $default, $allow_newlines);

}

function mud_http_get_query_array(string $name, ?array $default = null, bool $allow_newlines = false): ?array {

  return mud_module_http()->get_query_array($name, $default, $allow_newlines);

}

function mud_http_get_input(string $name, ?string $default = null, bool $allow_newlines = false): ?string {

  return mud_module_http()->get_input($name, $default, $allow_newlines);

}

function mud_http_get_input_array(string $name, ?array $default = null, bool $allow_newlines = false): ?array {

  return mud_module_http()->get_input_array($name, $default, $allow_newlines);

}

function mud_http_get_server(string $name, ?string $default = null, bool $allow_newlines = false): ?string {

  return mud_module_http()->get_server($name, $default, $allow_newlines);

}

function mud_http_get_server_array(string $name, ?array $default = null, bool $allow_newlines = false): ?array {

  return mud_module_http()->get_server_array($name, $default, $allow_newlines);

}

function mud_http_get_query_bool( string $name, ?bool $default = null ): ?bool {

  return mud_module_http()->get_query_bool($name, $default);

}

function mud_http_get_query_int( string $name, ?int $default = null ): ?int {

  return mud_module_http()->get_query_int($name, $default);

}

function mud_http_get_query_float( string $name, ?float $default = null ): ?float {

  return mud_module_http()->get_query_float($name, $default);

}

function mud_http_get_query_safe( string $name, string $pattern, ?string $default = null, bool $allow_newlines = false ): ?string {

  return mud_module_http()->get_query_safe($name, $pattern, $default, $allow_newlines);

}

function mud_http_get_input_bool( string $name, ?bool $default = null ): ?bool {

  return mud_module_http()->get_input_bool($name, $default);

}

function mud_http_get_input_int( string $name, ?int $default = null ): ?int {

  return mud_module_http()->get_input_int($name, $default);

}

function mud_http_get_input_float( string $name, ?float $default = null ): ?float {

  return mud_module_http()->get_input_float($name, $default);

}

function mud_http_get_input_safe( string $name, string $pattern, ?string $default = null, bool $allow_newlines = false ): ?string {

  return mud_module_http()->get_input_safe($name, $pattern, $default, $allow_newlines);

}

function mud_http_get_server_bool( string $name, ?bool $default = null ): ?bool {

  return mud_module_http()->get_server_bool($name, $default);

}

function mud_http_get_server_int( string $name, ?int $default = null ): ?int {

  return mud_module_http()->get_server_int($name, $default);

}

function mud_http_get_server_float( string $name, ?float $default = null ): ?float {

  return mud_module_http()->get_server_float($name, $default);

}

function mud_http_get_server_safe( string $name, string $pattern, ?string $default = null, bool $allow_newlines = false ): ?string {

  return mud_module_http()->get_server_safe($name, $pattern, $default, $allow_newlines);

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - caching stuff...
//

function mud_http_cache_forever() {

  return mud_module_http()->cache_forever();

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - egress headers...
//

function mud_http_unset_redirect( string $name ) {

  return mud_module_http()->unset_redirect( func_get_args() );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - egress headers...
//

function mud_new_http_exception( int $code ) : MudHttpException {

  return mud_factory()->create_object( MudHttpException::class, [ $code ] );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_http() : MudModuleHttp {

  return mud_locator()->get_module( MudModuleHttp::class );

}
