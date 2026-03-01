<?php

class MudSchemaColDef extends MudGadget {

  public $file_info;

  public $file;
  public $line;

  public $col_name;
  public $col_type;

  public $is_key;
  public $is_vrt;
  public $is_ref;
  public $is_flg;
  public $is_dup;

  public $is_unique;
  public $is_fk;

  public $min;
  public $max;
  public $nullable;
  public $default;
  public $valid;
  public $invalid;

  public $ref_tab_name;
  public $ref_col_name;

  public $flag;
  public $is_interaction_id;

  public function __construct(
    $file_info,
    $file,
    $line,
    $col_name,
    $col_type,
    $is_key,
    $is_vrt,
    $is_ref,
    $is_flg,
    $is_dup,
    $is_unique,
    $is_fk,
    $min,
    $max,
    $nullable,
    $default,
    $valid,
    $invalid,
    $ref_tab_name,
    $ref_col_name,
    $flag,
    $is_interaction_id,
  ) {

    parent::__construct();

    $this->file_info = $file_info;

    $this->file = $file;
    $this->line = $line;

    $this->col_name = $col_name;
    $this->col_type = $col_type;

    $this->is_key = $is_key;
    $this->is_vrt = $is_vrt;
    $this->is_ref = $is_ref;
    $this->is_flg = $is_flg;
    $this->is_dup = $is_dup;

    $this->is_unique = $is_unique;
    $this->is_fk = $is_fk;

    $this->min = $min;
    $this->max = $max;
    $this->nullable = $nullable;
    $this->default = $default;
    $this->valid = $valid;
    $this->invalid = $invalid;

    $this->ref_tab_name = $ref_tab_name;
    $this->ref_col_name = $ref_col_name;

    $this->flag = $flag;
    $this->is_interaction_id = $is_interaction_id;

  }

  public function get_name() { return $this->col_name; }
  public function get_type() { return $this->col_type; }

  public function get_col_name() { return $this->col_name; }
  public function get_col_type() { return $this->col_type; }

  public function is_key() { return $this->is_key; }
  public function is_vrt() { return $this->is_vrt; }
  public function is_ref() { return $this->is_ref; }
  public function is_flg() { return $this->is_flg; }
  public function is_dup() { return $this->is_dup; }

  public function get_ref_tab_name() { return $this->ref_tab_name; }
  public function get_ref_col_name() { return $this->ref_col_name; }

  public function create_col( $tab ) {

    $schemata = $tab->schemata;

    $info = $this->file_info;

    $schema = $info[ 'schema' ];
    $revision = $info[ 'revision' ];
    $revision_number = $info[ 'revision_number' ];
    $revision_file = MudSchemata::GetRelativePath( $info[ 'path' ] );
    $file = MudSchemata::GetRelativePath( $this->file );

    $ref_col = null;

    if ( $this->ref_tab_name || $this->ref_col_name ) {

      if ( ! array_key_exists( $this->ref_tab_name, $schemata->tab_map ) ) {

        // 2022-02-24 jj5 - TEMP: still thinking about this...

        $ref_col = null;

      }
      else {

        $ref_col = $schemata->tab_map[ $this->ref_tab_name ]->col_map[ $this->ref_col_name ];

      }
    }

    $col = new_mud_schema_col(
      $schemata,
      $tab,
      $schema,
      $revision,
      $revision_number,
      $revision_file,
      $file,
      $this->line,
      $this->col_name,
      $this->col_type,
      $this->is_key,
      $this->is_vrt,
      $this->is_ref,
      $this->is_flg,
      $this->is_dup,
      $this->is_unique,
      $this->is_fk,
      $this->min,
      $this->max,
      $this->nullable,
      $this->default,
      $this->valid,
      $this->invalid,
      $this->ref_tab_name,
      $this->ref_col_name,
      $ref_col,
      $this->flag,
      $this->get_db_datatype(),
      $this->get_app_datatype(),
      $this->get_prop( $tab ),
      $this->get_const(),
      $this->get_cast_function(),
      $this->is_ascii(),
      $this->is_unicode(),
      $this->is_binary(),
      $this->get_string_type(),
      $this->is_interaction_id(),
      $this->is_auto_inc(),
      $this->is_auto(),
      $this->get_classes(),
      $this->get_human_name()
    );

    if ( array_key_exists( $col->get_name(), $tab->col_map ) ) {

      mud_fail( MUD_ERR_SCHEMADEF_DUPLICATE_COLUMN, [ 'col_name' => $col->get_name() ] );

    }

    $tab->col_map[ $col->get_name() ] = $col;

    if ( ! array_key_exists( $col->get_name(), $schemata->col_map ) ) {

      $schemata->col_map[ $col->get_name() ] = $col;

    }

    return $col;

  }

  public function get_db_datatype() {

    /*
    if ( $this->get_name() === 'a_std_auth_event_char' ) {

      var_dump( $this->get_col_type() ); exit;

    }
    */

    switch ( $this->get_col_type() ) {

      case DBT_BOOL : return MUD_DATATYPE_INT;

      // 2019-10-16 jj5 - unsigned integers for IDs (auto-increment)...
      //
      case DBT_ID8  :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 : return MUD_DATATYPE_INT;

      // 2019-09-22 jj5 - unsigned integers...
      //
      case DBT_UINT8  :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 : return MUD_DATATYPE_INT;

      // 2019-09-22 jj5 - signed integers...
      //
      case DBT_INT8  :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 : return MUD_DATATYPE_INT;

      // 2019-10-20 jj5 - floats...
      //
      case DBT_SINGLE :
      case DBT_DOUBLE : return MUD_DATATYPE_FLOAT;

      // 2019-09-22 jj5 - datetimes...
      //
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON : return MUD_DATATYPE_STRING;

      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME     : return MUD_DATATYPE_STRING;

      case DBT_TIMEZONE : return MUD_DATATYPE_STRING;


      // 2019-11-06 jj5 - sha512/224 hashes in various formats...
      //
      case DBT_HASH_HEX : return MUD_DATATYPE_STRING;
      case DBT_HASH_BIN : return MUD_DATATYPE_STRING;

      // 2019-11-06 jj5 - tokens are 32 char alphanumerics...
      //
      case DBT_TOKEN : return MUD_DATATYPE_STRING;

      // 2019-09-22 jj5 - strings...
      //
      case DBT_ASCII_BIN  :
      case DBT_ASCII_CI   : return MUD_DATATYPE_STRING;
      case DBT_UTF8_BIN   :
      case DBT_UTF8_CI    : return MUD_DATATYPE_STRING;

      // 2020-03-09 jj5 - characters...
      //
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI  : return MUD_DATATYPE_STRING;
      case DBT_UTF8_CHAR_BIN  :
      case DBT_UTF8_CHAR_CI   : return MUD_DATATYPE_STRING;

      // 2020-03-26 jj5 - text...
      //
      case DBT_TEXT : return MUD_DATATYPE_STRING;

      // 2020-03-17 jj5 - medium/large binary data...
      //
      case DBT_BMOB :
      case DBT_BLOB : return MUD_DATATYPE_STRING;

      case DBT_ENUM : return MUD_DATATYPE_STRING;

      // 2021-03-27 jj5 - some schema elements don't define a data type, such as schema
      // definitions and tables, so if col type is null just return null...
      //
      case null: return null;

      default :

        mud_not_supported(
          [ 'col_type' => $this->get_col_type(), 'element' => $this ]
        );

    }
  }

  public function get_app_datatype() {

    switch ( $this->get_col_type() ) {

      case DBT_BOOL : return 'bool';

      // 2019-10-16 jj5 - unsigned integers for IDs (auto-increment)...
      //
      case DBT_ID8  :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 : return 'int';

      // 2019-09-22 jj5 - unsigned integers...
      //
      case DBT_UINT8  :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 : return 'int';

      // 2019-09-22 jj5 - signed integers...
      //
      case DBT_INT8  :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 : return 'int';

      // 2019-10-20 jj5 - floats...
      //
      case DBT_SINGLE :
      case DBT_DOUBLE : return 'float';

      // 2019-09-22 jj5 - datetimes...
      //
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON : return 'DateTimeInterface';

      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME     : return 'DateTimeInterface';

      case DBT_TIMEZONE : return 'string';


      // 2019-11-06 jj5 - sha512/224 hashes in various formats...
      //
      case DBT_HASH_HEX : return 'string';
      case DBT_HASH_BIN : return 'string';

      // 2019-11-06 jj5 - tokens are 48 char alphanumerics...
      //
      case DBT_TOKEN : return 'string';

      // 2019-09-22 jj5 - strings...
      //
      case DBT_ASCII_BIN  :
      case DBT_ASCII_CI   :
      case DBT_UTF8_BIN   :
      case DBT_UTF8_CI    : return 'string';

      // 2020-03-09 jj5 - characters...
      //
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI  :
      case DBT_UTF8_CHAR_BIN  :
      case DBT_UTF8_CHAR_CI   : return 'string';

      // 2020-03-26 jj5 - text...
      //
      case DBT_TEXT : return 'string';

      // 2020-03-17 jj5 - medium/large binary data...
      //
      case DBT_BMOB :
      case DBT_BLOB : return 'string';

      // 2022-02-24 jj5 - enums are treated as UTF-8...
      //
      case DBT_ENUM : return 'string';

      // 2021-03-27 jj5 - some schema elements don't define a data type, such as schema
      // definitions and tables, so if col type is null just return null...
      //
      case null: return null;

      default :

        mud_not_supported(
          [ 'col_type' => $this->get_col_type(), 'element' => $this ]
        );

    }
  }

  public function get_prop( $tab ) {

    $name = $this->get_name();

    if ( mud_is_bool_name( $name ) ) {
      //return preg_replace( '/^a_/', '', $name );
    }

    $tab_name = $tab->get_short_name();

    $is_flags = false;

    if ( strpos( $tab->get_name(), 't_lookup_' ) === 0 ) {

      $is_flags = true;

      $tab_name = preg_replace( '/_flags$/', '', $tab_name );

    }

    if ( strpos( $name, $tab_name ) === 2 ) {

      $result = substr( $name, strlen( $tab_name ) + 3 );

      if ( $is_flags ) {

        return preg_replace( '/^flags_/', '', $result );

      }

      if ( $result ) { return $result; }

      $parts = explode( '_', $tab_name, 2 );

      assert( count( $parts ) === 2 );
      assert( in_array( $parts[ 0 ], [ 'std', 'bus' ] ) );

      return $parts[ 1 ];

    }

    return $name;

  }

  public function get_const() { return strtoupper( $this->get_name() ); }

  public function get_cast_function() {

    switch ( $this->get_type() ) {


      //
      // 2021-04-02 jj5 - integers...
      //

      case DBT_BOOL   :

      case DBT_ID8    :
      case DBT_ID16   :
      case DBT_ID24   :
      case DBT_ID32   :
      case DBT_ID64   :

      case DBT_UINT8  :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :

      case DBT_INT8   :
      case DBT_INT16  :
      case DBT_INT24  :
      case DBT_INT32  :
      case DBT_INT64  :

        assert( ! $this->is_ascii() );
        assert( ! $this->is_unicode() );
        assert( ! $this->is_binary() );

        return 'intval';


      //
      // 2021-04-02 jj5 - floats...
      //

      case DBT_SINGLE :
      case DBT_DOUBLE :

        assert( ! $this->is_ascii() );
        assert( ! $this->is_unicode() );
        assert( ! $this->is_binary() );

        return 'floatval';


      //
      // 2021-04-02 jj5 - ASCII...
      //

      case DBT_CREATED_ON     :
      case DBT_UPDATED_ON     :

      case DBT_DATETIME_UTC   :
      case DBT_DATETIME_SYD   :
      case DBT_DATETIME       :

      case DBT_TIMEZONE       :

      case DBT_HASH_HEX       :

      case DBT_TOKEN          :

      case DBT_ASCII_BIN      :
      case DBT_ASCII_CI       :

      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI  :

        assert( $this->is_ascii() );
        assert( ! $this->is_unicode() );
        assert( ! $this->is_binary() );

        return 'mud_asciival';


      //
      // 2021-04-02 jj5 - UTF-8...
      //

      case DBT_UTF8_BIN       :
      case DBT_UTF8_CI        :
      case DBT_UTF8_CHAR_BIN  :
      case DBT_UTF8_CHAR_CI   :
      case DBT_TEXT           :

        assert( ! $this->is_ascii() );
        assert( $this->is_unicode() );
        assert( ! $this->is_binary() );

        return 'mud_utf8val';


      //
      // 2021-04-02 jj5 - binary...
      //

      case DBT_HASH_BIN       :
      case DBT_BMOB           :
      case DBT_BLOB           :

        assert( ! $this->is_ascii() );
        assert( ! $this->is_unicode() );
        assert( $this->is_binary() );

        return 'strval';

      case DBT_ENUM : return 'strval';

      default : mud_not_supported();

    }
  }

  public function is_ascii() { return $this->get_string_type() === MUD_STRING_TYPE_ASCII; }
  public function is_unicode() { return $this->get_string_type() === MUD_STRING_TYPE_UNICODE; }
  public function is_binary() { return $this->get_string_type() === MUD_STRING_TYPE_BINARY; }

  public function get_string_type() {

    switch ( $this->get_type() ) {

      case DBT_ASCII_BIN :
      case DBT_ASCII_CI :
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI :
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :
      case DBT_DATETIME :
      case DBT_DATETIME_SRV :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME_UTC :
      case DBT_HASH_HEX :
      case DBT_TIMEZONE :
      case DBT_TOKEN :

        return MUD_STRING_TYPE_ASCII;

      case DBT_TEXT :
      case DBT_UTF8_BIN :
      case DBT_UTF8_CI :
      case DBT_UTF8_CHAR_BIN :
      case DBT_UTF8_CHAR_CI :
      case DBT_ENUM :

        return MUD_STRING_TYPE_UNICODE;

      case DBT_BLOB :
      case DBT_BMOB :
      case DBT_HASH_BIN :

        return MUD_STRING_TYPE_BINARY;

      case DBT_BOOL :
      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 :
      case DBT_INT8 :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 :
      case DBT_UINT8 :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :
      case DBT_SINGLE :
      case DBT_DOUBLE :

        return MUD_STRING_TYPE_OTHER;

      default :

        mud_not_supported();

    }
  }

  public function is_interaction_id() { return $this->is_interaction_id; }

  public function is_auto_inc() {

    switch ( $this->get_type() ) {

      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 : return true;

      default : return false;

    }
  }

  public function is_auto() {

    switch ( $this->get_type() ) {

      case DBT_CREATED_ON :
      case DBT_UPDATED_ON : return true;

      default : return false;

    }
  }

  public function get_classes() {

    $classes = [];

    if ( $this->is_vrt ) { $classes[] = 'vrt'; }

    if ( $this->is_key ) { $classes[] = 'key'; }

    if ( $this->is_ref ) { $classes[] = 'ref'; }

    if ( $this->is_flg ) { $classes[] = 'flg'; }

    if ( $this->is_dup ) { $classes[] = 'dup'; }

    return $classes;

  }

  public function get_human_name() {

    $result = [];

    $parts = explode( '_', $this->get_name() );

    $first = array_shift( $parts );

    assert( $first === 'a' );

    $second = array_shift( $parts );

    assert( is_string( $second ) );
    assert( $second !== '' );

    if ( $second[ 0 ] === 'x' ) {

      assert( preg_match( '/^x[0-9]+$/', $second ) );

    }
    else {

      if ( ! in_array( $second, [ 'std', 'bus' ] ) ) {

        mud_fail( MUD_ERR_SCHEMADEF_INVALID_NAME, [ 'second' => $second ] );

      }
    }

    $last_index = count( $parts ) - 1;

    for ( $i = 0; $i <= $last_index; $i++ ) {

      $part = $parts[ $i ];

      if ( $i === 0 ) { $first = $part; }

      if ( $i === $last_index ) {

        $new_part = null;

        switch ( $part ) {

          // 2020-03-25 jj5 - these are the things we replace if they come
          // last...

          case 'hex'        : continue 2;

          case 'id'         : $new_part = 'ID'; break;
          case 'tz'         : $new_part = 'Time Zone'; break;
          case 'utc'        : $new_part = '(UTC)'; break;
          case 'bin'        : $new_part = '(binary}'; break;
          case 'ci'         : $new_part = '(case-insensitive)'; break;
          case 'cs'         : $new_part = '(case-sensitive)'; break;
          case 'jzon'       : $new_part = '(compressed JSON)'; break;
          case 'short'      : $new_part = '(short)'; break;
          case 'urlencoded' : $new_part = '(URL encoded)'; break;

        }

        if ( $new_part ) {

          $result[] = $new_part;

          continue;

        }
      }

      switch ( $part ) {

        // 2020-03-25 jj5 - these are the things we always replace...

        case 'ip'   : $part = 'IP'; break;
        case 'aux'  : $part = 'Auxiliary'; break;
        case 'sql'  : $part = 'SQL'; break;
        case 'url'  : $part = 'URL'; break;
        case 'auth' : $part = 'Authentication'; break;
        case 'crud' : $part = 'CRUD'; break;
        case 'xsrf' : $part = 'XSRF'; break;
        case 'http' : $part = 'HTTP'; break;
        case 'prev' : $part = 'Previous'; break;
        case 'curr' : $part = 'Current'; break;

        case 'rowversion' : $part = 'Row Version'; break;

        // 2020-03-25 jj5 - THINK: I question the wisdom of this...
        //
        case 'pclog'  : $part = 'Log'; break;

        default : $part = ucfirst( $part ); break;

      }

      $result[] = $part;

    }

    $result = implode( ' ', $result );

    if ( mud_is_bool_name( "{$first}_" ) ) { $result .= '?'; }

    return $result;

  }


}
