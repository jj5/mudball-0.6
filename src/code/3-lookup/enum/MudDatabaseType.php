<?php

// 2020-03-26 jj5 - this class identifies the database types supported by
// Mudball...

abstract class MudDatabaseType extends MudEnum {

  use MudEnumTraits;


  //
  // 2020-03-26 jj5 - booleans...
  //

  // 2020-03-26 jj5 - boolean values, modelled as 'true' and 'false' in
  // applications and stored in a tinyint (8-bit) value in the database using
  // values '0' or '1'... be aware that other 8-bit signed ints could
  // potentially be in the database (usually due to erroneous manual
  // intervention) so values such as 7 or -3 could be resident. The Mudball
  // library should generally handle this situation by treating zero values as
  // false and anything else as true, which is consistent with convention.
  //
  const BOOL  = 1;


  //
  // 2020-03-26 jj5 - identities...
  //

  // 2020-03-26 jj5 - NOTE: there should never be a zero value in an identity
  // column (under normal circumstances MySQL will always start auto_increment
  // columns with '1' and it would be a very bad idea for you to meddle with
  // this behaviour).

  // 2020-03-26 jj5 - auto-incrementing unsigned integer keys of various
  // bit-lengths...
  //
  const ID8   = 11;
  const ID16  = 12;
  const ID24  = 13;
  const ID32  = 14;

  // 2020-03-26 jj5 - NOTE: PHP uses signed 64-bit values so not all
  // 64-bit unsigned identities can be represented in applications...
  //
  const ID64  = 18;


  //
  // 2020-03-26 jj5 - unsigned integers...
  //

  // 2020-03-26 jj5 - unsigned integer values of various bit-lengths...
  //
  const UINT8   = 21;
  const UINT16  = 22;
  const UINT24  = 23;
  const UINT32  = 24;

  // 2020-03-26 jj5 - NOTE: PHP uses signed 64-bit values so not all
  // 64-bit unsigned values can be represented in applications...
  //
  //const UINT64  = 28;


  //
  // 2020-03-26 jj5 - signed integers...
  //

  // 2020-03-26 jj5 - signed integer values of various bit-lengths...
  //
  const INT8  = 31;
  const INT16 = 32;
  const INT24 = 33;
  const INT32 = 34;
  const INT64 = 38;


  //
  // 2020-03-26 jj5 - floating-point values...
  //

  // 2020-03-26 jj5 - 32-bit floating-point values...
  //
  const SINGLE = 44;

  // 2020-03-26 jj5 - 64-bit floating-point values...
  //
  const DOUBLE = 48;


  //
  // 2020-03-26 jj5 - datetimes...
  //

  // 2020-03-26 jj5 - a datetime (will usually have an associated DBT_TIMEZONE
  // to indiacate the applicable time zone)...
  //
  const DATETIME      = 51;

  // 2020-03-26 jj5 - a datetime in UTC...
  //
  const DATETIME_UTC  = 52;

  // 2020-09-17 jj5 - a datetime in 'Australia/Sydney'...
  //
  const DATETIME_SYD  = 53;

  // 2020-03-26 jj5 - a datetime in the application server's timezone,
  // whatever that is configured to be...
  //
  const DATETIME_SRV  = 57;

  // 2020-03-26 jj5 - the timestamp of record insertion...
  //
  const CREATED_ON    = 58;

  // 2020-03-26 jj5 - the timestamp of record insertion or last update...
  //
  const UPDATED_ON    = 59;


  //
  // 2020-03-26 jj5 - special string formats...
  //

  // 2020-03-26 jj5 - the name of a timezone (as supported by PHP and MySQL)...
  //
  const TIMEZONE  = 61;

  // 2020-03-26 jj5 - a 32 character case-sensitive ASCII alphanumeric string...
  //
  const TOKEN     = 62;


  //
  // 2020-03-26 jj5 - ASCII (no control chars)...
  //

  // 2020-03-26 jj5 - NOTE: case-sensitive ASCII values use the ascii_bin
  // collation and case-insensitive ASCII values use the ascii_general_ci
  // collation.

  // 2020-03-26 jj5 - a case-sensitive ASCII string...
  //
  const ASCII_BIN = 71;

  // 2020-03-26 jj5 - a case-insensitive ASCII string...
  //
  const ASCII_CI  = 72;

  // 2020-03-26 jj5 - a case-sensitive ASCII character...
  //
  const ASCII_CHAR_BIN  = 171;

  // 2020-03-26 jj5 - a case-insensitive ASCII character...
  //
  const ASCII_CHAR_CI   = 172;


  //
  // 2020-03-26 jj5 - Unicode (no control chars)...
  //

  // 2020-03-26 jj5 - NOTE: Unicode data is stored in the database in UTF-8
  // format using the utf8mb4 character set. Case-sensitive Unicode values use
  // the utf8mb4_bin collation and case-insensitive Unicode values use the
  // utf8mb4_unicode_520_ci collation.

  // 2020-03-26 jj5 - a case-sensitive UTF-8 string...
  //
  const UTF8_BIN  = 81;

  // 2020-03-26 jj5 - a case-insensitive UTF-8 string...
  //
  const UTF8_CI   = 82;

  // 2020-03-26 jj5 - a case-sensitive UTF-8 char...
  //
  const UTF8_CHAR_BIN = 181;

  // 2020-03-26 jj5 - a case-insensitive UTF-8 char...
  //
  const UTF8_CHAR_CI  = 182;


  //
  // 2020-03-26 jj5 - hashes...
  //

  // 2020-03-26 jj5 - a 28-byte binary value... typically a SHA512/224 hash.
  //
  const HASH_BIN  = 91;

  // 2020-03-26 jj5 - a 56 character hexadecimal string (in lowercase format
  // but treated as case-insensitive in the database)... usually columns of
  // this type are virtual and a HASH_BIN is stored in the database.
  //
  const HASH_HEX  = 92;


  //
  // 2020-03-26 jj5 - text...
  //

  // 2020-03-26 jj5 - text is in UTF-8 format (using the utf8mb4 character set
  // and utf8mb4_unicode_520_ci collation) and only allows new-line control
  // characters (\n). Note that line-endings are normalized during input so
  // there will be no carriage returns (\r), which is sensible... the data is
  // stored in a 'longtext' column type in the database meaning up to 4 GB of
  // text is supported and default values are not applied at the database
  // level (although they should still be applied to application data managed
  // by active records).
  //
  const TEXT = 99;


  //
  // 2020-03-26 jj5 - binary data... you can tell from the numbers 5 and 6... :)
  //

  // 2020-03-26 jj5 - "BMOB" is for "Binary Medium Object", supports up to
  // around 16 MB of data...
  //
  const BMOB = 101;

  // 2020-03-26 jj5 - "BLOB" is for "Binary Large Object", supports up to
  // around 4 GB of data...
  //
  const BLOB = 110;

  // 2020-09-24 jj5 - this is a virtual type for file uploads...
  //
  //const FILE = 111;


  //
  // 2020-03-26 jj5 - other data...
  //

  // 2020-03-26 jj5 - this $map is standard for MudEnum objects and maps
  // codes to enum constants...
  //
  static $map = [

    DBT_BOOL => self::BOOL,

    DBT_ID8 => self::ID8,
    DBT_ID16 => self::ID16,
    DBT_ID24 => self::ID24,
    DBT_ID32 => self::ID32,
    DBT_ID64 => self::ID64,

    DBT_UINT8 => self::UINT8,
    DBT_UINT16 => self::UINT16,
    DBT_UINT24 => self::UINT24,
    DBT_UINT32 => self::UINT32,
    //DBT_UINT64 => self::UINT64,

    DBT_INT8 => self::INT8,
    DBT_INT16 => self::INT16,
    DBT_INT24 => self::INT24,
    DBT_INT32 => self::INT32,
    DBT_INT64 => self::INT64,

    DBT_SINGLE => self::SINGLE,
    DBT_DOUBLE => self::DOUBLE,

    DBT_DATETIME => self::DATETIME,
    DBT_DATETIME_UTC => self::DATETIME_UTC,
    DBT_DATETIME_SYD => self::DATETIME_SYD,
    DBT_DATETIME_SRV => self::DATETIME_SRV,
    DBT_CREATED_ON => self::CREATED_ON,
    DBT_UPDATED_ON => self::UPDATED_ON,

    DBT_TOKEN => self::TOKEN,
    DBT_TIMEZONE => self::TIMEZONE,

    DBT_ASCII_BIN => self::ASCII_BIN,
    DBT_ASCII_CI => self::ASCII_CI,

    DBT_ASCII_CHAR_BIN => self::ASCII_CHAR_BIN,
    DBT_ASCII_CHAR_CI => self::ASCII_CHAR_CI,

    DBT_UTF8_BIN => self::UTF8_BIN,
    DBT_UTF8_CI => self::UTF8_CI,

    DBT_UTF8_CHAR_BIN => self::UTF8_CHAR_BIN,
    DBT_UTF8_CHAR_CI => self::UTF8_CHAR_CI,

    DBT_HASH_BIN => self::HASH_BIN,
    DBT_HASH_HEX => self::HASH_HEX,

    DBT_TEXT => self::TEXT,

    DBT_BMOB => self::BMOB,
    DBT_BLOB => self::BLOB,

    //DBT_FILE => self::FILE,

  ];

}
