<?php

class MudModuleConnection extends MudModuleData {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - factory methods...
  //

  public function new_mud_database_exception( $message, $code, $previous, $name, $hint, $data ) {

    return MudConnectionException::Create( $message, $code, $previous, $name, $hint, $data );

  }

  public function new_mud_database_raw( array $args = [] ) {

    return MudConnectionRaw::Create( $args );

  }

  public function new_mud_database_trn( array $args = [] ) {

    return MudConnectionTrn::Create( $args );

  }

  public function new_mud_database_emu( array $args = [] ) {

    return MudConnectionEmu::Create( $args );

  }

  public function new_mud_database_aux( array $args = [] ) {

    return MudConnectionAux::Create( $args );

  }

  public function new_mud_database_dba( array $args = [] ) {

    return MudConnectionDba::Create( $args );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  public function register_new_connection( string $connection_type, MudConnection $database ) {

    mud_interaction()->register_new_connection( $connection_type, $database );

    return true;

  }
}
