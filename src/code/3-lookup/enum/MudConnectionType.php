<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 JJ5 - these are the possible connection type codes...
//

define( 'MUD_CONNECTION_TYPE_RAW', 'raw' );
define( 'MUD_CONNECTION_TYPE_TRN', 'trn' );
define( 'MUD_CONNECTION_TYPE_EMU', 'emu' );
define( 'MUD_CONNECTION_TYPE_AUX', 'aux' );
define( 'MUD_CONNECTION_TYPE_DBA', 'dba' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - PHP enum...
//

enum MudConnectionTypeEnum : int {

  case RAW = 1;
  case TRN = 2;
  case EMU = 3;
  case AUX = 4;
  case DBA = 5;

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - enum class...
//

abstract class MudConnectionType extends MudEnum {

  use MudEnumTraits;

  const RAW = MudConnectionTypeEnum::RAW->value;
  const TRN = MudConnectionTypeEnum::TRN->value;
  const EMU = MudConnectionTypeEnum::EMU->value;
  const AUX = MudConnectionTypeEnum::AUX->value;
  const DBA = MudConnectionTypeEnum::DBA->value;

  static $map = [
    MUD_CONNECTION_TYPE_RAW => self::RAW,
    MUD_CONNECTION_TYPE_TRN => self::TRN,
    MUD_CONNECTION_TYPE_EMU => self::EMU,
    MUD_CONNECTION_TYPE_AUX => self::AUX,
    MUD_CONNECTION_TYPE_DBA => self::DBA,
  ];

}
