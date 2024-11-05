<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - include dependencies...
//

require_once __DIR__ . '/../210-stash/mud_stash.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-30 jj5 - module errors...
//

mud_define_error( 'MUD_ERR_OBJECT_FORMAT_LENGTH_UNEXPECTED', 'unexpected format length.' );
mud_define_error( 'MUD_ERR_OBJECT_STATE_INVALID', 'object is in an invalid state.' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - include components...
//

require_once __DIR__ . '/1-interface/1-model/1-IMudObject.php';
require_once __DIR__ . '/1-interface/1-model/2-IMudNullable.php';
require_once __DIR__ . '/1-interface/1-model/3-IMudHost.php';
require_once __DIR__ . '/1-interface/1-model/4-IMudNode.php';
require_once __DIR__ . '/1-interface/1-model/5-IMudValue.php';
require_once __DIR__ . '/1-interface/1-model/6-IMudAtom.php';
require_once __DIR__ . '/1-interface/1-model/7-IMudComposite.php';
require_once __DIR__ . '/1-interface/1-model/8-IMudStructuredValue.php';
require_once __DIR__ . '/1-interface/1-model/9-IMudThing.php';

require_once __DIR__ . '/1-interface/2-value/10-IMudNumber.php';
require_once __DIR__ . '/1-interface/2-value/11-IMudInteger.php';
require_once __DIR__ . '/1-interface/2-value/12-IMudBoolean.php';
require_once __DIR__ . '/1-interface/2-value/13-IMudFloat.php';
require_once __DIR__ . '/1-interface/2-value/14-IMudSign.php';
require_once __DIR__ . '/1-interface/2-value/20-IMudString.php';
require_once __DIR__ . '/1-interface/2-value/21-IMudText.php';
require_once __DIR__ . '/1-interface/2-value/22-IMudBinary.php';
require_once __DIR__ . '/1-interface/2-value/30-IMudObjectValue.php';
require_once __DIR__ . '/1-interface/2-value/40-IMudDateTime.php';
require_once __DIR__ . '/1-interface/2-value/41-IMudDate.php';
require_once __DIR__ . '/1-interface/2-value/42-IMudTime.php';
require_once __DIR__ . '/1-interface/2-value/43-IMudDateTimeUniversal.php';
require_once __DIR__ . '/1-interface/2-value/44-IMudDateTimeLocal.php';
require_once __DIR__ . '/1-interface/2-value/45-IMudDateTimeZoned.php';
require_once __DIR__ . '/1-interface/2-value/46-IMudDateTimeZone.php';
require_once __DIR__ . '/1-interface/2-value/47-IMudDateInterval.php';
require_once __DIR__ . '/1-interface/2-value/50-IMudCurrency.php';
require_once __DIR__ . '/1-interface/2-value/51-IMudMoney.php';
require_once __DIR__ . '/1-interface/2-value/52-IMudPrice.php';
require_once __DIR__ . '/1-interface/2-value/60-IMudUrl.php';
require_once __DIR__ . '/1-interface/2-value/61-IMudUrlScheme.php';
require_once __DIR__ . '/1-interface/2-value/62-IMudUrlUser.php';
require_once __DIR__ . '/1-interface/2-value/63-IMudUrlPass.php';
require_once __DIR__ . '/1-interface/2-value/64-IMudUrlHost.php';
require_once __DIR__ . '/1-interface/2-value/65-IMudUrlPort.php';
require_once __DIR__ . '/1-interface/2-value/66-IMudUrlEncoded.php';
require_once __DIR__ . '/1-interface/2-value/67-IMudUrlPath.php';
require_once __DIR__ . '/1-interface/2-value/68-IMudUrlQuery.php';
require_once __DIR__ . '/1-interface/2-value/69-IMudUrlFragment.php';

require_once __DIR__ . '/1-interface/3-instance/1-IMudTrue.php';
require_once __DIR__ . '/1-interface/3-instance/2-IMudFalse.php';
require_once __DIR__ . '/1-interface/3-instance/3-IMudPositive.php';
require_once __DIR__ . '/1-interface/3-instance/4-IMudNegative.php';

require_once __DIR__ . '/1-interface/4-null/1-IMudNullValue.php';
require_once __DIR__ . '/1-interface/4-null/2-IMudNullThing.php';
require_once __DIR__ . '/1-interface/4-null/3-IMudNullObject.php';

require_once __DIR__ . '/2-class/1-base/1-MudObject.php';
require_once __DIR__ . '/2-class/1-base/2-MudNullable.php';
require_once __DIR__ . '/2-class/1-base/3-MudHostMixin.php';
require_once __DIR__ . '/2-class/1-base/3-MudHost.php';
require_once __DIR__ . '/2-class/1-base/4-MudNode.php';
require_once __DIR__ . '/2-class/1-base/5-MudValue.php';
require_once __DIR__ . '/2-class/1-base/6-MudAtom.php';
require_once __DIR__ . '/2-class/1-base/7-MudComposite.php';
require_once __DIR__ . '/2-class/1-base/8-MudStructuredValue.php';
require_once __DIR__ . '/2-class/1-base/9-MudThing.php';

require_once __DIR__ . '/2-class/2-value/10-MudNumber.php';
require_once __DIR__ . '/2-class/2-value/11-MudInteger.php';
require_once __DIR__ . '/2-class/2-value/12-MudBoolean.php';
require_once __DIR__ . '/2-class/2-value/13-MudFloat.php';
require_once __DIR__ . '/2-class/2-value/14-MudSign.php';
require_once __DIR__ . '/2-class/2-value/20-MudString.php';
require_once __DIR__ . '/2-class/2-value/21-MudText.php';
require_once __DIR__ . '/2-class/2-value/30-MudObjectValue.php';
require_once __DIR__ . '/2-class/2-value/40-MudDateTime.php';
require_once __DIR__ . '/2-class/2-value/41-MudDate.php';
require_once __DIR__ . '/2-class/2-value/42-MudTime.php';
require_once __DIR__ . '/2-class/2-value/43-MudDateTimeUniversal.php';
require_once __DIR__ . '/2-class/2-value/44-MudDateTimeLocal.php';
require_once __DIR__ . '/2-class/2-value/45-MudDateTimeZoned.php';
require_once __DIR__ . '/2-class/2-value/46-MudDateTimeZone.php';
require_once __DIR__ . '/2-class/2-value/47-MudDateInterval.php';
require_once __DIR__ . '/2-class/2-value/50-MudCurrency.php';
require_once __DIR__ . '/2-class/2-value/51-MudMoney.php';

require_once __DIR__ . '/../../../../gen/money/money.php';

require_once __DIR__ . '/2-class/2-value/52-MudPrice.php';
require_once __DIR__ . '/2-class/2-value/60-MudUrl.php';
require_once __DIR__ . '/2-class/2-value/61-MudUrlScheme.php';
require_once __DIR__ . '/2-class/2-value/62-MudUrlUser.php';
require_once __DIR__ . '/2-class/2-value/63-MudUrlPass.php';
require_once __DIR__ . '/2-class/2-value/64-MudUrlHost.php';
require_once __DIR__ . '/2-class/2-value/65-MudUrlPort.php';
require_once __DIR__ . '/2-class/2-value/66-MudUrlEncoded.php';
require_once __DIR__ . '/2-class/2-value/67-MudUrlPath.php';
require_once __DIR__ . '/2-class/2-value/68-MudUrlQuery.php';
require_once __DIR__ . '/2-class/2-value/69-MudUrlFragment.php';

require_once __DIR__ . '/2-class/3-instance/1-MudTrue.php';
require_once __DIR__ . '/2-class/3-instance/2-MudFalse.php';
require_once __DIR__ . '/2-class/3-instance/3-MudPositive.php';
require_once __DIR__ . '/2-class/3-instance/4-MudNegative.php';
require_once __DIR__ . '/2-class/3-instance/7-MudNullValue.php';
require_once __DIR__ . '/2-class/3-instance/8-MudNullThing.php';
require_once __DIR__ . '/2-class/3-instance/9-MudNullObjectMixin.php';
require_once __DIR__ . '/2-class/3-instance/9-MudNullObject.php';

require_once __DIR__ . '/2-class/4-common/1-MudId.php';
require_once __DIR__ . '/2-class/4-common/2-MudYear.php';
require_once __DIR__ . '/2-class/4-common/3-MudSlug.php';
require_once __DIR__ . '/2-class/4-common/4-MudName.php';

require_once __DIR__ . '/2-class/5-module/1-MudModuleValue.php';
require_once __DIR__ . '/2-class/5-module/2-MudModuleValueWeakRef.php';
require_once __DIR__ . '/2-class/5-module/3-MudModuleThing.php';
require_once __DIR__ . '/2-class/5-module/4-MudModuleObject.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - functional interface...
//

function mud_null_object() : IMudNullObject {

  return mud_module_object()->get_null();

}

function mud_set_null_object( IMudNullObject $null ) : void {

  mud_module_object()->set_null( $null );

}

function mud_get_value( string $class, $argument ) : IMudValue {

  return mud_module_object()->get_value( $class, $argument );

}

function mud_get_atom( string $class, $value ) : IMudAtom {

  return mud_module_object()->get_atom( $class, $value );

}

function mud_get_composite( string $class, $value_list ) : IMudComposite {

  return mud_module_object()->get_composite( $class, $value_list );

}

function mud_get_primitive( mixed $value ) : bool|int|float|string|object|null {

  return mud_module_object()->get_primitive( $value );

}

function mud_get_boolean( mixed $value ) : IMudBoolean {

  return mud_module_object()->get_boolean( $value );

}

function mud_get_true() : IMudTrue {

  return mud_module_object()->get_true();

}

function mud_get_false() : IMudFalse {

  return mud_module_object()->get_false();

}

function mud_get_sign( mixed $value ) : IMudSign {

  return mud_module_object()->get_sign( $value );

}

function mud_get_positive() : IMudPositive {

  return mud_module_object()->get_positive();

}

function mud_get_negative() : IMudNegative {

  return mud_module_object()->get_negative();

}

function mud_get_integer( mixed $value ) : IMudInteger {

  return mud_module_object()->get_integer( $value );

}

function mud_get_float( mixed $value ) : IMudFloat {

  return mud_module_object()->get_float( $value );

}

function mud_get_string( mixed $value ) : IMudString {

  return mud_module_object()->get_string( $value );

}

function mud_get_text( mixed $value ) : IMudText {

  return mud_module_object()->get_text( $value );

}

function mud_get_binary( mixed $value ) : IMudBinary {

  return mud_module_object()->get_binary( $value );

}

function mud_get_date( mixed $value ) : IMudDate {

  return mud_module_object()->get_date( $value );

}

function mud_get_time( mixed $value ) : IMudTime {

  return mud_module_object()->get_time( $value );

}

function mud_get_date_time_universal( mixed $value ) : IMudDateTimeUniversal {

  return mud_module_object()->get_date_time_universal( $value );

}

function mud_get_date_time_local( mixed $value ) : IMudDateTimeLocal {

  return mud_module_object()->get_date_time_local( $value );

}

function mud_get_date_time_zoned( mixed $value ) : IMudDateTimeZoned {

  return mud_module_object()->get_date_time_zoned( $value );

}

function mud_get_date_time_zone( mixed $value ) : IMudDateTimeZone {

  return mud_module_object()->get_date_time_zone( $value );

}

function mud_get_date_interval( mixed $value ) : IMudDateInterval {

  return mud_module_object()->get_date_interval( $value );

}

function mud_get_currency( IMudCurrency|string|null $currency ) : IMudCurrency {

  return mud_module_object()->get_currency( $currency );

}

function mud_get_money( int $amount, IMudCurrency|string $currency ) : IMudMoney {

  return mud_module_object()->get_money( $amount, $currency );

}

function mud_parse_money( string $string ) : IMudMoney {

  return mud_module_object()->parse_money( $string );

}

/*
function mud_get_dollars( mixed $value ) : IMudDollars {

  return mud_module_object()->get_dollars( $value );

}

function mud_get_cents( mixed $value ) : IMudCents {

  return mud_module_object()->get_cents( $value );

}
*/

function mud_get_url( mixed $value ) : IMudUrl {

  return mud_module_object()->get_url( $value );

}

function mud_get_url_scheme( mixed $value ) : IMudUrlScheme {

  return mud_module_object()->get_url_scheme( $value );

}

function mud_get_url_user( mixed $value ) : IMudUrlUser {

  return mud_module_object()->get_url_user( $value );

}

function mud_get_url_pass( mixed $value ) : IMudUrlPass {

  return mud_module_object()->get_url_pass( $value );

}

function mud_get_url_host( mixed $value ) : IMudUrlHost {

  return mud_module_object()->get_url_host( $value );

}

function mud_get_url_port( mixed $value ) : IMudUrlPort {

  return mud_module_object()->get_url_port( $value );

}

function mud_get_url_path( mixed $value ) : IMudUrlPath {

  return mud_module_object()->get_url_path( $value );

}

function mud_get_url_query( mixed $value ) : IMudUrlQuery {

  return mud_module_object()->get_url_query( $value );

}

function mud_get_url_fragment( mixed $value ) : IMudUrlFragment {

  return mud_module_object()->get_url_fragment( $value );

}

function mud_new_thing( string $class, array $child_list ) : IMudThing {

  return mud_module_object()->new_thing( $class, $child_list );

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - service locator...
//
//

function mud_module_object() : MudModuleObject {

  return mud_locator()->get_module( MudModuleObject::class );

}
