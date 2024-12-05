<?php

class MudDalConstGenerator extends MudDalGeneratorBase {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //

  function gen_consts( $schemata, &$file_list ) {

    $file = 'dal-consts.php';

    $path = $this->get_path( $file );

    $file_list[] = $file;

    $this->report( 'generating ' . $path );

    ob_start();

    $this->print_consts( $schemata );

    $code = ob_get_clean();

    file_put_contents( $path, $code );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - protected methods...
  //

  protected function print_consts( $schemata ) {

    $const_map = [];

    foreach ( $schemata->tab_map as $table ) {

      $name = $table->get_name();

      $const_map[ strtoupper( $name ) ] = $name;

      foreach ( $table->col_map as $column ) {

        $name = $column->get_name();

        $const_map[ strtoupper( $name ) ] = $name;

      }
    }

    $this->print_header();

    foreach ( $const_map as $name => $definition ) {

      if ( strpos( $name, 'T_' ) === 0 ) { echo "\n"; }

      $this->print_const( "'$name'", "'$definition'" );

    }
  }

  protected function print_const( $name, $definition ) {
?>
  define( <?= $name ?>, <?= $definition ?> );
<?php
  }
}
