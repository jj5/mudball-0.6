<?php

abstract class MudCookieType extends MudEnum {

  use MudEnumTraits;

  const BROWSER = 1;
  const SESSION = 2;

  static $map = [
    MUD_COOKIE_TYPE_BROWSER => self::BROWSER,
    MUD_COOKIE_TYPE_SESSION => self::SESSION,
  ];

}
