<?php

// 2020-10-12 jj5 - SEE: https://www.progclub.org/wiki/database_patterns

abstract class MudTablePattern extends MudEnum {

  use MudEnumTraits;

  const ABINITIO    = 11;

  // 2021-03-19 jj5 - enumerations and flags
  // 2021-03-19 jj5 - NOTE: flags are just a special type of 'lookup'...
  //
  const LOOKUP      = 21;

  // 2021-03-19 jj5 - reference data
  //
  const STATIC      = 22;

  // 2021-03-19 jj5 - metadata and config data...
  //
  const ABOUT       = 31;
  const CONFIG      = 32;

  // 2021-03-19 jj5 - interaction log...
  //
  const DETAIL      = 41;

  // 2021-03-19 jj5 - serial numbers and random identifiers
  //
  const IDENT       = 51;

  // 2021-03-19 jj5 - elements
  //
  const PARTICLE    = 61;
  const PIECE       = 62;
  const POT         = 63;
  const PRODUCT     = 64;
  const DOMAIN      = 65;

  // 2021-03-19 jj5 - transacitonal data
  //
  const ENTITY      = 71;
  const HISTORY     = 72;
  const EPHEMERAL   = 73;
  const EVENT       = 74;

  // 2020-10-12 jj5 - insert only log data
  //
  const LOG         = 81;

  // 2020-10-12 jj5 - views
  //
  //const VIEW        = 91;

  // 2020-10-12 jj5 - anything else
  //
  //const OTHER       = 99;

  static $map = [

    MUD_TABLE_PATTERN_LOOKUP      => self::LOOKUP,

    MUD_TABLE_PATTERN_STATIC      => self::STATIC,

    MUD_TABLE_PATTERN_ABOUT       => self::ABOUT,
    MUD_TABLE_PATTERN_CONFIG      => self::CONFIG,

    MUD_TABLE_PATTERN_DETAIL      => self::DETAIL,

    MUD_TABLE_PATTERN_IDENT       => self::IDENT,

    MUD_TABLE_PATTERN_PARTICLE    => self::PARTICLE,
    MUD_TABLE_PATTERN_PIECE       => self::PIECE,
    MUD_TABLE_PATTERN_POT         => self::POT,
    MUD_TABLE_PATTERN_PRODUCT     => self::PRODUCT,
    //MUD_TABLE_PATTERN_DOMAIN      => self::DOMAIN,

    MUD_TABLE_PATTERN_ENTITY      => self::ENTITY,
    MUD_TABLE_PATTERN_HISTORY     => self::HISTORY,
    MUD_TABLE_PATTERN_EPHEMERAL   => self::EPHEMERAL,
    MUD_TABLE_PATTERN_EVENT       => self::EVENT,

    MUD_TABLE_PATTERN_LOG         => self::LOG,

  ];

}
