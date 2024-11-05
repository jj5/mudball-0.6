<?php

abstract class MudDatabaseOperation extends MudEnum {

  use MudEnumTraits;

  // 2020-03-25 jj5 - the first digit of these enum values matches the value
  // from MudCrud enums for similar operations...

  // 2021-03-21 jj5 - NOTE: we used to have suppport for 'SEQUENCE' but I have removed it because
  // I have no present use for it. You could use either CREATE_TABLE or CREATE_OTHER for
  // sequences; if you need to create/drop databases, or users, those get filed under 'OTHER'
  // for now.

  const INSERT            = 11;
  const CREATE_DATABASE   = 12;
  const CREATE_TABLE      = 13;
  const CREATE_VIEW       = 14;
  const CREATE_INDEX      = 15;
  const CREATE_PROCEDURE  = 16;
  const CREATE_FUNCTION   = 17;
  const CREATE_OTHER      = 19;

  const SELECT            = 21;

  const UPDATE            = 31;
  const ALTER_TABLE       = 33;
  const REPLACE           = 39;

  const DELETE            = 41;
  const DROP_DATABASE     = 42;
  const DROP_TABLE        = 43;
  const DROP_VIEW         = 44;
  const DROP_INDEX        = 45;
  const DROP_PROCEDURE    = 46;
  const DROP_FUNCTION     = 47;
  const DROP_OTHER        = 49;

  const CALL              = 51;
  const SET               = 55;

  static $map = [

    MUD_DATABASE_OPERATION_INSERT           => self::INSERT,
    MUD_DATABASE_OPERATION_CREATE_DATABASE  => self::CREATE_DATABASE,
    MUD_DATABASE_OPERATION_CREATE_TABLE     => self::CREATE_TABLE,
    MUD_DATABASE_OPERATION_CREATE_VIEW      => self::CREATE_VIEW,
    MUD_DATABASE_OPERATION_CREATE_INDEX     => self::CREATE_INDEX,
    MUD_DATABASE_OPERATION_CREATE_PROCEDURE => self::CREATE_PROCEDURE,
    MUD_DATABASE_OPERATION_CREATE_FUNCTION  => self::CREATE_FUNCTION,
    MUD_DATABASE_OPERATION_CREATE_OTHER     => self::CREATE_OTHER,

    MUD_DATABASE_OPERATION_SELECT           => self::SELECT,

    MUD_DATABASE_OPERATION_UPDATE           => self::UPDATE,
    MUD_DATABASE_OPERATION_ALTER_TABLE      => self::ALTER_TABLE,
    MUD_DATABASE_OPERATION_REPLACE          => self::REPLACE,

    MUD_DATABASE_OPERATION_DELETE           => self::DELETE,
    MUD_DATABASE_OPERATION_DROP_DATABASE    => self::DROP_DATABASE,
    MUD_DATABASE_OPERATION_DROP_TABLE       => self::DROP_TABLE,
    MUD_DATABASE_OPERATION_DROP_VIEW        => self::DROP_VIEW,
    MUD_DATABASE_OPERATION_DROP_INDEX       => self::DROP_INDEX,
    MUD_DATABASE_OPERATION_DROP_PROCEDURE   => self::DROP_PROCEDURE,
    MUD_DATABASE_OPERATION_DROP_FUNCTION    => self::DROP_FUNCTION,
    MUD_DATABASE_OPERATION_DROP_OTHER       => self::DROP_OTHER,

    MUD_DATABASE_OPERATION_CALL             => self::CALL,
    MUD_DATABASE_OPERATION_SET              => self::SET,

  ];

}
