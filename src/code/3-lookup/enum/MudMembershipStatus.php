<?php

abstract class MudMembershipStatus extends MudEnum {

  use MudEnumTraits;

  const UNSET     = 1;
  const NONMEMBER = 2;
  const MEMBER    = 3;

  static $map = [
    MUD_MEMBERSHIP_STATUS_UNSET     => self::UNSET,
    MUD_MEMBERSHIP_STATUS_NONMEMBER => self::NONMEMBER,
    MUD_MEMBERSHIP_STATUS_MEMBER    => self::MEMBER,
  ];

}
