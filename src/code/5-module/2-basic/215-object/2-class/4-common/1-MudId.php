<?php

class MudId extends MudInteger {

  public function format( mixed $spec = null ) : string { return $this->to_string(); }

}
