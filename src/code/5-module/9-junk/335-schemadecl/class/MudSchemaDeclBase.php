<?php

abstract class MudSchemaDeclBase extends MudGadget {

  public static $schema_type = [

    // 2019-09-22 jj5 - SEE: MySQL Integer Types:
    // https://dev.mysql.com/doc/refman/5.7/en/integer-types.html

    DBT_BOOL => [
      'datatype' => MUD_DATATYPE_BOOL,
      'min' => 0,
      'max' => 1,
    ],

    // 2020-10-01 jj5 - NOTE: with the 'ID' data types the minimum value zero (0) can be used by
    // foreign keys to indicate null, otherwise record IDs start with one (1) and increment from
    // there. Some database operations can flip ID FKs to negative values but such flipping
    // should always be reversed or rolled back so we should never see a negative ID come out
    // of our database...
    //
    DBT_ID8 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => 0,
      'max' => MUD_MAX_INT8,
    ],
    DBT_ID16 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => 0,
      'max' => MUD_MAX_INT16,
    ],
    DBT_ID24 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => 0,
      'max' => MUD_MAX_INT24,
    ],
    DBT_ID32 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => 0,
      'max' => MUD_MAX_INT32,
    ],
    DBT_ID64 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => 0,
      'max' => MUD_MAX_INT64,
    ],

    DBT_UINT8 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_UINT8,
      'max' => MUD_MAX_UINT8,
    ],
    DBT_UINT16 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_UINT16,
      'max' => MUD_MAX_UINT16,
    ],
    DBT_UINT24 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_UINT24,
      'max' => MUD_MAX_UINT24,
    ],
    DBT_UINT32 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_UINT32,
      'max' => MUD_MAX_UINT32,
    ],
    DBT_UINT64 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_UINT64,
      // 2019-09-22 jj5 - NOTE: 64-bit unsigned integers can technically be
      // bigger than PHP_INT_MAX (which is a signed value) in the database but
      // as PHP can't represent them we max out at 63-bits... if we need to
      // work with larger values those may have to be managed internally as
      // strings...
      //
      'max' => MUD_MAX_UINT64,
    ],

    DBT_INT8 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_INT8,
      'max' => MUD_MAX_INT8,
    ],
    DBT_INT16 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_INT16,
      'max' => MUD_MAX_INT16,
    ],
    DBT_INT24 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_INT24,
      'max' => MUD_MAX_INT24,
    ],
    DBT_INT32 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_INT32,
      'max' => MUD_MAX_INT32,
    ],
    DBT_INT64 => [
      'datatype' => MUD_DATATYPE_INT,
      'min' => MUD_MIN_INT64,
      'max' => MUD_MAX_INT64,
    ],

    DBT_SINGLE => [
      'datatype' => MUD_DATATYPE_FLOAT,
      // 2019-10-20 jj5 - THINK: is this right?
      //
      //'min' => MUD_NEG_INF,
      //'max' => MUD_POS_INF,
      'min' => null,
      'max' => null,
    ],

    DBT_DOUBLE => [
      'datatype' => MUD_DATATYPE_FLOAT,
      // 2019-10-20 jj5 - THINK: is this right?
      //
      //'min' => MUD_NEG_INF,
      //'max' => MUD_POS_INF,
      'min' => null,
      'max' => null,
    ],

    DBT_CREATED_ON => [
      'datatype' => MUD_DATATYPE_DATETIME,
      'min' => 19,
      'max' => 19,
      'valid' => MUD_REGEX_VALID_DATETIME,
    ],
    DBT_UPDATED_ON => [
      'datatype' => MUD_DATATYPE_DATETIME,
      'min' => 19,
      'max' => 19,
      'valid' => MUD_REGEX_VALID_DATETIME,
    ],

    DBT_DATETIME_UTC => [
      'datatype' => MUD_DATATYPE_DATETIME,
      'min' => 19,
      'max' => 19,
      'valid' => MUD_REGEX_VALID_DATETIME,
    ],
    DBT_DATETIME_SYD => [
      'datatype' => MUD_DATATYPE_DATETIME,
      'min' => 19,
      'max' => 19,
      'valid' => MUD_REGEX_VALID_DATETIME,
    ],

    DBT_DATETIME => [
      'datatype' => MUD_DATATYPE_DATETIME,
      'min' => 19,
      'max' => 19,
      'valid' => MUD_REGEX_VALID_DATETIME,
    ],

    DBT_TIMEZONE => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min'      => 0,
      'max'      => 255,
    ],

    DBT_HASH_HEX => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 56,
      'max' => 56,
      'valid' => MUD_REGEX_VALID_HASH_HEX,
    ],
    DBT_HASH_BIN => [
      'datatype' => MUD_DATATYPE_BINARY,
      'min' => 28,
      'max' => 28,
    ],

    DBT_TOKEN => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 48,
      'max' => 48,
      'valid' => MUD_REGEX_VALID_TOKEN,
    ],

    // 2019-11-06 jj5 - we no longer use MD5 hashes, use SHA512/224
    //DBT_MD5 => [
    //  'datatype' => MUD_DATATYPE_ASCII,
    //  'min' => 32,
    //  'max' => 32,
    //],

    DBT_ASCII_BIN => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 0,
      'max' => 255,
      'valid' => MUD_REGEX_VALID_ASCII,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],
    DBT_ASCII_CI => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 0,
      'max' => 255,
      'valid' => MUD_REGEX_VALID_ASCII,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],
    DBT_UTF8_BIN => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => 0,
      'max' => 63,
      'valid' => MUD_REGEX_VALID_UTF8,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],
    DBT_UTF8_CI => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => 0,
      'max' => 63,
      'valid' => MUD_REGEX_VALID_UTF8,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],

    DBT_ASCII_CHAR_BIN => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 1,
      'max' => 1,
      'valid' => MUD_REGEX_VALID_ASCII,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],
    DBT_ASCII_CHAR_CI => [
      'datatype' => MUD_DATATYPE_ASCII,
      'min' => 1,
      'max' => 1,
      'valid' => MUD_REGEX_VALID_ASCII,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],

    DBT_UTF8_CHAR_BIN => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => 1,
      'max' => 1,
      'valid' => MUD_REGEX_VALID_UTF8,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],
    DBT_UTF8_CHAR_CI => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => 1,
      'max' => 1,
      'valid' => MUD_REGEX_VALID_UTF8,
      'invalid' => MUD_REGEX_INVALID_CORD,
    ],

    DBT_TEXT => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => 0,
      'max' => MUD_MAX_UINT32,
      'valid' => MUD_REGEX_VALID_TEXT,
      //'invalid' => MUD_REGEX_INVALID_TEXT,
    ],

    DBT_BMOB => [
      'datatype' => MUD_DATATYPE_BINARY,
      'min' => 0,
      'max' => MUD_MYSQL_MEDIUMBLOB_MAX,
    ],
    DBT_BLOB => [
      'datatype' => MUD_DATATYPE_BINARY,
      'min' => 0,
      'max' => MUD_MYSQL_LONGBLOB_MAX,
    ],

    DBT_ENUM => [
      'datatype' => MUD_DATATYPE_UTF8,
      'min' => null,
      'max' => null,
    ],

    /*
    DBT_FILE => [
      'datatype' => MUD_DATATYPE_VIRTUAL,
      'min' => 0,
      'max' => 0,
    ],
    */

  ];

}
