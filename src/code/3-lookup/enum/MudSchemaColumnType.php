<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-20 jj5 - these are supported database column types...
//

// 2019-09-25 jj5 - NOTE: the 'DBT_' prefix below stands for "database type"

enum MudSchemaColumnType : string {

  case BOOL = 'BOOL';

  case AID8 = 'AID8';
  case AID16 = 'AID16';
  case AID24 = 'AID24';
  case AID32 = 'AID32';
  case AID64 = 'AID64';

  case UINT8 = 'UINT8';
  case UINT16 = 'UINT16';
  case UINT24 = 'UINT24';
  case UINT32 = 'UINT32';

  case INT8 = 'INT8';
  case INT16 = 'INT16';
  case INT24 = 'INT24';
  case INT32 = 'INT32';
  case INT64 = 'INT64';

  case SINGLE = 'SINGLE';
  case DOUBLE = 'DOUBLE';

  case CREATED_ON = 'CREATED_ON';
  case UPDATED_ON = 'UPDATED_ON';

  case DATETIME_UTC = 'DATETIME_UTC';
  case DATETIME_SYD = 'DATETIME_SYD';
  case DATETIME_SRV = 'DATETIME_SRV';

  case DATETIME = 'DATETIME';
  case TIMEZONE = 'TIMEZONE';

  case HASH_BIN = 'HASH_BIN';
  case HASH_HEX = 'HASH_HEX';

  case TOKEN = 'TOKEN';

  case ASCII_BIN = 'ASCII_BIN';
  case ASCII_CI = 'ASCII_CI';
  case ASCII_CHAR_BIN = 'ASCII_CHAR_BIN';
  case ASCII_CHAR_CI = 'ASCII_CHAR_CI';

  case UTF8_BIN = 'UTF8_BIN';
  case UTF8_CI = 'UTF8_CI';
  case UTF8_CHAR_BIN = 'UTF8_CHAR_BIN';
  case UTF8_CHAR_CI = 'UTF8_CHAR_CI';

  case TEXT = 'TEXT';

  case BMOB = 'BMOB';
  case BLOB = 'BLOB';

  case ENUM = 'ENUM';

}

define( 'DBT_BOOL', MudSchemaColumnType::BOOL );

// 2019-09-26 jj5 - boolean...
//
//define( 'DBT_BOOL', 'BOOL' );

// 2026-03-01 jj5 - unsigned integers for IDs (auto-increment), AID64 is signed though.
//
define( 'DBT_AID8',  MudSchemaColumnType::AID8 );
define( 'DBT_AID16', MudSchemaColumnType::AID16 );
define( 'DBT_AID24', MudSchemaColumnType::AID24 );
define( 'DBT_AID32', MudSchemaColumnType::AID32 );
define( 'DBT_AID64', MudSchemaColumnType::AID64 );

// 2019-09-22 jj5 - unsigned integers...
//
define( 'DBT_UINT8',  MudSchemaColumnType::UINT8 );
define( 'DBT_UINT16', MudSchemaColumnType::UINT16 );
define( 'DBT_UINT24', MudSchemaColumnType::UINT24 );
define( 'DBT_UINT32', MudSchemaColumnType::UINT32 );
// 2026-03-01 jj5 - I removed this because PHP doesn't support unsigned 64 bit integers
//define( 'DBT_UINT64', MudSchemaColumnType::UINT64 );

// 2019-09-22 jj5 - signed integers...
//
define( 'DBT_INT8',  MudSchemaColumnType::INT8 );
define( 'DBT_INT16', MudSchemaColumnType::INT16 );
define( 'DBT_INT24', MudSchemaColumnType::INT24 );
define( 'DBT_INT32', MudSchemaColumnType::INT32 );
define( 'DBT_INT64', MudSchemaColumnType::INT64 );

// 2019-10-20 jj5 - floats...
//
define( 'DBT_SINGLE', MudSchemaColumnType::SINGLE );
define( 'DBT_DOUBLE', MudSchemaColumnType::DOUBLE );

// 2019-09-22 jj5 - datetimes...
//
define( 'DBT_CREATED_ON', MudSchemaColumnType::CREATED_ON );
define( 'DBT_UPDATED_ON', MudSchemaColumnType::UPDATED_ON );
// 2020-03-18 jj5 - OLD: there are only two types of timestamp column supported,
// being DBT_CREATED_ON and DBT_UPDATED_ON, as above.
//define( 'DBT_TIMESTAMP',  'TIMESTAMP' );
define( 'DBT_DATETIME_UTC', MudSchemaColumnType::DATETIME_UTC );
define( 'DBT_DATETIME_SYD', MudSchemaColumnType::DATETIME_SYD );
define( 'DBT_DATETIME_SRV', MudSchemaColumnType::DATETIME_SRV );
// 2020-03-23 jj5 - if a datetime is not in UTC then it should have an
// associated timezone...
define( 'DBT_DATETIME',   MudSchemaColumnType::DATETIME );
define( 'DBT_TIMEZONE',   MudSchemaColumnType::TIMEZONE );

// 2019-11-06 jj5 - SHA512/224 hashes in various formats...
//
define( 'DBT_HASH_BIN', MudSchemaColumnType::HASH_BIN );
define( 'DBT_HASH_HEX', MudSchemaColumnType::HASH_HEX );

// 2019-11-06 jj5 - tokens are 48 char case-sensitive alphanumerics...
//
define( 'DBT_TOKEN', MudSchemaColumnType::TOKEN );

// 2019-09-22 jj5 - ASCII...
//
define( 'DBT_ASCII_BIN', MudSchemaColumnType::ASCII_BIN );
define( 'DBT_ASCII_CI', MudSchemaColumnType::ASCII_CI );
define( 'DBT_ASCII_CHAR_BIN', MudSchemaColumnType::ASCII_CHAR_BIN );
define( 'DBT_ASCII_CHAR_CI', MudSchemaColumnType::ASCII_CHAR_CI );

// 2020-03-09 jj5 - Unicode...
//
define( 'DBT_UTF8_BIN', MudSchemaColumnType::UTF8_BIN );
define( 'DBT_UTF8_CI', MudSchemaColumnType::UTF8_CI );
define( 'DBT_UTF8_CHAR_BIN', MudSchemaColumnType::UTF8_CHAR_BIN );
define( 'DBT_UTF8_CHAR_CI', MudSchemaColumnType::UTF8_CHAR_CI );

// 2020-03-26 jj5 - text...
//
define( 'DBT_TEXT', MudSchemaColumnType::TEXT );


// 2020-03-17 jj5 - A "BMOB" is a "Binary Medium Object" (16 MB)
//
define( 'DBT_BMOB', MudSchemaColumnType::BMOB );
define( 'DBT_BLOB', MudSchemaColumnType::BLOB );


// 2022-02-24 jj5 - I'm thinking I'll add support for 'enum' types as supported by MySQL...
//
define( 'DBT_ENUM', MudSchemaColumnType::ENUM );

