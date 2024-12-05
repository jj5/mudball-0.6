<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleFlags extends MudModuleCritical {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-02-24 jj5 - public functions...
  //

  //
  // 2020-04-10 jj5 - SEE: there are some handy notes here:
  // https://www.alanzucconi.com/2015/07/26/enum-flags-and-bitwise-operators/
  //

  public function has_flag( $flags, int $flag ) : bool {

    return ( intval( $flags ) & $flag ) === $flag;

  }

  public function set_flag( $flags, int $flag, bool $set = true ) : int {

    $flags = intval( $flags );

    if ( $set ) { return $flags | $flag; }

    return $flags & ( ~ $flag );

  }
}
