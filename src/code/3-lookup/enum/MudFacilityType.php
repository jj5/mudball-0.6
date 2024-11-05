<?php

abstract class MudFacilityType extends MudEnum {

  use MudEnumTraits;

  const API       = 1;
  const ADMIN     = 2;
  const UTILITY   = 3;
  const CONTENT   = 4;
  const IMAGE     = 5;
  const STYLE     = 6;
  const SCRIPT    = 7;
  const RESOURCE  = 8;

  static $map = [
    MUD_FACILITY_TYPE_API       => self::API,
    MUD_FACILITY_TYPE_ADMIN     => self::ADMIN,
    MUD_FACILITY_TYPE_UTILITY   => self::UTILITY,
    MUD_FACILITY_TYPE_CONTENT   => self::CONTENT,
    MUD_FACILITY_TYPE_IMAGE     => self::IMAGE,
    MUD_FACILITY_TYPE_STYLE     => self::STYLE,
    MUD_FACILITY_TYPE_SCRIPT    => self::SCRIPT,
    MUD_FACILITY_TYPE_RESOURCE  => self::RESOURCE,
  ];

}
