<?php

abstract class MudRole extends MudEnum {

  use MudEnumTraits;

  // 2021-03-21 jj5 - NOTE: it might seem a bit silly to have a 'user' group given that all
  // users are in it, so what's the point? The answer is that it can be a target for
  // permissions. So an administrator could give permissions to the 'user' role and thereby
  // give permission to all users in the system.

  // 2021-03-21 jj5 - THINK: given that all users are in the 'user' group, is there any need for
  // there to be an actual membership record in the user_role table..?

  const USER = 1;
  const ADMINISTRATOR = 2;
  const PROGRAMMER = 3;
  const TESTER = 4;

  static $map = [
    MUD_ROLE_USER           => self::USER,
    MUD_ROLE_ADMINISTRATOR  => self::ADMINISTRATOR,
    MUD_ROLE_PROGRAMMER     => self::PROGRAMMER,
    MUD_ROLE_TESTER         => self::TESTER,
  ];

}
