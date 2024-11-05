<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../150-random/mud_random.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleString.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-04-10 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_STRING_NORMALIZATION_FAILED', 'normalization failed.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-07-14 jj5 - functional interface...
//
//

function mud_utf8_strlen( $input ) {

  return mud_module_string()->utf8_strlen( $input );

}

// 2023-11-04 jj5 - HACK: this is a convenient for compatibility...
//
function henc( $input ) { return mud_henc( $input ); }

function mud_henc( $input ) : string {

  return mud_module_string()->henc( $input );

}

function mud_hfmt( $input ) : string {

  return mud_module_string()->hfmt( $input );

}

function mud_nbsp( $input ) : string {

  return mud_module_string()->nbsp( $input );

}

function mud_slugify( $input, int $ordinal = 1 ) : string {

  return mud_module_string()->slugify( $input, $ordinal );

}

function mud_errname( $input ) : string {

  return mud_module_string()->errname( $input );

}

function mud_varname( $input ) : string {

  return mud_module_string()->varname( $input );

}

function mud_entick( $input ) : string {

  return mud_module_string()->entick( $input );

}

function mud_enpdo( $input ) : string {

  return mud_module_string()->enpdo( $input );

}

function mud_ellipsis( $input, int $max_len = 32 ) : string {

  return mud_module_string()->ellipsis( $input, $max_len );

}

function mud_hash_bin( string $input, string $salt = '' ) : string {

  return mud_module_string()->hash_bin( $input, $salt );

}

function mud_hash( string $input, bool $raw_output = false, string $salt = '' ) : string {

  return mud_module_string()->hash( $input, $raw_output, $salt );

}

function mud_hash_hex( string $input, string $salt = '' ) : string {

  return mud_module_string()->hash_hex( $input, $salt );

}

function mud_hash_file( string $path, bool $raw_output = false ) : string {

  return mud_module_string()->hash_file( $path, $raw_output );

}

function mud_hash_file_bin( string $path ) : string {

  return mud_module_string()->hash_file_bin( $path );

}

function mud_hash_file_hex( string $path ) : string {

  return mud_module_string()->hash_file_hex( $path );

}

function mud_remove_accents( string $string ) : string {

  return mud_module_string()->remove_accents( $string );

}

function mud_strip_control_chars( string $string ) : string {

  return mud_module_string()->strip_control_chars( $string );

}

function mud_normalize_space( string $string ) : string {

  return mud_module_string()->normalize_space( $string );

}

function mud_format( $value ) {

  return mud_module_string()->format( $value );

}

function mud_cell_format( $value ) : string {

  return mud_module_string()->cell_format( $value );

}

function mud_ascii_upper( string $string ) : string {

  return mud_module_string()->ascii_upper( $string );

}

function mud_ascii_lower( string $string ) : string {

  return mud_module_string()->ascii_lower( $string );

}

function mud_asciival( string $input ) : string {

  return mud_module_string()->asciival( $input );

}

function mud_utf8val( string $input ) : string {

  return mud_module_string()->utf8val( $input );

}

function mud_unicode_normalize( $data ) {

  return mud_module_string()->unicode_normalize( $data );

}

function mud_quote( $string ) {

  return mud_module_string()->quote( $string );

}

function mud_escape( $string ) {

  return mud_module_string()->escape( $string );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2019-07-14 jj5 - service locator...
//
//

function mud_module_string() : MudModuleString {

  return mud_locator()->get_module( MudModuleString::class );

}
