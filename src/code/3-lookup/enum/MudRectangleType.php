<?php

abstract class MudRectangleType extends MudEnum {

  use MudEnumTraits;

  const TABLE   = 1;
  const VIEW    = 2;
  const PRETTY  = 3;
  const OTHER   = 9;

  static $map = [
    MUD_RECTANGLE_TYPE_TABLE  => self::TABLE,
    MUD_RECTANGLE_TYPE_VIEW   => self::VIEW,
    MUD_RECTANGLE_TYPE_PRETTY => self::PRETTY,
    MUD_RECTANGLE_TYPE_OTHER  => self::OTHER,
  ];

}
