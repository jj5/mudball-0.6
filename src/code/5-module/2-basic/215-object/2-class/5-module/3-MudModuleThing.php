<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2024-06-29 jj5 - class definition...
//

class MudModuleThing extends MudModuleValue {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - protected fields...
  //

  protected array $thing_list = [];

  protected int $thing_count = 0;

  protected int $thing_size = 0;

<<<<<<< HEAD
  protected IMudNullObject $null_thing;

=======
>>>>>>> e3a066e (Work, work...)

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - constructor...
  //

<<<<<<< HEAD
  public function __construct() {

    parent::__construct();

    $this->null_thing = new MudNullObject();
=======
  public function __construct( MudModuleThing|null $previous = null) {

    parent::__construct( $previous );

    $this->null_thing = $this->new_null_thing();
>>>>>>> e3a066e (Work, work...)

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-06-29 jj5 - public instance methods...
  //

  public function new_thing( string $class, array $child_list ) : IMudThing {

    $new_thing = new $class( $child_list );

    $this->thing_count += 1;

    if ( DEBUG ) { $this->thing_size += $this->get_size( $new_thing ); }

    $this->thing_list[] = $new_thing;

    $this->add_object( $new_thing );

    return $new_thing;

  }
}
