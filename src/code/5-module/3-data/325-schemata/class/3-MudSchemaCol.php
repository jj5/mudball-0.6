<?php

class MudSchemaCol extends MudGadget {

  public $schemata;
  public $tab;
  public $schema;
  public $revision;
  public $revision_number;
  public $revision_file;
  public $file;
  public $line;

  public $tab_name;
  public $tab_type;

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
  public $ref_col;

  public $flag;

  public $db_datatype;
  public $app_datatype;
  public $prop;
  public $const;
  public $cast_function;
  public $is_ascii;
  public $is_unicode;
  public $is_binary;
  public $string_type;
  public $is_interaction_id;
  public $is_auto_inc;
  public $is_auto;
  public $classes;
  public $human_name;

  public function jsonSerialize(): mixed {

    return [
      //'schemata' => $this->schemata,
      //'tab' => $this->tab,
      'schema' => $this->schema,
      'revision' => $this->revision,
      'revision_number' => $this->revision_number,
      'revision_file' => $this->revision_file,
      'file' => $this->file,
      'line' => $this->line,
      'tab_name' => $this->tab_name,
      'tab_type' => $this->tab_type,
      'col_name' => $this->col_name,
      'col_type' => $this->col_type,
      'is_key' => $this->is_key,
      'is_vrt' => $this->is_vrt,
      'is_ref' => $this->is_ref,
      'is_flg' => $this->is_flg,
      'is_dup' => $this->is_dup,
      'is_unique' => $this->is_unique,
      'is_fk' => $this->is_fk,
      'min' => $this->min,
      'max' => $this->max,
      'nullable' => $this->nullable,
      'default' => $this->default,
      'valid' => $this->valid,
      'invalid' => $this->invalid,
      'ref_tab_name' => $this->ref_tab_name,
      'ref_col_name' => $this->ref_col_name,
      //'ref_col' => $this->ref_col,
      'flag' => $this->flag,
      'db_datatype' => $this->db_datatype,
      'app_datatype' => $this->app_datatype,
      'prop' => $this->prop,
      'const' => $this->const,
      'cast_function' => $this->cast_function,
      'is_ascii' => $this->is_ascii,
      'is_unicode' => $this->is_unicode,
      'is_binary' => $this->is_binary,
      'string_type' => $this->string_type,
      'is_interaction_id' => $this->is_interaction_id,
      'is_auto_inc' => $this->is_auto_inc,
      'is_auto' => $this->is_auto,
      'classes' => $this->classes,
      'human_name' => $this->human_name,
    ];

  }

  public function __construct(
    $schemata,
    $tab,
    $schema,
    $revision,
    $revision_number,
    $revision_file,
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
    $ref_col,
    $flag,
    $db_datatype,
    $app_datatype,
    $prop,
    $const,
    $cast_function,
    $is_ascii,
    $is_unicode,
    $is_binary,
    $string_type,
    $is_interaction_id,
    $is_auto_inc,
    $is_auto,
    $classes,
    $human_name
  ) {

    $this->schemata = $schemata;
    $this->tab = $tab;
    $this->schema = $schema;
    $this->revision = $revision;
    $this->revision_number = $revision_number;
    $this->revision_file = $revision_file;
    $this->file = $file;
    $this->line = $line;

    $this->tab_name = $tab->tab_name;
    $this->tab_type = $tab->tab_type;

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
    $this->ref_col = $ref_col;

    $this->flag = $flag;

    $this->db_datatype = $db_datatype;
    $this->app_datatype = $app_datatype;
    $this->prop = $prop;
    $this->const = $const;
    $this->cast_function = $cast_function;
    $this->is_ascii = $is_ascii;
    $this->is_unicode = $is_unicode;
    $this->is_binary = $is_binary;
    $this->string_type = $string_type;
    $this->is_interaction_id = $is_interaction_id;
    $this->is_auto_inc = $is_auto_inc;
    $this->is_auto = $is_auto;
    $this->classes = $classes;
    $this->human_name = $human_name;

    parent::__construct();

  }

  public function get_schemata() { return $this->schemata; }
  public function get_tab() { return $this->tab; }
  public function get_schema() { return $this->schema; }
  public function get_revision() { return $this->revision; }
  public function get_revision_number() { return $this->revision_number; }
  public function get_revision_file() { return $this->revision_file; }
  public function get_file() { return $this->file; }
  public function get_line() { return $this->line; }

  public function get_tab_name() { return $this->tab_name; }
  public function get_tab_type() { return $this->tab_type; }

  public function get_name() { return $this->col_name; }
  public function get_type() { return $this->col_type; }

  public function get_col_name() { return $this->col_name; }
  public function get_col_type() { return $this->col_type; }

  public function is_for_add() {

    if ( $this->is_vrt() ) { return false; }

    if ( $this->is_dup() ) { return false; }

    if ( $this->is_auto() ) { return false; }

    if ( $this->is_ref() ) { return true; }

    if ( $this->is_auto_inc() ) { return false; }

    return true;

  }

  public function is_for_set() {

    if ( $this->is_vrt() ) { return false; }

    if ( $this->is_dup() ) { return false; }

    if ( $this->is_auto() ) { return false; }

    if ( $this->is_ref() ) { return true; }

    if ( $this->is_auto_inc() ) { return true; }

    return true;

  }

  public function is_for_put() {

    return $this->is_for_set();

  }

  public function is_for_del() {

    return $this->is_key();

  }

  public function is_key() { return $this->is_key; }
  public function is_vrt() { return $this->is_vrt; }
  public function is_ref() { return $this->is_ref; }
  public function is_flg() { return $this->is_flg; }
  public function is_dup() { return $this->is_dup; }

  public function is_unique() { return $this->is_unique; }
  public function is_fk() { return $this->is_fk; }

  public function get_min() { return $this->min; }
  public function get_max() { return $this->max; }
  public function get_nullable() { return $this->nullable; }
  public function get_default() { return $this->default; }
  public function get_valid() { return $this->valid; }
  public function get_invalid() { return $this->invalid; }

  public function get_ref_tab_name() { return $this->ref_tab_name; }
  public function get_ref_col_name() { return $this->ref_col_name; }
  public function get_ref_col() { return $this->ref_col; }

  public function get_flag() { return $this->flag; }

  public function get_db_datatype() { return $this->db_datatype; }
  public function get_app_datatype() { return $this->app_datatype; }
  public function get_prop() { return $this->prop; }
  public function get_const() { return $this->const; }
  public function get_cast_function() { return $this->cast_function; }
  public function is_ascii() { return $this->is_ascii; }
  public function is_unicode() { return $this->is_unicode; }
  public function is_binary() { return $this->is_binary; }
  public function get_string_type() { return $this->string_type; }
  public function is_interaction_id() { return $this->is_interaction_id; }
  public function is_auto_inc() { return $this->is_auto_inc; }
  public function is_auto() { return $this->is_auto; }
  public function get_classes() { return $this->classes; }
  public function get_human_name() { return $this->human_name; }


  public function is_valid( $value, &$problem = null, &$error = null ) {

    //$this->validation_count++;

    // 2020-03-24 jj5 - NOTE: the $value must be in database format.

    $problem = null;
    $error = null;

    if ( ! $this->is_valid_nullable( $value, $problem, $error ) ) { return false; }

    if ( $value === null ) { return true; }

    if ( ! $this->is_valid_value( $value, $problem, $error ) ) { return false; }

    if ( ! $this->is_valid_min( $value, $problem, $error ) ) { return false; }

    if ( ! $this->is_valid_max( $value, $problem, $error ) ) { return false; }

    if ( ! $this->is_valid_pattern( $value, $problem, $error ) ) { return false; }

    return true;

  }


  public function get_default_value() {

    // 2020-03-24 jj5 - NOTE: default values should be in database format...

    $default = $this->default;

    if ( $this->col_type === DBT_TIMEZONE ) {

      return date_default_timezone_get();

    }

    if ( $default === MUD_UNSPECIFIED ) {

      if ( $this->col_type === DBT_BOOL ) { return false; }

      return null;

    }

    if ( $default === MUD_CURRENT_TIMESTAMP ) {

      return null;

    }

    return $default;

  }

  public function get_db_value( $value ) {

    if ( $value === null ) { return null; }

    switch ( $this->col_type ) {

      case DBT_BOOL : return $value ? 1 : 0;

      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 :
      case DBT_UINT8 :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :
      case DBT_INT8 :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 :

        return intval( $value );

      case DBT_SINGLE :
      case DBT_DOUBLE :

        return floatval( $value );

      // 2020-03-22 jj5 - THINK: maybe we can convert to DateTime objects
      // and back again..? Needs some thought.
      //
      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :
      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME :
      case DBT_TIMEZONE :
      case DBT_HASH_HEX :
      case DBT_TOKEN :
      case DBT_ASCII_BIN :
      case DBT_ASCII_CI :
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI :

        return mud_asciival( $value );

      case DBT_UTF8_BIN :
      case DBT_UTF8_CI :
      case DBT_UTF8_CHAR_BIN :
      case DBT_UTF8_CHAR_CI :
      case DBT_TEXT :
      case DBT_ENUM :

        return mud_utf8val( $value );

      case DBT_HASH_BIN :
      case DBT_BMOB :
      case DBT_BLOB :

        return strval( $value );

      default :

        mud_not_supported( [ 'col_type' => $this->col_type ] );

    }
  }

  public function get_app_value( $value ) {

    if ( $value === null ) { return null; }

    switch ( $this->col_type ) {

      case DBT_BOOL :

        return $value ? true : false;

      default :

        return $this->get_db_value( $value );

    }
  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-04-13 jj5 - protected methods...
  //

  protected function is_valid_nullable( $value, &$problem = null, &$error = null ) {

    if ( $value === null ) {

      if ( ! $this->nullable ) {

        $problem = sprintf(
          '%s value cannot be null.',
          $this->get_human_name()
        );

        return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NULL );

      }
    }

    return true;

  }

  protected function is_valid_value( $value, &$problem = null, &$error = null ) {

    switch ( $this->col_type ) {

      case DBT_BOOL :

        if ( ! is_bool( $value ) && $value !== 1 && $value !== 0 ) {

          $problem = sprintf(
            'invalid boolean value for %s.',
            $this->get_human_name(),
            gettype( $value )
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_INVALID_BOOLEAN );

        }

        break;

      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 :
      case DBT_UINT8 :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :
      case DBT_INT8 :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 :

        if ( ! is_int( $value ) ) {

          $problem = sprintf(
            'integer required for %s; %s detected.',
            $this->get_human_name(),
            gettype( $value )
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NOT_INTEGER );

        }

        break;

      case DBT_SINGLE :
      case DBT_DOUBLE :

        if ( ! is_float( $value ) ) {

          $problem = sprintf(
            'floating-point value required for %s; %s detected.',
            $this->get_human_name(),
            gettype( $value )
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NOT_FLOAT );

        }

        break;

      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :
      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME :
      case DBT_TIMEZONE :
      case DBT_HASH_HEX :
      case DBT_HASH_BIN :
      case DBT_TOKEN :
      case DBT_ASCII_BIN :
      case DBT_ASCII_CI :
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI :
      case DBT_BMOB :
      case DBT_BLOB :

        if ( ! is_string( $value ) ) {

          $problem = sprintf(
            'string value required for %s; %s detected.',
            $this->get_human_name(),
            gettype( $value )
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NOT_STRING );

        }

        break;

      case DBT_UTF8_BIN :
      case DBT_UTF8_CI :
      case DBT_UTF8_CHAR_BIN :
      case DBT_UTF8_CHAR_CI :
      case DBT_TEXT :
      case DBT_ENUM :

        if ( ! is_string( $value ) ) {

          $problem = sprintf(
            'string value required for %s; %s detected.',
            $this->get_human_name(),
            gettype( $value )
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NOT_STRING );

        }

        if ( $value !== iconv( 'UTF-8', 'UTF-8', $value ) ) {

          $problem = sprintf(
            'invalid Unicode value for %s.',
            $this->get_human_name()
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_NOT_VALID_UTF8 );

        }

        break;

      default :

        mud_not_supported( [ 'col_type' => $this->col_type ] );

    }

    return true;

  }

  protected function is_valid_min( $value, &$problem = null, &$error = null ) {

    $min = $this->min;

    if ( $min === null ) { return true; }

    switch ( $this->col_type ) {

      case DBT_BOOL :

        if ( $value < $min ) {

          $problem = sprintf(
            'boolean value for %s is too small; minimum value is %d.',
            $this->get_human_name(),
            $min
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_VALUE );

        }

        break;

      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 :
      case DBT_UINT8 :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :
      case DBT_INT8 :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 :

        if ( $value < $min ) {

          $problem = sprintf(
            'integer value for %s is too small; minimum value is %d.',
            $this->get_human_name(),
            $min
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_VALUE );

        }

        break;

      case DBT_SINGLE :
      case DBT_DOUBLE :

        if ( $value < $min ) {

          $problem = sprintf(
            'floating-point value for %s is too small; minimum value is %d.',
            $this->get_human_name(),
            $min
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_VALUE );

        }

        break;

      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :
      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME :
      case DBT_TIMEZONE :
      case DBT_HASH_HEX :
      case DBT_HASH_BIN :
      case DBT_TOKEN :
      case DBT_ASCII_BIN :
      case DBT_ASCII_CI :
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI :
      case DBT_BMOB :
      case DBT_BLOB :

        $len = strlen( $value );

        if ( $len < $min ) {

          $problem = sprintf(
            'string value for %s is too short; minimum length is %d.',
            $this->get_human_name(),
            $min
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_LENGTH );

        }

        break;

      case DBT_UTF8_BIN :
      case DBT_UTF8_CI :
      case DBT_UTF8_CHAR_BIN :
      case DBT_UTF8_CHAR_CI :
      case DBT_TEXT :
      case DBT_ENUM :

        $len = mb_strlen( $value );

        if ( $len < $min ) {

          $problem = sprintf(
            'string value for %s is too short; minimum length is %d.',
            $this->get_human_name(),
            $min
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_BELOW_MINIMUM_LENGTH );

        }

        break;

      default :

        mud_not_supported( [ 'col_type' => $this->col_type ] );

    }

    return true;

  }

  protected function is_valid_max( $value, &$problem = null, &$error = null ) {

    $max = $this->max;

    if ( $max === null ) { return true; }

    switch ( $this->col_type ) {

      case DBT_BOOL :

        if ( $value > $max ) {

          $problem = sprintf(
            'boolean value for %s is too large; maximum value is %d.',
            $this->get_human_name(),
            $max
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_VALUE );

        }

        break;

      case DBT_ID8 :
      case DBT_ID16 :
      case DBT_ID24 :
      case DBT_ID32 :
      case DBT_ID64 :
      case DBT_UINT8 :
      case DBT_UINT16 :
      case DBT_UINT24 :
      case DBT_UINT32 :
      case DBT_UINT64 :
      case DBT_INT8 :
      case DBT_INT16 :
      case DBT_INT24 :
      case DBT_INT32 :
      case DBT_INT64 :

        if ( $value > $max ) {

          $problem = sprintf(
            'integer value for %s is too large; maximum value is %d.',
            $this->get_human_name(),
            $max
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_VALUE );

        }

        break;

      case DBT_SINGLE :
      case DBT_DOUBLE :

        if ( $value > $max ) {

          $problem = sprintf(
            'floating-point value for %s is too large; maximum value is %d.',
            $this->get_human_name(),
            $max
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_VALUE );

        }

        break;

      case DBT_CREATED_ON :
      case DBT_UPDATED_ON :
      case DBT_DATETIME_UTC :
      case DBT_DATETIME_SYD :
      case DBT_DATETIME :
      case DBT_TIMEZONE :
      case DBT_HASH_HEX :
      case DBT_HASH_BIN :
      case DBT_TOKEN :
      case DBT_ASCII_BIN :
      case DBT_ASCII_CI :
      case DBT_ASCII_CHAR_BIN :
      case DBT_ASCII_CHAR_CI :
      case DBT_BMOB :
      case DBT_BLOB :

        $len = strlen( $value );

        if ( $len > $max ) {

          $problem = sprintf(
            'string value for %s is too long; maximum length is %d.',
            $this->get_human_name(),
            $max
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_LENGTH );

        }

        break;

      case DBT_UTF8_BIN :
      case DBT_UTF8_CI :
      case DBT_UTF8_CHAR_BIN :
      case DBT_UTF8_CHAR_CI :
      case DBT_TEXT :
      case DBT_ENUM :

        $len = mb_strlen( $value );

        if ( $len > $max ) {

          $problem = sprintf(
            'string value for %s is too long; maximum length is %d.',
            $this->get_human_name(),
            $max
          );

          return $this->invalid( $value, $error, MUD_ERR_SCHEMATA_FIELD_IS_ABOVE_MAXIMUM_LENGTH );

        }

        break;

      default :

        mud_not_supported( [ 'col_type' => $this->col_type ] );

    }

    return true;

  }

  protected function is_valid_pattern( $value, &$problem = null, &$error = null ) {

    $pattern = $this->valid;

    if ( $pattern ) {

      if ( ! preg_match( $pattern, $value, $matches ) ) {

        //var_dump( $pattern ); var_dump( $matches ); echo '<pre>'; echo $value; exit;

        $problem = sprintf(
          'value for %s is not in a valid format.',
          $this->get_human_name()
        );

        $error = MUD_ERR_SCHEMATA_FIELD_IS_NOT_IN_VALID_FORMAT;

        return false;

      }
    }

    $pattern = $this->invalid;

    if ( $pattern ) {

      if ( preg_match( $pattern, $value, $matches ) ) {

        //var_dump( $pattern ); var_dump( ord( $matches[ 0 ] ) ); echo '<pre>'; echo $value; exit;

        //var_dump( $pattern ); var_dump( $matches ); mud_exit();

        $problem = sprintf(
          'value for %s is in an invalid format.',
          $this->get_human_name()
        );

        $error = MUD_ERR_SCHEMATA_FIELD_IS_IN_AN_INVALID_FORMAT;

        return false;

      }
    }

    return true;

  }

  protected function invalid( $value, &$error, $set_error ) {

    $error = $set_error;

    if ( function_exists( 'app' ) ) {

      $error_name = mud_get_error_name( $error );

      app()->log_validation_problem(
        $this->tab_name . '.' . $this->col_name,
        $value,
        $error_name
      );

    }

    return false;

  }
}
