<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-25 jj5 - these are the possible cookie type codes...
//

define( 'MUD_COOKIE_TYPE_SETTING', 'setting' );
define( 'MUD_COOKIE_TYPE_SESSION', 'session' );
define( 'MUD_COOKIE_TYPE_BROWSER', 'browser' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - enum class...
//

abstract class MudCookieType extends MudEnum {

  use MudEnumTraits;

  const SETTING = 1;
  const SESSION = 2;
  const BROWSER = 3;

  static $map = [
    MUD_COOKIE_TYPE_SETTING => self::SETTING,
    MUD_COOKIE_TYPE_SESSION => self::SESSION,
    MUD_COOKIE_TYPE_BROWSER => self::BROWSER,
  ];

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - PHP enum...
//

enum MudCookieTypeEnum : int {

  case SETTING = MudCookieType::SETTING;
  case SESSION = MudCookieType::SESSION;
  case BROWSER = MudCookieType::BROWSER;

}
