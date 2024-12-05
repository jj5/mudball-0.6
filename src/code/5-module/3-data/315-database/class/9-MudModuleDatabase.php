<?php

class MudModuleDatabase extends MudModuleData {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_database_exception( $message, $code, $previous, $name, $hint, $data ) {

    return MudDatabaseException::Create( $message, $code, $previous, $name, $hint, $data );

  }

  public function new_mud_database_raw( array $args = [] ) {

    return MudDatabaseRaw::Create( $args );

  }

  public function new_mud_database_trn( array $args = [] ) {

    return MudDatabaseTrn::Create( $args );

  }

  public function new_mud_database_emu( array $args = [] ) {

    return MudDatabaseEmu::Create( $args );

  }

  public function new_mud_database_aux( array $args = [] ) {

    return MudDatabaseAux::Create( $args );

  }

  public function new_mud_database_dba( array $args = [] ) {

    return MudDatabaseDba::Create( $args );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  public function register_new_connection( string $connection_type, MudDatabase $database ) {

    mud_interaction()->register_new_connection( $connection_type, $database );

    return true;

  }
}
