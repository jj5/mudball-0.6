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
// 2025-03-26 jj5 - enum class...
//

abstract class MudConnectionType extends MudEnum {

  use MudEnumTraits;

  const RAW = 1;
  const TRN = 2;
  const EMU = 3;
  const AUX = 4;
  const DBA = 5;

  static $map = [
    MUD_CONNECTION_TYPE_RAW => self::RAW,
    MUD_CONNECTION_TYPE_TRN => self::TRN,
    MUD_CONNECTION_TYPE_EMU => self::EMU,
    MUD_CONNECTION_TYPE_AUX => self::AUX,
    MUD_CONNECTION_TYPE_DBA => self::DBA,
  ];

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-26 jj5 - PHP enum...
//

enum MudConnectionTypeEnum : int {

  case RAW = MudConnectionType::RAW;
  case TRN = MudConnectionType::TRN;
  case EMU = MudConnectionType::EMU;
  case AUX = MudConnectionType::AUX;
  case DBA = MudConnectionType::DBA;

}
