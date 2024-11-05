<?php


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - include dependencies...
//

require_once __DIR__ . '/../130-retry/mud_retry.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleFile.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-04-11 jj5 - functional interface...
//
//

function mud_touch( $filename, $time = null, $atime = null ) {

  return mud_module_file()->touch( $filename, $time, $atime );

}

function mud_unlink( $filename, $context = null ) {

  return mud_module_file()->unlink( $filename, $context );

}

function mud_chown( $filename, $user, $group = null ) {

  return mud_module_file()->chown( $filename, $user, $group );

}

function mud_chgrp( $filename, $group ) {

  return mud_module_file()->chgrp( $filename, $group );

}

function mud_chmod( $filename, $permissions ) {

  return mud_module_file()->chmod( $filename, $permissions );

}

function mud_get_file_list( $dir, $filename_filter_regex = '/.+/' ) {

  return mud_module_file()->get_file_list( $dir, $filename_filter_regex );

}


/////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_file() : MudModuleFile {

  return mud_locator()->get_module( MudModuleFile::class );

}
