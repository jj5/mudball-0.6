<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - include dependencies...
//

require_once __DIR__ . '/../125-buffer/mud_buffer.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - include components...
//

require_once __DIR__ . '/trait/MudMixinFilesystemCommon.php';
require_once __DIR__ . '/trait/MudMixinFilesystemProtected.php';
require_once __DIR__ . '/trait/MudMixinFilesystemPublic.php';
require_once __DIR__ . '/class/MudModuleFilesystem.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_FILESYSTEM_ATTEMPT_FAILED', 'an error occurred while attempting a file-system operation.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - constants...
//

define( 'MUD_FILESYSTEM_ATTEMPT_LIMIT', 10 );
define( 'MUD_FILESYSTEM_ATTEMPT_DELAY', 500_000 );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - service locator...
//
//

function mud_module_filesystem() : MudModuleFilesystem {

  return mud_locator()->get_module( MudModuleFilesystem::class );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-16 jj5 - functional interface...
//
//

function mud_fopen( string $path, string $mode ) {

  return mud_module_filesystem()->fopen( $path, $mode );

}

function mud_flock( $handle, int $operation ) {

  return mud_module_filesystem()->flock( $handle, $operation );

}

function mud_stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) {

  return mud_module_filesystem()->stream_get_contents( $handle, $length, $offset );

}

function mud_ftruncate( $handle, int $size ) {

  return mud_module_filesystem()->ftruncate( $handle, $size );

}

function mud_rewind( $handle ) {

  return mud_module_filesystem()->rewind( $handle );

}

function mud_fwrite( $handle, string $data, ?int $length = null ) {

  return mud_module_filesystem()->fwrite( $handle, $data, $length );

}

function mud_fflush( $handle ) {

  return mud_module_filesystem()->fflush( $handle );

}

function mud_fclose( $handle ) {

  return mud_module_filesystem()->fclose( $handle );

}
