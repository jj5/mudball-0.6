<?php

abstract class MudComposite extends MudValue implements IMudComposite {

  private array $parts;

  public function __construct( array $parts ) {

    parent::__construct();

    $this->parts = $parts;

  }

  public function get_parts() {

    return $this->parts;

  }

  public function get_part( int $index ) {

    return $this->parts[ $index ];

  }
}
