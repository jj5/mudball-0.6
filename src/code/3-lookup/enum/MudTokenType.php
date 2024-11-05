<?php

abstract class MudTokenType extends MudEnum {

  use MudEnumTraits;

  const BROWSER = 1;
  const SESSION = 2;
  const XSRF = 3;
  const CREDENTIAL_RESET = 4;
  const EMAIL_VERIFY = 5;

  static $map = [
    MUD_TOKEN_TYPE_BROWSER        => self::BROWSER,
    MUD_TOKEN_TYPE_SESSION        => self::SESSION,
    MUD_TOKEN_TYPE_XSRF           => self::XSRF,
    MUD_TOKEN_TYPE_CREDENTIAL_RESET => self::CREDENTIAL_RESET,
    MUD_TOKEN_TYPE_EMAIL_VERIFY   => self::EMAIL_VERIFY,
  ];

}
