<?php

interface IMudDateInterval extends IMudAtom {

  public function get_microseconds() : int;

  public function format_auto() : string;

}
