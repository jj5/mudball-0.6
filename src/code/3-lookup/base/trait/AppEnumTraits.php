<?php

trait AppEnumTraits {

  public static function GetData() {

    static $data = null;

    if ( $data === null ) {

      $data = array_merge( parent::$map ?? [], self::$map );

    }

    return $data;

  }
}
