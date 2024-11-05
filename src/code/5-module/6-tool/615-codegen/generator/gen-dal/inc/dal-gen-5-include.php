<?php

class MudDalIncludeGenerator extends MudDalGeneratorBase {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //


  function gen_include( $file_list ) {

    global $target;

    $file = 'include.php';

    $path = $this->get_path( $file );

    $this->report( 'generating ' . $path );

    ob_start();

    $this->print_include( $file_list );

    $code = ob_get_clean();

    file_put_contents( $path, $code );

  }

  function print_include( $file_list ) {

    global $target;

    $this->print_header();

    foreach ( $file_list as $file ) :

      $path = $this->get_path( $file );

      if ( ! file_exists( $path ) ) {

        // 2021-03-31 jj5 - NOTE: this can happen because e.g. history tables which aren't handled
        // by themselves but with their entity table.

        continue;

      }

?>

if ( file_exists( __DIR__ . '/<?= $file ?>' ) ) {

  require_once __DIR__ . '/<?= $file ?>';

}

<?php

    endforeach;

?>
if ( ! class_exists( 'AppDalRawGen' ) ) {

  class AppDalRawGen extends MudDalRaw { }

}

if ( ! class_exists( 'AppDalTrnGen' ) ) {

  class AppDalTrnGen extends MudDalTrn { }

}

if ( ! class_exists( 'AppDalEmuGen' ) ) {

  class AppDalEmuGen extends MudDalEmu { }

}

if ( ! class_exists( 'AppDalAuxGen' ) ) {

  class AppDalAuxGen extends MudDalAux { }

}

if ( ! class_exists( 'AppDalDbaGen' ) ) {

  class AppDalDbaGen extends MudDalDba { }

}
<?php

  }
}
