<?php

interface IMudCurrency extends IMudString {

  public function get_currency_code() : string;

  public function get_currency_code_numeric() : int;

  public function get_currency_name() : string;

  public function get_currency_minor_unit() : int;

  public function get_default_currency() : IMudCurrency;

  public function get_currency_rates() : array;

}
