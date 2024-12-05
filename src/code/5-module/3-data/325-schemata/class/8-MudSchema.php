<?php

class MudSchema extends MudService {


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-04-10 jj5 - private fields...
  //

  private $schemata = null;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

<<<<<<< HEAD
  public function __construct() {

    parent::__construct();
=======
  public function __construct( MudSchema|null $previous = null ) {

    parent::__construct( $previous );
>>>>>>> e3a066e (Work, work...)

    $this->schemata = mud_schemata();

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======

  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-04-10 jj5 - public methods...
  //

  public function get_tab( $tab_name ) {

    return $this->get_schemata()->get_tab( $tab_name );

  }

  public function get_col( $col_name ) {

    return $this->get_schemata()->get_col( $col_name );

  }

  public function get_tab_col( $tab_name, $col_name ) {

    return $this->get_schemata()->get_tab_col( $tab_name, $col_name );

  }

  public function get_db_value( $col_name, $value ) {

    return $this->get_schemata()->get_db_value( $col_name, $value );

  }

  public function get_app_value( $col_name, $value ) {

    return $this->get_schemata()->get_app_value( $col_name, $value );

  }

  public function validate( $col_name, $value ) {

    return $this->get_schemata()->validate( $col_name, $value );

  }

  public function is_valid( $col_name, $value, &$problem = null, &$error = null ) {

    return $this->get_schemata()->is_valid( $col_name, $value, $problem, $error );

  }

  public function get_human_name( $col_name ) {

    return $this->get_schemata()->get_human_name( $col_name );

  }


<<<<<<< HEAD
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
=======
  ///////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> e3a066e (Work, work...)
  // 2022-04-10 jj5 - protected methods...
  //

  protected function get_schemata() { return $this->schemata; }

}
