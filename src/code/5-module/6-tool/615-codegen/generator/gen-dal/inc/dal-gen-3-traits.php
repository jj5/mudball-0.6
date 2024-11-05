<?php

class MudDalTraitsGenerator extends MudDalGeneratorBase {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //

  function gen_traits( $schemata, &$traits_list, &$file_list ) {

    $file = 'dal-traits.php';

    $path = $this->get_path( $file );

    $file_list[] = $file;

    $this->report( 'generating ' . $path );

    ob_start();

    $this->print_header();

    foreach ( $schemata->tab_map as $table ) {

      $this->print_traits_for_table( $table, $traits_list );

    }

    $code = ob_get_clean();

    file_put_contents( $path, $code );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - protected methods...
  //

  protected function create_generator( $class, $allow_delete = true, $allow_update = true ) {

  }

  protected function print_traits_for_table( $table, &$traits_list ) {

    static $map = null;

    if ( $map === null ) {

      $map = [
        'abinitio' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'lookup' => new MudDalTraitsGeneratorLookup( $this->get_host(), $allow_create = false, $allow_update = false, $allow_delete = false ),
        'static' => new MudDalTraitsGeneratorLookup( $this->get_host(), $allow_create = false, $allow_update = false, $allow_delete = false ),
        'about' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        'config' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        'detail' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        'ident' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = false ),
        'particle' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'piece' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'value' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'domain' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'entity' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        //'entity' => new MudDalTraitsGeneratorEntity( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        'history' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false, $no_getters = true ),
        'ephemeral' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = true, $allow_delete = true ),
        'event' => new MudDalTraitsGeneratorStandard( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
        'log' => new MudDalTraitsGeneratorLog( $this->get_host(), $allow_create = true, $allow_update = false, $allow_delete = false ),
      ];

    }

    $generator = $map[ $table->get_type() ] ?? null;

    if ( $generator === null ) {

      // 2022-02-22 jj5 - TEMP: just ignore this for now...

      return false;

    }

    return $generator->print_traits( $table, $traits_list );

  }
}
