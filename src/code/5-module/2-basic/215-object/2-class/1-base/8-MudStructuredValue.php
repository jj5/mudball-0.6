<?php

abstract class MudStructuredValue extends MudComposite implements IMudStructuredValue {

  public function __construct( string $value ) {

    parent::__construct( self::parse( $value ) );

  }

  public static function parse( string $value ) : array {

    return [ $value ];

  }
}
