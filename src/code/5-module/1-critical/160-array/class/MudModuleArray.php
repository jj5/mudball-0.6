<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleArray extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function get_array( $input, string $delimiter = ' ' ) : array {

    if ( is_array( $input ) ) { return $input; }

    return explode( $delimiter, $input );

  }

  public function add_if_missing( array &$array, $value ) {

    if ( ! in_array( $value, $array, $strict = true ) ) { $array[] = $value; }

  }

  public function last( array $array, $default = null ) {

    $count = count( $array );

    if ( $count === 0 ) { return $default; }

    $index = $count - 1;

    if ( array_key_exists( $index, $array ) ) { return $array[ $index ]; }

    $values = array_values( $array );

    return end( $values );

  }

  public function read_arg( array &$args, string $arg, $default = null ) {

    $value = $args[ $arg ] ?? $default;

    $args[ $arg ] = $value;

    return $value;

  }

  public function has_key( array $array, $key ) : bool {

    if ( ! is_array( $key ) ) { return array_key_exists( $key, $array ); }

    $part = $array;

    foreach ( $key as $key ) {

      if ( is_array( $key ) || is_object( $key ) ) {

        mud_fail( MUD_ERR_ARRAY_KEY_IS_INVALID, [ 'index' => $key, 'key' => $key ] );

      }

      if ( ! is_array( $part ) ) { return false; }

      if ( ! mud_has_key( $part, $key ) ) { return false; }

      $part = $part[ $key ];

    }

    return true;

  }

  public function has_field( array $table, int $row, $col ) : bool {

    // 2018-06-18 jj5 - THINK: maybe this would be faster..? Should
    // benchmark...
    //return mud_has_key( $table, [ $row, $col ] );

    return
      mud_has_key( $table, $row ) &&
      mud_has_key( $table[ $row ], $col );

  }

  // 2019-08-06 jj5 - this is an improved version of read_ad() which uses
  // the PHP 7 null coalescing operator in the hope of increasing
  // performance...
  //
  public function read_ad( array $array, $index, $default = null ) {

    if ( ! is_array( $index ) ) {

      return $array[ $index ] ?? $default;

    }

    switch ( count( $index ) ) {

      case 0 :

        // 2019-08-06 jj5 - there is an argument to be made that in this case
        // we should just return the $array. We might do that if there is
        // ever a use case for it.

        mud_fail(
          MUD_ERR_ARRAY_INDEX_IS_ZERO_LENGTH,
          [
            'array' => $array,
            'index' => $index,
            'default' => $default,
          ]
        );

      case 1 :

        list( $a ) = $index;

        return $array[ $a ] ?? $default;

      case 2 :

        list( $a, $b ) = $index;

        return $array[ $a ][ $b ] ?? $default;

      case 3 :

        list( $a, $b, $c ) = $index;

        return $array[ $a ][ $b ][ $c ] ?? $default;

      case 4 :

        list( $a, $b, $c, $d ) = $index;

        return $array[ $a ][ $b ][ $c ][ $d ] ?? $default;

      default :

        // 2019-08-06 jj5 - this is unlikely to ever happen, but if it does
        // we can fall back on the old implementation...
        //
        return $this->read_ad_old( $array, $index, $default );

    }
  }

  public function read_ad_old( array $array, array $index, $default = null ) {

    // 2019-08-06 jj5 - this part of the old implementation is redundant now...
    // Accordingly the $index argument is typed as 'array' now to be sure.
    //
    /*
    if ( ! is_array( $index ) ) {

      // 2019-08-05 jj5 - perf hack...
      //
      if ( isset( $array[ $index ] ) ) { return $array[ $index ]; }

      if ( mud_has_key( $array, $index ) ) { return $array[ $index ]; }

      return $default;

    }
    */

    $part = $array;

    foreach ( $index as $key ) {

      if (
        $key === null ||
        is_bool( $key ) ||
        is_array( $key ) ||
        is_object( $key )
      ) {

        mud_fail(
          MUD_ERR_ARRAY_KEY_IN_INDEX_IS_INVALID,
          [
            'key' => $key,
            'index' => $index,
            'array' => $array,
            'default' => $default,
          ]
        );

      }

      if ( ! is_array( $part ) ) {

        return $default;

      }

      if ( ! mud_has_key( $part, $key ) ) { return $default; }

      $part = $part[ $key ];

    }

    return $part;

  }

  public function read_ar( array $array, $index ) {

    if ( ! is_array( $index ) ) {

      if ( mud_has_key( $array, $index ) ) { return $array[ $index ]; }

      mud_fail(
        MUD_ERR_ARRAY_INDEX_NOT_FOUND,
        [ 'index' => $index, 'array' => $array ]
      );

    }

    $part = $array;

    foreach ( $index as $key ) {

      if (
        $key === null ||
        is_bool( $key ) ||
        is_array( $key ) ||
        is_object( $key )
      ) {

        mud_fail(
          MUD_ERR_ARRAY_KEY_IN_INDEX_IS_INVALID,
          [ 'index' => $index, 'array' => $array, 'default' => $default ]
        );

      }

      if ( ! is_array( $part ) ) {

        mud_fail(
          MUD_ERR_ARRAY_DATA_IS_INVALID,
          [ 'index' => $index, 'array' => $array ]
        );

      }

      if ( ! mud_has_key( $part, $key ) ) {

        mud_fail(
          MUD_ERR_ARRAY_INDEX_NOT_FOUND,
          [ 'index' => $index, 'array' => $array ]
        );

      }

      $part = $part[ $key ];

    }

    return $part;

  }

  public function read_td( array $table, int $row, $col, $default = null ) {

    // 2019-08-06 jj5 - this was improved by using the null coalescing
    // operator...
    //
    return $table[ $row ][ $col ] ?? $default;

    /*
    if ( mud_has_field( $table, $row, $col ) ) {

      return $table[ $row ][ $col ];

    }

    return $default;
    */

  }

  public function read_tr( array $table, int $row, $col ) {

    if ( ! mud_has_key( $table, $row ) ) {

      mud_fail(
        MUD_ERR_ARRAY_TABLE_ROW_IS_MISSING,
        [ 'row' => $row, 'col' => $col, 'table' => $table ]
      );

    }

    if ( ! mud_has_key( $table[ $row ], $col ) ) {

      mud_fail(
        MUD_ERR_ARRAY_TABLE_FIELD_IS_MISSING,
        [ 'row' => $row, 'col' => $col, 'table' => $table ]
      );

    }

    return $table[ $row ][ $col ];

  }

  public function count_all( array $list_of_lists ) : int {

    $result = 0;

    foreach ( $list_of_lists as $list ) { $result += count( $list ); }

    return $result;

  }
}
