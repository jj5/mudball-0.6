<?php

interface IMudMoney extends IMudString {

  public function get_sign() : IMudSign;

  public function get_currency() : IMudCurrency;

  public function get_dollars() : IMudDollars;

  public function get_cents() : IMudCents;

}
