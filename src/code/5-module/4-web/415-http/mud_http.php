<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../400-web/mud_web.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/trait/MudHttpInputNormalization.php';
require_once __DIR__ . '/trait/MudHttpInputValue.php';
require_once __DIR__ . '/class/MudModuleHttp.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-08-24 jj5 - functional interface...
//

function mud_is_http_query() {

  return mud_module_http()->is_http_query();

}

function mud_is_http_submission() {

  return mud_module_http()->is_http_submission();

}

function mud_get_http_verb() {

  return mud_module_http()->get_http_verb();

}

function mud_http_cache_forever() {

  return mud_module_http()->cache_forever();

}

function mud_http_normalize_input(string $value, bool $allow_newlines = false): string {

  return mud_module_http()->normalize_input($value, $allow_newlines);

}

function mud_http_normalize_input_array(array $values, bool $allow_newlines = false): array {

  return mud_module_http()->normalize_input_array($values, $allow_newlines);

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

function mud_http_get_query_bool( string $name, ?bool $default = null ): ?bool {

  return mud_module_http()->get_query_bool($name, $default);

}

function mud_http_get_query_int( string $name, ?int $default = null ): ?int {

  return mud_module_http()->get_query_int($name, $default);

}

function mud_http_get_query_float( string $name, ?float $default = null ): ?float {

  return mud_module_http()->get_query_float($name, $default);

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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_http() : MudModuleHttp {

  return mud_locator()->get_module( MudModuleHttp::class );

}
