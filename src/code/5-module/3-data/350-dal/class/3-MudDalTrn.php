<?php

class MudDalTrn extends MudDal {

  use MudDalCentral;

  public function __construct() { parent::__construct( APP_SERVICE_DAL_TRN ); }

  public function is_raw() { return false; }
  public function is_trn() { return true; }
  public function is_emu() { return false; }
  public function is_aux() { return false; }
  public function is_dba() { return false; }

  public function log_history(
    $tab_name,
    $crud_enum,
    $row
  ) {

    $this->validate_field( A_STD_CRUD_ENUM, $crud_enum );

    $this->use_database( $prefix, $pdo );

    $table = "{$prefix}{$tab_name}";

    $name_parts = explode( '_', $tab_name, 3 );
    $short_name = $name_parts[ 2 ];

    $data_tab_name = "{$prefix}{$tab_name}";
    $hist_tab_name = "{$prefix}t_history_{$short_name}";

    $this->ensure_safe( $data_tab_name );
    $this->ensure_safe( $hist_tab_name );

    $row_params = '';
    $params = [
      ':interaction_id' => $this->get_interaction_id(),
      ':crud_enum' => $crud_enum,
    ];

    $col_number = 0;

    foreach ( $row as $col => $val ) {

      $col_number++;

      // 2022-04-05 jj5 - we skip the second column, which is the rowversion...
      //
      if ( $col_number === 2 ) { continue; }

      $is_first = $row_params === '';

      if ( ! $is_first ) { $row_params .= ",\n        "; }

      $param = ":$col";

      $row_params .= $param;

      $params[ $param ] = $val;

    }

    $sql = "
      insert into {$hist_tab_name} values (
        null,
        :interaction_id,
        :crud_enum,
        $row_params
      )
    ";

    return $pdo->run_insert_id( $sql, $params );

  }

  protected function new_database() { return new_mud_database_trn(); }

}
