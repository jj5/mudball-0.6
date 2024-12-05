<?php

class MudModuleDal extends MudModuleData {


<<<<<<< HEAD
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleDal|null $previous = null) {

    parent::__construct( $previous );

  }


>>>>>>> e3a066e (Work, work...)
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_database_raw() {

<<<<<<< HEAD
    return MudDatabaseRaw::Create();

=======
    return new MudDatabaseRaw();
    
>>>>>>> e3a066e (Work, work...)
  }


}
