<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible cookie type codes...
//

define( 'MUD_COOKIE_TYPE_SETTING', 'setting' );
define( 'MUD_COOKIE_TYPE_SESSION', 'session' );
define( 'MUD_COOKIE_TYPE_BROWSER', 'browser' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - PHP enum...
//

enum MudCookieTypeEnum : int {

  case SETTING = 1;
  case SESSION = 2;
  case BROWSER = 3;

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - enum class...
//

abstract class MudCookieType extends MudEnum {

  use MudEnumTraits;

  const SETTING = MudCookieTypeEnum::SETTING->value;
  const SESSION = MudCookieTypeEnum::SESSION->value;
  const BROWSER = MudCookieTypeEnum::BROWSER->value;

  static $map = [
    MUD_COOKIE_TYPE_SETTING => self::SETTING,
    MUD_COOKIE_TYPE_SESSION => self::SESSION,
    MUD_COOKIE_TYPE_BROWSER => self::BROWSER,
  ];

}
