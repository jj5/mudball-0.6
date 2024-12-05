<?php

class MudModuleDatabase extends MudModuleData {


<<<<<<< HEAD
=======
  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleDatabase|null $previous = null) {

    parent::__construct( $previous );

  }


>>>>>>> e3a066e (Work, work...)
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_database_exception( $message, $code, $previous, $name, $hint, $data ) {

<<<<<<< HEAD
    return MudDatabaseException::Create( $message, $code, $previous, $name, $hint, $data );
=======
    return new MudDatabaseException( $message, $code, $previous, $name, $hint, $data );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_database_raw( array $args = [] ) {

<<<<<<< HEAD
    return MudDatabaseRaw::Create( $args );
=======
    return new MudDatabaseRaw( $args );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_database_trn( array $args = [] ) {

<<<<<<< HEAD
    return MudDatabaseTrn::Create( $args );
=======
    return new MudDatabaseTrn( $args );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_database_emu( array $args = [] ) {

<<<<<<< HEAD
    return MudDatabaseEmu::Create( $args );
=======
    return new MudDatabaseEmu( $args );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_database_aux( array $args = [] ) {

<<<<<<< HEAD
    return MudDatabaseAux::Create( $args );
=======
    return new MudDatabaseAux( $args );
>>>>>>> e3a066e (Work, work...)

  }

  public function new_mud_database_dba( array $args = [] ) {

<<<<<<< HEAD
    return MudDatabaseDba::Create( $args );
=======
    return new MudDatabaseDba( $args );
>>>>>>> e3a066e (Work, work...)

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-03-06 jj5 - public instance methods...
  //

  public function register_new_connection( string $connection_type, MudDatabase $database ) {

    mud_interaction()->register_new_connection( $connection_type, $database );

    return true;

  }
}
