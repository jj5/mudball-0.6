<?php

abstract class MudSerializationType extends MudEnum {

  use MudEnumTraits;

  const JSON  = 1;
  const PHP   = 2;


  static $map = [

    MUD_SERIALIZATION_TYPE_JSON => self::JSON,
    MUD_SERIALIZATION_TYPE_PHP  => self::PHP,

  ];

}
