<?php

interface IMudMoney extends IMudInteger {

  public function is_less_than( IMudMoney $money ) : bool;

  public function is_greater_than( IMudMoney $money ) : bool;

  public function to_currency( IMudCurrency|string $currency ) : IMudMoney;

  public function get_currency() : IMudCurrency;

  public function get_sign() : IMudSign;

  public function get_amount() : int;

  public function add_money( IMudMoney|null $money ) : IMudMoney;

  public function subtract_money( IMudMoney|null $money ) : IMudMoney;

  public function multiply_money( int|float $factor ) : IMudMoney;

  public function invert_money() : IMudMoney;

}
