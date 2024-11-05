<?php


define( 'MUD_VALUE_DEFAULT_CURRENCY', 'AUD' );


class MudMoney extends MudString implements IMudMoney {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - jj5 - private fields...
  //

  private string $value;

  private IMudSign $sign;

  private IMudCurrency $currency;

  private IMudDollars $dollars;

  private IMudCents $cents;

  private $invalid_format = false;

  private $child_list = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - jj5 - constructor...
  //

  public function __construct( string $value, int $max_cents = PHP_INT_MAX, int $min_cents = PHP_INT_MIN ) {

    parent::__construct( $value );

    $sign = MUD_VALUE_POSITIVE_CHAR;
    $currency = null;
    $dollars = null;
    $cents = null;

    if (
      strlen( $value ) === 0 ||
      strpos( $value, ' ' ) !== false ||
      strpos( $value, ',,' ) !== false
    ) {

      $this->invalid_format = true;

    }
    else {

      if ( $value[ 0 ] === '-' ) {

        $sign = '-';

        $value = substr( $value, 1 );

      }

      $parts = explode( '$', $value );

      if ( count( $parts ) === 1 ) {

        $currency = MUD_VALUE_DEFAULT_CURRENCY;

        $price = $parts[ 0 ];

      }
      elseif ( count( $parts ) === 2 ) {

        $currency = $parts[ 0 ];

        $price = $parts[ 1 ];

      }
      else {

        $this->invalid_format = true;

        $price = '';

      }

      $parts = explode( '.', $price );

      if ( count( $parts ) === 1 ) {

        $dollars = $parts[ 0 ];

        $cents = '00';

      }
      elseif ( count( $parts ) === 2 ) {

        $dollars = $parts[ 0 ];

        $cents = $parts[ 1 ];

      }
      else {

        $this->invalid_format = true;

      }
    }

    $dollars = str_replace( ',', '', $dollars );
    $dollars_value = intval( $dollars );

    if ( $dollars_value < 0 ) {

      $this->invalid_format = true;

    }
    elseif ( $dollars !== strval( $dollars_value ) ) {

      $this->invalid_format = true;

      $dollars_value = null;

    }

    $cents_value = null;

    switch ( strlen( $cents ) ) {

      case 1 :

        // 2024-06-30 jj5 - we only allow '0' here, because 1.1 is ambiguous... could mean 1.10 or 1.01... but 1.0 is okay.

        if ( $cents !== '0' ) {

          $this->invalid_format = true;

          break;

        }

        $cents_value = 0;

        break;

      case 2 :

        if ( $cents === '00' ) {

          $cents_value = 0;

        }
        else {

          $cents = ltrim( $cents, '0' );

          $cents_value = intval( $cents );

          if ( $cents !== strval( $cents_value ) ) {

            $this->invalid_format = true;

            $cents_value = null;

          }
        }

        break;

      default :

        $this->invalid_format = true;

    }

    $this->sign = mud_get_sign( $sign );
    $this->currency = mud_get_currency( $currency );
    $this->dollars = mud_get_dollars( $dollars_value );
    $this->cents = mud_get_cents( $cents_value );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - IMudValue interface...
  //

  public function get_child_list() : array {

    if ( $this->child_list = null ) {

      $this->child_list = [];

      $this->get_sign()->add_to_list( $this->child_list );
      $this->get_currency()->add_to_list( $this->child_list );
      $this->get_dollars()->add_to_list( $this->child_list );
      $this->get_cents()->add_to_list( $this->child_list );

    }

    return $this->child_list;
    
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-30 jj5 - jj5 - IMudMoney interface...
  //

  public function get_sign() : IMudSign { return $this->sign; }

  public function get_currency() : IMudCurrency { return $this->currency; }

  public function get_dollars() : IMudDollars { return $this->dollars; }

  public function get_cents() : IMudCents { return $this->cents; }

}
