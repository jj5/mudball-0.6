<?php

trait mud_mudballdb_2021_08_30_090715_product {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-07-05 jj5 - t_product_std_address
  //

  protected function define_t_product_std_address() {

    def_tab( 't_product_std_address' );

    def_key( 'a_std_address_id', DBT_ID );
    def_col( 'a_std_address_hash_bin', DBT_HASH_BIN );
    def_vrt( 'a_std_address_hash_hex', DBT_HASH_HEX );
    def_col( 'a_std_address_line_1', DBT_UTF8_CI );
    def_col( 'a_std_address_line_2', DBT_UTF8_CI );
    def_col( 'a_std_address_city', DBT_UTF8_CI );
    def_col( 'a_std_address_state', DBT_UTF8_CI );
    def_col( 'a_std_address_postcode', DBT_UTF8_CI );
    def_ref( 'a_std_address_country_enum', 't_lookup_std_country', 'a_std_country_enum' );
    def_ref( 'a_std_address_created_in', 't_abinitio_std_interaction', 'a_std_interaction_id' );
    def_col( 'a_std_address_created_on', DBT_CREATED_ON );
    def_col( 'a_std_address_updated_on', DBT_UPDATED_ON );

    def_idx( [ 'a_std_address_hash_bin' ], MUD_IDX_UNIQUE );

  }
}
