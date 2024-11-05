<?php

abstract class MudUrlEncoded extends MudString implements IMudUrlEncoded {

  public function decode() : string { return urldecode( $this->get_value() ); }

}
