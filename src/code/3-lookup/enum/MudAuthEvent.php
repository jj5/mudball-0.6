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

  case LOGIN        = MudAuthEvent::LOGIN;
  case SIGNUP       = MudAuthEvent::SIGNUP;

  case LOGOUT       = MudAuthEvent::LOGOUT;
  case DEACTIVATED  = MudAuthEvent::DEACTIVATED;

  case FORGOT       = MudAuthEvent::FORGOT;
  case RESET        = MudAuthEvent::RESET;

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - enum class...
//

abstract class MudAuthEvent extends MudEnum {

  use MudEnumTraits;

  const LOGIN       = 11;
  const SIGNUP      = 12;

  const LOGOUT      = 21;
  const DEACTIVATED = 22;

  const FORGOT      = 31;
  const RESET       = 32;

  static $map = [

    MUD_AUTH_EVENT_LOGIN        => self::LOGIN,
    MUD_AUTH_EVENT_SIGNUP       => self::SIGNUP,

    MUD_AUTH_EVENT_LOGOUT       => self::LOGOUT,
    MUD_AUTH_EVENT_DEACTIVATED  => self::DEACTIVATED,

    MUD_AUTH_EVENT_FORGOT       => self::FORGOT,
    MUD_AUTH_EVENT_RESET        => self::RESET,
  ];

}
