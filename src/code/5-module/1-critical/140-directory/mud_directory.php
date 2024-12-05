<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../135-file/mud_file.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleDirectory.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - define errors...
//

mud_define_error( 'MUD_ERR_DIRECTORY_IS_INVALID', 'invalid directory.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - functional interface...
//
//

function mud_mkdir( $pathname, $mode = 0777, $recursive = false, $context = null ) {

  return mud_module_directory()->mkdir( $pathname, $mode, $recursive, $context );

}

function mud_rmdir( $dir ) {

  return mud_module_directory()->rmdir( $dir );

}

function mud_is_dir( string $dir ) : bool {

  return mud_module_directory()->is_dir( $dir );

}

function mud_is_dir_empty( $dir ) {

  return mud_module_directory()->is_dir_empty( $dir );

}

function mud_pushd( $dir ) {

  return mud_module_directory()->pushd( $dir );

}

function mud_popd() {

  return mud_module_directory()->popd();

}

function mud_chdir( $dir ) {

  return mud_module_directory()->chdir( $dir );

}

function mud_getcwd() {

  return mud_module_directory()->getcwd();

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_directory() : MudModuleDirectory {

  return mud_locator()->get_module( MudModuleDirectory::class );

}
