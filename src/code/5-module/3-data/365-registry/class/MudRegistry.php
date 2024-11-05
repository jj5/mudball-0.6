<?php

class MudRegistry extends MudService {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-23 jj5 - public methods...
  //

  public function register_mud_asset_hash_bin( $hash_bin ) {

    // 2022-05-27 jj5 - THINK: should we construct static "registrators" instead..?

    return $this->register(
      function() use ( $hash_bin ) {
        return mud_raw()->get_a_std_asset_id_by_hash_bin( $hash_bin );
      },
      function() use ( $hash_bin ) {
        return mud_raw()->add_row_t_piece_mud_asset( $hash_bin );
      }
    );

  }

  public function get_mud_asset_hash_bin( $asset_id ) {

    return mud_raw()->get_a_std_asset_hash_bin( $asset_id );

  }

  public function register_mud_http_accept( $http_accept ) {

    $hash_bin = mud_hash_bin( $http_accept );

    return $this->register(
      function() use ( $hash_bin ) {
        return mud_raw()->get_a_std_http_accept_id_by_hash_bin( $hash_bin );
      },
      function() use ( $http_accept, $hash_bin ) {
        return mud_raw()->add_row_t_piece_mud_http_accept( $http_accept, $hash_bin );
      }
    );

  }

  public function get_mud_http_accept( $id ) {

    return mud_raw()->get_a_std_http_accept( $id );

  }

  public function register_mud_jzon_data( $data ) {

    $jzon = mud_jzon_encode( $data, $json );

    $hash_bin = mud_hash_bin( $json );

    return $this->register(
      function() use ( $hash_bin ) {
        return mud_raw()->get_a_std_jzon_id_by_hash_bin( $hash_bin );
      },
      function() use ( $jzon, $hash_bin ) {
        return mud_raw()->add_row_t_piece_mud_jzon( $jzon, $hash_bin );
      }
    );

  }

  public function get_mud_jzon_data( $jzon_id ) {

    $jzon = mud_raw()->get_a_std_jzon_blob( $jzon_id );

    return mud_jzon_decode( $jzon );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-05-23 jj5 - protected methods...
  //

  protected function register( $get, $add ) {

    for ( $try = 1; $try <= 10; $try++ ) {

      $id = $get();

      if ( $id ) { return $id; }

      try {

        return $add();

      }
      catch ( MudDatabaseException $ex ) {

        if ( $ex->getCode() === MUD_ERR_DATABASE_ENTRY_IS_DUPLICATE ) {

          continue;

        }

        throw $ex;

      }
    }

    mud_not_supported();

  }
}
