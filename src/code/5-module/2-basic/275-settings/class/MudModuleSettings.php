<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-25 jj5 - class definition...
//

class MudModuleSettings extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  function new_mud_constant( string $const_name, $default_value = null ) {

    return MudConstant::Create( $const_name, $default_value );

  }

  function new_mud_settings( array $settings, array $defaults = [] ) {

    return MudSettings::Create( $settings, $defaults );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-16 jj5 - public interface...
  //

  public function get_constant( string $const_name, $default_value = null ) {

    return defined( $const_name ) ? constant( $const_name ) : $default_value;

  }
}
