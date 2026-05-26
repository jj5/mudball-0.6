<?php

abstract class MudModelChange {

  protected static int $counter = 1;

  public int $id;

  public function __construct() {

    $this->id = self::$counter++;

  }

  public abstract function get_change_type() : MudModelChangeType;

}
