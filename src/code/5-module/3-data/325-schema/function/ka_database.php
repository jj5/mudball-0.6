<?php

function ka_database( $name ) {

  static $map = [];

  if ( ! isset( $map[ $name ] ) ) {

    $map[ $name ] = new Kickass\SchemaDatabase( $name );

  }

  return $map[ $name ];

}
