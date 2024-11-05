<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../125-io/mud_io.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_RETRY_LIMIT_EXCEEDED', 'retry limit exceeded.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleRetry.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - functional interface...
//
//

function mud_retry(
  callable $fn,
  array $args = [],
  int $try_count = MUD_DEFAULT_TRY_COUNT,
  int $try_delay = MUD_DEFAULT_TRY_DELAY
) {

  return mud_module_retry()->retry( $fn, $args, $try_count, $try_delay );

}

function mud_ensure(
  callable $fn,
  array $args = [],
  int $try_count = MUD_DEFAULT_TRY_COUNT,
  int $try_delay = MUD_DEFAULT_TRY_DELAY
) {

  return mud_module_retry()->ensure( $fn, $args, $try_count, $try_delay );

}


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_retry() : MudModuleRetry {

  return mud_locator()->get_module( MudModuleRetry::class );

}
