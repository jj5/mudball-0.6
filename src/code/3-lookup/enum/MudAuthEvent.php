<?php

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
