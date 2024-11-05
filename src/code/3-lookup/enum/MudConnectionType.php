<?php

abstract class MudConnectionType extends MudEnum {

  use MudEnumTraits;

  const TRN = 1;
  const RAW = 2;
  const EMU = 3;
  const AUX = 4;
  const DBA = 5;

  static $map = [
    MUD_CONNECTION_TYPE_TRN => self::TRN,
    MUD_CONNECTION_TYPE_RAW => self::RAW,
    MUD_CONNECTION_TYPE_EMU => self::EMU,
    MUD_CONNECTION_TYPE_AUX => self::AUX,
    MUD_CONNECTION_TYPE_DBA => self::DBA,
  ];

}
