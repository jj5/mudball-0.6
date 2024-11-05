<?php

abstract class MudGender extends MudEnum {

  use MudEnumTraits;

  const FEMALE      = 1;
  const MALE        = 2;
  const OTHER       = 3;
  const UNSPECIFIED = 9;

  static $map = [
    MUD_GENDER_FEMALE       => self::FEMALE,
    MUD_GENDER_MALE         => self::MALE,
    MUD_GENDER_OTHER        => self::OTHER,
    MUD_GENDER_UNSPECIFIED  => self::UNSPECIFIED,
  ];

}
