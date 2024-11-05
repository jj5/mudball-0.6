<?php

class MudDalClassGenerator extends MudDalGeneratorBase {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-02-22 jj5 - public methods...
  //

  function gen_class( $traits_list, &$file_list ) {

    sort( $traits_list );

    $file = 'dal-class.php';

    $path = $this->get_path( $file );

    $file_list[] = $file;

    $this->report( 'generating ' . $path );

    ob_start();

    $this->print_header();

    $this->print_class_trn( $traits_list );

    $this->print_class_raw( $traits_list );

    //$this->print_class_emu( $traits_list );
    //$this->print_class_aux( $traits_list );
    //$this->print_class_dba( $traits_list );

    $code = ob_get_clean();

    file_put_contents( $path, $code );

  }

  function print_ent( $traits_list ) {

    foreach ( $traits_list as $traits ) :
      if ( strpos( $traits, 'MudDal_t_abinitio_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_about_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_lookup_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_static_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_detail_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_config_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_ident_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_particle_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_piece_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_value_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_domain_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_log_' ) === 0 ) { continue; }
?>
  use <?= $traits ?>;
<?php
    endforeach;

  }

  function print_log( $traits_list ) {

    foreach ( $traits_list as $traits ) :
      if ( strpos( $traits, 'MudDal_t_entity_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_ephemeral_' ) === 0 ) { continue; }
      if ( strpos( $traits, 'MudDal_t_event_' ) === 0 ) { continue; }
?>
  use <?= $traits ?>;
<?php
    endforeach;

  }

  function print_all( $traits_list ) {

    foreach ( $traits_list as $traits ) :
?>
  use <?= $traits ?>;
<?php
    endforeach;

  }

  function print_class_trn( $traits_list ) {

?>
class AppDalTrnGen extends MudDalTrn {
  use MudDataAccessLayerValidation;
<?php
    $this->print_ent( $traits_list );
?>
}
<?php

  }

  function print_class_raw( $traits_list ) {

?>
class AppDalRawGen extends MudDalRaw {
  use MudDataAccessLayerValidation;
<?php
    $this->print_log( $traits_list );
?>
}
<?php

  }

  function print_class_emu( $traits_list ) {

?>
class AppDalEmuGen extends MudDalEmu {
  use MudDataAccessLayerValidation;
<?php
    $this->print_log( $traits_list );
?>
}
<?php

  }

  function print_class_aux( $traits_list ) {

?>
class AppDalAuxGen extends MudDalAux {
  use MudDataAccessLayerValidation;
<?php
    $this->print_log( $traits_list );
?>
}
<?php

  }

  function print_class_dba( $traits_list ) {

?>
class AppDalDbaGen extends MudDalDba {
  use MudDataAccessLayerValidation;
<?php
    $this->print_all( $traits_list );
?>
}
<?php
  }
}
