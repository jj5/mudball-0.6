<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-25 jj5 - include dependencies...
//

require_once __DIR__ . '/../270-validation/mud_validation.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include components...
//

require_once __DIR__ . '/interface/IMudValueProvider.php';
require_once __DIR__ . '/interface/IMudConstant.php';

require_once __DIR__ . '/class/MudConstant.php';
require_once __DIR__ . '/class/MudSettings.php';
require_once __DIR__ . '/class/MudModuleSettings.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - factory methods...
//

function new_mud_constant( string $const_name, $default_value = null ) {

  return mud_module_settings()->new_mud_constant( $const_name, $default_value );  

}

function new_mud_settings( array $settings, array $defaults = [] ) {

  return mud_module_settings()->new_mud_settings( $settings, $defaults );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2020-03-09 jj5 - functional interface...
//

function mud_get_constant( string $const_name, $default_value = null ) {

  return mud_module_settings()->get_constant( $const_name, $default_value );

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-02-07 jj5 - service locator...
//
//

function mud_module_settings() : MudModuleSettings {

  return mud_locator()->get_module( MudModuleSettings::class );

}
