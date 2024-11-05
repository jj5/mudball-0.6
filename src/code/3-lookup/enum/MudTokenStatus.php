<?php

abstract class MudTokenStatus extends MudEnum {

  use MudEnumTraits;

  const OPEN = 1;
  const USED = 2;
  const EXPIRED = 3;

  static $map = [
    MUD_TOKEN_STATUS_OPEN     => self::OPEN,
    MUD_TOKEN_STATUS_USED     => self::USED,
    MUD_TOKEN_STATUS_EXPIRED  => self::EXPIRED,
  ];

}
