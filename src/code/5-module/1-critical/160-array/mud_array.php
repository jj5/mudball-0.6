<?php


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - include dependencies...
//

require_once __DIR__ . '/../155-string/mud_string.php';


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_ARRAY_KEY_IS_INVALID', 'invalid key.' );
mud_define_error( 'MUD_ERR_ARRAY_KEY_IN_INDEX_IS_INVALID', 'invalid key in index.' );
mud_define_error( 'MUD_ERR_ARRAY_INDEX_IS_ZERO_LENGTH', 'zero length array index.' );
mud_define_error( 'MUD_ERR_ARRAY_INDEX_NOT_FOUND', 'array index not found.' );
mud_define_error( 'MUD_ERR_ARRAY_DATA_IS_INVALID', 'invalid data.' );
mud_define_error( 'MUD_ERR_ARRAY_TABLE_ROW_IS_MISSING', 'table row not found.' );
mud_define_error( 'MUD_ERR_ARRAY_TABLE_FIELD_IS_MISSING', 'table field not found.' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/class/MudModuleArray.php';


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - functional interface...
//
//

function mud_get_array( $input, string $delimiter = ' ' ) : array {

  return mud_module_array()->get_array( $input, $delimiter );

}

function mud_add_if_missing( array &$array, $value ) {

  return mud_module_array()->add_if_missing( $array, $value );

}

function mud_last( array $array, $default = null ) {

  return mud_module_array()->last( $array, $default );

}

function mud_read_arg( array &$args, string $arg, $default = null ) {

  return mud_module_array()->read_arg( $args, $arg, $default );

}

function mud_has_key( array $array, $key ) : bool {

  /*
  // 2019-08-05 jj5 - perf hack...
  //
  if ( ! is_array( $key ) && isset( $array[ $key ] ) ) { return true; }
  */

  return mud_module_array()->has_key( $array, $key );

}

function mud_has_field( array $table, int $row, $col ) : bool {

  return mud_module_array()->has_field( $table, $row, $col );

}

function mud_read_ad( array $array, $index, $default = null ) {

  /*
  // 2019-08-05 jj5 - perf hack...
  //
  if ( ! is_array( $index ) && isset( $array[ $index ] ) ) {

    return $array[ $index ];

  }
  */

  return mud_module_array()->read_ad( $array, $index, $default );

}

function mud_read_ar( array $array, $index ) {

  return mud_module_array()->read_ar( $array, $index );

}

function mud_read_td( array $table, int $row, $col, $default = null ) {

  return mud_module_array()->read_td( $table, $row, $col, $default );

}

function mud_read_tr( array $table, int $row, $col ) {

  return mud_module_array()->read_tr( $table, $row, $col );

}

function mud_count_all() : int {

  return mud_module_array()->count_all( func_get_args() );

}


/////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - service locator...
//
//

function mud_module_array() : MudModuleArray {

  return mud_locator()->get_module( MudModuleArray::class );

}
