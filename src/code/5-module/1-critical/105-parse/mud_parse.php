<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - include dependencies...
//

require_once __DIR__ . '/../100-critical/mud_critical.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleParse.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - functional interface...
//

function mud_parse_bool(string $value): bool {

  return mud_module_parse()->parse_bool($value);

}

function mud_parse_int(string $value): int {

  return mud_module_parse()->parse_int($value);

}

function mud_parse_float(string $value): float {

  return mud_module_parse()->parse_float($value);

}

function mud_parse_try_bool(string $value, ?bool &$result, ?bool $default = null): bool {

  return mud_module_parse()->try_bool($value, $result, $default);

}

function mud_parse_try_int(string $value, ?int &$result, ?int $default = null): bool {

  return mud_module_parse()->try_int($value, $result, $default);

}

function mud_parse_try_float(string $value, ?float &$result, ?float $default = null): bool {

  return mud_module_parse()->try_float($value, $result, $default);

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-10-24 jj5 - service locator...
//

function mud_module_parse( MudModuleParse|false $set = false ) : MudModuleParse {

  return mud_locator()->manage_module( MudModuleParse::class, $set );

}
