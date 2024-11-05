<?php

class MudModuleDatabase extends MudModuleData {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleDatabase|null $previous = null) {

    parent::__construct( $previous );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_database_exception( $message, $code, $previous, $name, $hint, $data ) {

    return new MudDatabaseException( $message, $code, $previous, $name, $hint, $data );

  }

  public function new_mud_database_raw( array $args = [] ) {

    return new MudDatabaseRaw( $args );

  }

  public function new_mud_database_trn( array $args = [] ) {

    return new MudDatabaseTrn( $args );

  }

  public function new_mud_database_emu( array $args = [] ) {

    return new MudDatabaseEmu( $args );

  }

  public function new_mud_database_aux( array $args = [] ) {

    return new MudDatabaseAux( $args );

  }

  public function new_mud_database_dba( array $args = [] ) {

    return new MudDatabaseDba( $args );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  public function register_new_connection( string $connection_type, MudDatabase $database ) {

    mud_interaction()->register_new_connection( $connection_type, $database );

    return true;

  }
}
