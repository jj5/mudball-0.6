<?php

function main( $argv ) {

  $data = require( __DIR__ . '/../../../../vendor/moneyphp/money/resources/currency.php' );

  echo "<?php\n\n";

  foreach ( $data as $spec ) {

    generate_currency( $spec );

    generate_money( $spec );

  }

}

function generate_currency( $spec ) {
?>

class MudCurrency_<?= $spec[ 'alphabeticCode' ] ?> extends MudCurrency {

  public function get_currency_code() : string { return '<?= $spec[ 'alphabeticCode' ] ?>'; }

  public function get_currency_code_numeric() : int { return <?= $spec[ 'numericCode' ] ?>; }

  public function get_currency_name() : string { return <?= json_encode( $spec[ 'currency' ] ) ?>; }

  public function get_currency_minor_unit() : int { return <?= $spec[ 'minorUnit' ] ?>; }

/*
  public function get_money( int $amount ) : IMudMoney {

    return mud_get_money( $amount, $this );

  }
*/
}

<?php
}

function generate_money( $spec ) {
?>

class MudMoney_<?= $spec[ 'alphabeticCode' ] ?> extends MudMoney {

  public function get_currency() : IMudCurrency {

    static $currency = null;

    if ( $currency === null ) {

      $currency = mud_get_currency( '<?= $spec[ 'alphabeticCode' ] ?>' );

    }

    return $currency;

  }

  public function get_currency_code() : string { return '<?= $spec[ 'alphabeticCode' ] ?>'; }

  public function get_currency_code_numeric() : int { return <?= $spec[ 'numericCode' ] ?>; }

  public function get_currency_name() : string { return <?= json_encode( $spec[ 'currency' ] ) ?>; }

  public function get_currency_minor_unit() : int { return <?= $spec[ 'minorUnit' ] ?>; }

}

<?php
}

main( $argv );
