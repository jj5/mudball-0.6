<?php

interface IMudDateTimeZone extends IMudAtom {

  public function get_offset() : int;

}
