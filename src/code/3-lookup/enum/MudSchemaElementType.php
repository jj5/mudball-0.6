<?php


abstract class MudSchemaElementType extends MudEnum {

  use MudEnumTraits;

  const DEF = 1;
  const TAB = 2;
  const COL = 3;
  const IDX = 4;
  const DAT = 5;
  const RUN = 6;

  static $map = [

    MUD_SCHEMA_ELEMENT_DEF => self::DEF,
    MUD_SCHEMA_ELEMENT_TAB => self::TAB,
    MUD_SCHEMA_ELEMENT_COL => self::COL,
    MUD_SCHEMA_ELEMENT_IDX => self::IDX,
    MUD_SCHEMA_ELEMENT_DAT => self::DAT,
    MUD_SCHEMA_ELEMENT_RUN => self::RUN,


  ];

}
