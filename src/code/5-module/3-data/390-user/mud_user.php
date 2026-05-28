<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2022-02-23 jj5 - include dependencies...
//

require_once __DIR__ . '/../380-logic/mud_logic.php';


class MudUser {

  public function is_admin() { return true; }

  public function is_logged_in() { return true; }

}

function mud_user() {

  static $instance = new MudUser();

  return $instance;

}
