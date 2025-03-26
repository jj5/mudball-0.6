<?php

class MudModuleModel extends MudModuleBasic {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-26 jj5 - fields...
  //

  protected $builder_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-26 jj5 - public methods...
  //

  public function load( string $model_namespace, string $model_name, string $path ) {

    if ( ! defined( 'DBT_AID' ) ) {

      define( 'DBT_AID', DBT_ID32 );
      define( 'DBT_AIDREF', DBT_UINT32 );

    }

    if ( ! defined( 'DBT_IID' ) ) {

      define( 'DBT_IID', DBT_UINT32 );

    }

    if ( ! defined( 'DBT_XID' ) ) {

      define( 'DBT_XID', DBT_INT64 );

    }

    assert( ! isset( $this->model_map[ $model_name ] ) );

    $path = realpath( $path );

    $builder = new MudModelBuilder( $model_name, $model_namespace, $path );

    $this->builder_map[ $model_name ] = $builder;

    $builder->load();

    return $builder;

  }
}
