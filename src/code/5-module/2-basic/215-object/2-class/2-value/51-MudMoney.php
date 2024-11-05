<?php

abstract class MudMoney extends MudInteger implements IMudMoney {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - constructor...
  //

  public function __construct( int $amount ) {

    parent::__construct( $amount );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public static methods...
  //

  public static function get_default_currency_code() {

    return MudCurrency::get_default_currency_code();

  }

  public static function get_formatter() {

    static $formatter = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );

    return $formatter;

  }

  public static function parse( string $input ) : IMudMoney {

    $input = trim( $input );

    if ( $input === '' ) {

      return mud_get_money( 0, mud_get_currency( self::get_default_currency_code() ) );

    }

    $formatter = self::get_formatter();

    // 2024-07-30 jj5 - THINK: is this useful or necessary?
    //$this->currency_formatter->setPattern('¤#,##0.00;-¤#,##0.00');


    // 2024-07-30 jj5 - SEE: https://github.com/moneyphp/money/blob/master/src/Parser/IntlMoneyParser.php

    $value = preg_replace( '/AU\$/', 'AUD', $input );
    $value = preg_replace( '/US\$/', 'USD', $value );

    $amount = $formatter->parseCurrency( $value, $currency, $position );

    $currency = mud_get_currency( $currency );

    $decimal          = (string)$amount;
    $subunit          = $currency->get_currency_minor_unit();
    $decimal_position = strpos( $decimal, '.' );

    if ( $decimal_position !== false ) {
      
      $decimal_length   = strlen( $decimal );
      $fraction_digits  = $decimal_length - $decimal_position - 1;
      $decimal          = str_replace( '.', '', $decimal );
      $decimal          = self::round_money_value( $decimal, $subunit, $fraction_digits );

      if ( $fraction_digits > $subunit ) {
        
        $decimal = substr( $decimal, 0, $decimal_position + $subunit );
        
      }
      elseif ( $fraction_digits < $subunit ) {
        
        $decimal .= str_pad( '', $subunit - $fraction_digits, '0' );
        
      }
    }
    else {
      
      $decimal .= str_pad( '', $subunit, '0' );

    }

    if ( $decimal[ 0 ] === '-' ) {

      $decimal = '-' . ltrim( substr( $decimal, 1 ), '0' );
      
    }
    else {
      
      $decimal = ltrim( $decimal, '0' );
      
    }

    if ( $decimal === '' ) {
      
      $decimal = '0';

    }

    return mud_get_money( intval( $decimal ), $currency );

  }

  public static function round_money_value( string $money_value, int $target_digits, int $having_digits ) : string {

    // 2024-07-30 jj5 - SEE: https://github.com/moneyphp/money/blob/master/src/Number.php

    $value_length = strlen( $money_value );
    $should_round = $target_digits < $having_digits && $value_length - $having_digits + $target_digits > 0;

    if ( $should_round && $money_value[ $value_length - $having_digits + $target_digits ] >= 5 ) {
      
      $position = $value_length - $having_digits + $target_digits;
      
      $addend = 1;

      while ( $position > 0 ) {
        
        $new_value = (string)((int)$money_value[ $position - 1 ] + $addend );

        if ( $new_value >= 10 ) {
          
          $money_value[ $position - 1 ] = $new_value[ 1 ];
          
          $addend = $new_value[ 0 ];

          $position--;
          
          if ( $position === 0 ) {
            
            $money_value = $addend . $money_value;
            
          }
        }
        else {
          
          if ( $money_value[ $position - 1 ] === '-' ) {
            
            $money_value[ $position - 1 ] = $new_value[ 0 ];
            $money_value                  = '-' . $money_value;
            
          }
          else {
          
            $money_value[ $position - 1 ] = $new_value[ 0 ];

          }

          break;

        }
      }
    }

    return $money_value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-07-30 jj5 - public instance methods...
  //

  public function get_sort_value() : int { return $this->to_default_currency()->get_amount(); }

  public function to_default_currency() : IMudMoney {

    return $this->to_currency( $this->get_currency()->get_default_currency() );

  }

  public function to_currency( IMudCurrency|string $currency ) : IMudMoney {

    if ( is_string( $currency ) ) {

      $currency = mud_get_currency( $currency );

    }

    if ( $this->get_currency() === $currency ) {

      return $this;

    }

    assert( $this->get_currency()->get_currency_code() !== $currency->get_currency_code() );

    $rate = $this->get_currency()->get_currency_rates()[ 'rates' ][ $currency->get_currency_code() ] ?? 0;

    $amount = intval( round( $rate * $this->get_amount() ) );

    return mud_get_money( $amount, $currency );

  }

  public function get_sign() : IMudSign {

    return mud_get_sign( $this->get_value() );

  }

  public abstract function get_currency() : IMudCurrency;

  public function get_amount() : int { return $this->get_value(); }

  public function is_less_than( IMudMoney $money ) : bool { return $this->get_value() < $money->get_value(); }

  public function is_greater_than( IMudMoney $money ) : bool { return $this->get_value() > $money->get_value(); }

  public function add_money( IMudMoney|null $money ) : IMudMoney {

    if ( $this->get_currency() !== $money->get_currency() ) {

      $money = $money->to_currency( $this->get_currency() );

    }

    $value = $this->get_value() + $money->get_value();

    return mud_get_money( $value, $this->get_currency() );

  }

  public function subtract_money( IMudMoney|null $money ) : IMudMoney {

    if ( $this->get_currency() !== $money->get_currency() ) {

      $money = $money->to_currency( $this->get_currency() );

    }

    $value = $this->get_value() - $money->get_value();

    return mud_get_money( $value, $this->get_currency() );

  }

  public function invert_money() : IMudMoney {

    return $this->multiply_money( -1 );

  }

  public function multiply_money( int|float $factor ) : IMudMoney {

    $amount = intval( round( $this->get_amount() * $factor ) );

    return mud_get_money( $amount, $this->get_currency() );

  }

  public function format( $spec = null ) : string {

    $formatter = self::get_formatter();

    return $formatter->formatCurrency( $this->get_amount() / 100, $this->get_currency()->get_currency_code() );

  }  
}
