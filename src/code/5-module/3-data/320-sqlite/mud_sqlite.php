<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - include dependencies...
//

require_once __DIR__ . '/../315-connection/mud_connection.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_SQLITE_CANNOT_CREATE_PDO', 'cannot create PDO object.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleSqlite.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-12 jj5 - functional interface...
//

function mud_sqlite_create_pdo( $path, $fetch_mode = PDO::FETCH_NUM, $opt = [] ) {

  return mud_module_sqlite()->create_pdo( $path, $fetch_mode, $opt );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_sqlite() : MudModuleSqlite {

  return mud_locator()->get_module( MudModuleSqlite::class );

}
