<?php

class MudSchemaVendor_MySQL extends MudSchemaVendor {

  public function get_col_type( $type, int $len ) : string {

    switch ( $type ) {

      case DBT_BOOL:
        return 'tinyint(1)';

      case DBT_AID8:
        return 'tinyint unsigned auto_increment';
      case DBT_AID16:
        return 'smallint unsigned auto_increment';
      case DBT_AID24:
        return 'mediumint unsigned auto_increment';
      case DBT_AID32:
        return 'int unsigned auto_increment';
      case DBT_AID64:
        // 2026-03-01 jj5 - we don't use unsigned 64-bit identities because PHP can't represent them
        return 'bigint auto_increment';

      case DBT_UINT8:
        return 'tinyint unsigned';
      case DBT_UINT16:
        return 'smallint unsigned';
      case DBT_UINT24:
        return 'mediumint unsigned';
      case DBT_UINT32:
        return 'int unsigned';

      case DBT_INT8:
        return 'tinyint';
      case DBT_INT16:
        return 'smallint';
      case DBT_INT24:
        return 'mediumint';
      case DBT_INT32:
        return 'int';
      case DBT_INT64:
        return 'bigint';

      case DBT_SINGLE:
        return 'float';
      case DBT_DOUBLE:
        return 'double';

      case DBT_CREATED_ON:
        return 'timestamp';
      case DBT_UPDATED_ON:
        return 'timestamp';

      case DBT_DATETIME:
      case DBT_DATETIME_UTC:
      case DBT_DATETIME_SYD:
      case DBT_DATETIME_SRV:
        return 'datetime';

      case DBT_TIMEZONE:
        return 'varchar(255) character set ascii collate ascii_general_ci';

      case DBT_HASH_BIN:
        return 'binary(28)';
      case DBT_HASH_HEX:
        return 'char(56) collate ascii_general_ci';

      case DBT_TOKEN:
        return 'char(48) collate ascii_bin';

      case DBT_ASCII_BIN:
        return "varchar({$len}) character set ascii collate ascii_bin";
      case DBT_ASCII_CI:
        return "varchar({$len}) character set ascii collate ascii_general_ci";
      case DBT_ASCII_CHAR_BIN:
        return "char({$len}) character set ascii collate ascii_bin";
      case DBT_ASCII_CHAR_CI:
        return "char({$len}) character set ascii collate ascii_general_ci";

      case DBT_UTF8_BIN:
        return "varchar({$len}) character set utf8mb4 collate utf8mb4_bin";
      case DBT_UTF8_CI:
        return "varchar({$len}) character set utf8mb4 collate utf8mb4_uca1400_ai_ci";
      case DBT_UTF8_CHAR_BIN:
        return "char({$len}) character set utf8mb4 collate utf8mb4_bin";
      case DBT_UTF8_CHAR_CI:
        return "char({$len}) character set utf8mb4 collate utf8mb4_uca1400_ai_ci";

      case DBT_TEXT:
        return 'longtext collate utf8mb4_uca1400_ai_ci';

      case DBT_BMOB:
        return 'mediumblob';
      case DBT_BLOB:
        return 'longblob';

      // 2026-03-01 jj5 - THINK: do we need DBT_ENUM?

      default:
        throw new \Exception( "Unsupported column type: {$type->name}" );
    }

  }

  public function has_length( $type ) : bool {

    switch ( $type ) {
      case DBT_ASCII_BIN:
      case DBT_ASCII_CI:
      case DBT_ASCII_CHAR_BIN:
      case DBT_ASCII_CHAR_CI:
      case DBT_UTF8_BIN:
      case DBT_UTF8_CI:
      case DBT_UTF8_CHAR_BIN:
      case DBT_UTF8_CHAR_CI:
        return true;
      default:
        return false;
    }

  }

  public function get_col_sql( $col ) : string {

    $name = $col->get_column_name();
    $type = $col->get_column_type();
    $max_len = $col->get_max_len();
    $nullable = $col->is_nullable();
    $has_default = $col->has_default();
    $default = $col->get_default();

    $parts = [];

    $parts[] = $name;

    $parts[] = $this->get_col_type( $type, $max_len );

    if ( $nullable ) {
      $parts[] = "null";
    } else {
      $parts[] = "not null";
    }

    if ( $has_default ) {
      $parts[] = "default {$default}";
    }

    return implode( ' ', $parts );

  }

  public function get_ref_sql( $ref ) : string {

    $name = $ref->get_column_name();
    $ref = $ref->get_ref_col();

    $ref_table = $ref->get_table()->get_table_name();
    $ref_col = $ref->get_column_name();

    $sql = "foreign key ( {$name} ) references {$ref_table} ( {$ref_col} )";

    return $sql;

  }
}
