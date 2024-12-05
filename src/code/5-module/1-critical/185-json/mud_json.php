<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-27 jj5 - include dependencies...
//

require_once __DIR__ . '/../180-compression/mud_compression.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-04 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_JSON_ENCODING_ERROR', 'JSON encoding error.' );
mud_define_error( 'MUD_ERR_JSON_DECODING_ERROR', 'JSON decoding error.' );
mud_define_error( 'MUD_ERR_JSON_GZDEFLATE_ERROR', 'Error in gzdeflate.' );
mud_define_error( 'MUD_ERR_JSON_GZINFLATE_ERROR', 'Error in gzinflate.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleJson.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-02-24 jj5 - functional interface...
//
//

function mud_json_canonical( $data ) : string {

  return mud_module_json()->json_canonical( $data );

}

function mud_json_pretty( $data, int $opts = 0 ) : string {

  return mud_module_json()->json_pretty( $data, $opts );

}

function mud_json_compact( $data, int $opts = 0 ) : string {

  return mud_module_json()->json_compact( $data, $opts );

}

function mud_json_ascii( $data, int $opts = 0 ) : string {

  return mud_module_json()->json_ascii( $data, $opts );

}

function mud_json_embed( $data, int $opts = 0 ) : string {

  return mud_module_json()->json_embed( $data, $opts );

}

function mud_json_decode( string $json, $ignore_error = false, $default = null ) {

  return mud_module_json()->json_decode( $json, $ignore_error, $default );

}

function mud_jzon_encode( $data, &$json = null, int $level = 9, $redact = false ) {

  return mud_module_json()->jzon_encode( $data, $json, $level, $redact );

}

function mud_jzon_decode( string $jzon ) {

  return mud_module_json()->jzon_decode( $jzon );

}

function mud_json_gzip_encode( $data, int $level = 9 ) {

  return mud_module_json()->json_gzip_encode( $data, $level );

}

function mud_json_gzip_decode( string $blob ) {

  return mud_module_json()->json_gzip_decode( $blob );

}

function mud_json_gzip_decode_pretty( string $blob, &$json = null ) {

  return mud_module_json()->json_gzip_decode_pretty( $blob, $json );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2018-06-17 jj5 - service locator...
//
//

function mud_module_json() : MudModuleJson {

  return mud_locator()->get_module( MudModuleJson::class );

}
