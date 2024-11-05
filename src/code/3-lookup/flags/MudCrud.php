<?php

abstract class MudCrud extends MudFlags {

  use MudEnumTraits;

  const CREATE    = 1;
  const RETRIEVE  = 2;
  const UPDATE    = 4;
  const DELETE    = 8;
  const UNDELETE  = 16;
  const SHRED     = 32;

  static $map = [
    MUD_CRUD_CREATE   => self::CREATE,
    MUD_CRUD_RETRIEVE => self::RETRIEVE,
    MUD_CRUD_UPDATE   => self::UPDATE,
    MUD_CRUD_DELETE   => self::DELETE,
    MUD_CRUD_UNDELETE => self::UNDELETE,
    MUD_CRUD_SHRED    => self::SHRED,
  ];

}
