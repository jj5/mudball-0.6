<?php

trait mud_mudballdb_2021_08_30_090715_ident {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - t_ident_std_internal_id
  //

  protected function define_t_ident_std_internal_id() {

    def_tab( 't_ident_std_internal_id' );

    def_key( 'a_std_internal_id_key', DBT_ID8 );
    def_col( 'a_std_internal_id', DBT_IDREF );
    def_col( 'a_std_internal_id_created_on', DBT_CREATED_ON );
    def_col( 'a_std_internal_id_updated_on', DBT_UPDATED_ON );

    def_dat( 't_ident_std_internal_id',
      [
        'a_std_internal_id' => null,
      ], [
      [ 1337 ],
    ]);

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - t_ident_std_internal_id_allocation
  //

  protected function define_t_ident_std_internal_id_allocation() {

    def_tab( 't_ident_std_internal_id_allocation' );

    def_key( 'a_std_internal_id_allocation_id', DBT_ID );
    def_col( 'a_std_internal_id_allocation_from', DBT_IDREF );
    def_col( 'a_std_internal_id_allocation_thru', DBT_IDREF );
    def_col( 'a_std_internal_id_allocation_range', DBT_UINT16 );
    def_ref( 'a_std_internal_id_allocation_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_internal_id_allocation_created_on', DBT_CREATED_ON );
    def_col( 'a_std_internal_id_allocation_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_internal_id_allocation_from', 'a_std_internal_id_allocation_thru' ], MUD_IDX_UNIQUE );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-20 jj5 - t_ident_std_external_id
  //

  protected function define_t_ident_std_external_id() {

    def_tab( 't_ident_std_external_id' );

    def_key( 'a_std_external_id_internal_id', DBT_IDREF );
    def_col( 'a_std_external_id', DBT_UINT64 );
    def_ref( 'a_std_external_id_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_external_id_created_on', DBT_CREATED_ON );
    def_col( 'a_std_external_id_updated_on', DBT_UPDATED_ON );

    //def_idx( [ 'a_std_external_id_internal_id' ], MUD_IDX_UNIQUE );
    def_idx( [ 'a_std_external_id' ], MUD_IDX_UNIQUE );

  }

}
