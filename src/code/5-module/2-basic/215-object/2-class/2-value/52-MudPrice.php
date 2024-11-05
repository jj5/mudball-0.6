<?php

abstract class MudPrice extends MudAtom implements IMudPrice {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - private fields...
  //

  private IMudMoney $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - constructor...
  //

  public function __construct( IMudMoney $value ) {

    parent::__construct();

    $this->value = $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - Stringable interface...
  //

  public function __toString() : string { return $this->to_string(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudNullable interface...
  //

  public function is_null() : bool { return false; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudValue interface...
  //

  public function is_valid( mixed $options = null ) : bool {

    if ( $this->get_value_min_money() && $this->get_value()->is_less_than( $this->get_value_min_money() ) ) { return false; }

    if ( $this->get_value_max_money() && $this->get_value()->is_greater_than( $this->get_value_max_money() ) ) { return false; }

    return true;

  }

  public function is_empty() : bool { return false; }

  public function is_zero() : bool { return $this->to_int() === 0; }

  public function is_nan() : bool { return false; }

  public function to_bool() : bool { return boolval( $this->to_int() ); }

  public function to_int() : int { return intval( $this->get_value()->to_int() ); }

  public function to_float() : float { return floatval( $this->to_int() ); }

  public function to_string() : string { return $this->get_value()->to_string(); }

  public function get_value() : mixed { return $this->get_money(); }

  public function get_db_value() : int|float|string|null { return $this->get_value()->to_string(); }

  public function get_sort_value() : int|float|string|null { return $this->to_default_currency()->get_amount(); }

  public function format( mixed $spec = null ) : string { return $this->get_money()->format( $spec ); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudNumber interface...
  //


  public function get_number() : float|int { return $this->get_amount(); }

  public function get_value_min_numeric() : float|int { return $this->get_value_min_integer(); }

  public function get_value_max_numeric() : float|int { return $this->get_value_max_integer(); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudInteger interface...
  //

  public function get_int() : int { return $this->get_amount(); }

  public function get_value_min_integer() : int {
    
    return $this->get_value_min_money()->get_amount() ?? PHP_INT_MIN;
    
  }

  public function get_value_max_integer() : int {
    
    return $this->get_value_max_money()->get_amount() ?? PHP_INT_MAX;
    
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudMoney interface...
  //

  public function get_currency() : IMudCurrency { return $this->get_money()->get_currency(); }

  public function get_sign() : IMudSign { return $this->get_money()->get_sign(); }

  public function get_amount() : int { return $this->get_money()->get_amount(); }

  public function is_less_than( IMudMoney $money ) : bool { return $this->get_money()->is_less_than( $money ); }

  public function is_greater_than( IMudMoney $money ) : bool { return $this->get_money()->is_greater_than( $money ); }

  public function to_default_currency() : IMudMoney {

    return $this->to_currency( $this->get_currency()->get_default_currency() );

  }

  public function to_currency( IMudCurrency|string $currency ) : IMudMoney  {
    
    return $this->get_money()->to_currency( $currency );
    
  }

  public function add_money( IMudMoney|null $money ) : IMudMoney { return $this->get_money()->add_money( $money ); }

  public function subtract_money( IMudMoney|null $money ) : IMudMoney { return $this->get_money()->subtract_money( $money ); }

  public function invert_money() : IMudMoney { return $this->get_money()->invert_money(); }

  public function multiply_money( int|float $factor ) : IMudMoney { return $this->get_money()->multiply_money( $factor ); }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - IMudPrice interface...
  //

  public function get_money() : IMudMoney { return $this->value; }

  public function get_value_min_money() : IMudMoney|null { return null; }

  public function get_value_max_money() : IMudMoney|null { return null; }

  public function get_price_in_currency( IMudCurrency|string $currency ) : IMudPrice {

    if ( is_string( $currency ) ) { $currency = mud_get_currency( $currency ); }

    if ( $this->get_currency() === $currency ) { return $this; }

    return $this->copy_price( $this->get_money()->to_currency( $currency ) );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public instance methods...
  //

  public function to_AUD() {

    return $this->to_currency( 'AUD' );

  }

  public function to_USD() {

    return $this->to_currency( 'USD' );

  }

  public function add_price( IMudPrice|null $price ) : IMudPrice {

    if ( $price === null ) { return $this; }

    $currency = $this->get_currency();

    assert( $currency !== null );

    $a = $this->get_money();
    $b = $price->to_currency( $currency );

    return $this->copy_price( $a->add_money( $b ) );

  }

  public function subtract_price( IMudPrice|null $price ) : IMudPrice {

    if ( $price === null ) { return $this; }

    $currency = $this->get_currency();

    assert( $currency !== null );

    $a = $this->get_money();
    $b = $price->to_currency( $currency );

    return $this->copy_price( $a->subtract_money( $b ) );

  }

  public function invert_price() : IMudPrice {

    return $this->multiply_price( -1 );

  }

  public function multiply_price( int|float $factor ) : IMudPrice{

    //if ( is_object( $factor ) ) { $factor = $factor->get_number(); }

    $currency = $this->get_currency();

    assert( $currency !== null );

    $amount = intval( round( $this->get_money()->get_amount() * $factor ) );

    return $this->copy_price( mud_get_money( $amount, $currency ) );

  }

  protected abstract function copy_price( IMudMoney $money );

}
