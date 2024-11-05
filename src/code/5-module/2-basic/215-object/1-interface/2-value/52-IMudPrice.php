<?php

interface IMudPrice extends IMudAtom, IMudMoney {

  public function get_money() : IMudMoney;

  public function get_value_min_money() : IMudMoney|null;

  public function get_value_max_money() : IMudMoney|null;

  public function get_price_in_currency( IMudCurrency|string $currency ) : IMudPrice;

  public function add_price( IMudPrice|null $price ) : IMudPrice;

  public function subtract_price( IMudPrice|null $price ) : IMudPrice;

  public function multiply_price( int|float $factor ) : IMudPrice;

  public function invert_price() : IMudPrice;

}
