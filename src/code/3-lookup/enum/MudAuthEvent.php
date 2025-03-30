<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - these are possible authentication event codes...
//

define( 'MUD_AUTH_EVENT_LOGIN',       'login'       );
define( 'MUD_AUTH_EVENT_SIGNUP',      'signup'      );
define( 'MUD_AUTH_EVENT_LOGOUT',      'logout'      );
define( 'MUD_AUTH_EVENT_DEACTIVATED', 'deactivated' );
define( 'MUD_AUTH_EVENT_FORGOT',      'forgot'      );
define( 'MUD_AUTH_EVENT_RESET',       'reset'       );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - PHP enum...
//

enum MudAuthEventEnum : int {

  case LOGIN        = 11;
  case SIGNUP       = 12;

  case LOGOUT       = 21;
  case DEACTIVATED  = 22;

  case FORGOT       = 31;
  case RESET        = 32;

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - enum class...
//

abstract class MudAuthEvent extends MudEnum {

  use MudEnumTraits;

  const LOGIN       = MudAuthEventEnum::LOGIN->value;
  const SIGNUP      = MudAuthEventEnum::SIGNUP->value;

  const LOGOUT      = MudAuthEventEnum::LOGOUT->value;
  const DEACTIVATED = MudAuthEventEnum::DEACTIVATED->value;

  const FORGOT      = MudAuthEventEnum::FORGOT->value;
  const RESET       = MudAuthEventEnum::RESET->value;

  static $map = [

    MUD_AUTH_EVENT_LOGIN        => self::LOGIN,
    MUD_AUTH_EVENT_SIGNUP       => self::SIGNUP,

    MUD_AUTH_EVENT_LOGOUT       => self::LOGOUT,
    MUD_AUTH_EVENT_DEACTIVATED  => self::DEACTIVATED,

    MUD_AUTH_EVENT_FORGOT       => self::FORGOT,
    MUD_AUTH_EVENT_RESET        => self::RESET,
  ];

}
