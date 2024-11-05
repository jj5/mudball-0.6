<?php

interface IMudObjectValue extends IMudAtom {

  public function get_object() : object|null;

}
