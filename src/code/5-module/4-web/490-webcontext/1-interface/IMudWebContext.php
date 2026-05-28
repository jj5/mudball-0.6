<?php

interface IMudWebContext extends IMudRequest, IMudResponse, ArrayAccess {

  public function get_value( $key, $default = null );
  public function get_list_value( $key, $index, $default = null );

}
