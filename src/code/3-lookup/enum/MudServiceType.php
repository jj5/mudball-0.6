<?php

abstract class MudServiceType extends MudEnum {

  use MudEnumTraits;

  const STANDARD  = 1;
  const CUSTOM    = 2;

  static $map = [
    MUD_SERVICE_TYPE_STANDARD => self::STANDARD,
    MUD_SERVICE_TYPE_CUSTOM   => self::CUSTOM,
  ];

}
