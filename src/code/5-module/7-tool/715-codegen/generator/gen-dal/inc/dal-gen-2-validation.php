<?php

class MudDalValidationGenerator extends MudDalGeneratorBase {

  function gen_validation( $schemata, &$file_list ) {

    $file = 'dal-validation.php';

    $path = $this->get_path( $file );

    $file_list[] = $file;

    $this->report( 'generating ' . $path );

    ob_start();

    $this->print_validation( $schemata );

    $code = ob_get_clean();

    file_put_contents( $path, $code );

  }

  function print_validation( $schemata ) {

    $this->print_header();

?>
  trait MudDataAccessLayerValidation {

<?php

    foreach ( $schemata->col_map as $col ) :

      if ( $col->is_auto() ) { continue; }

      // 2021-03-30 jj5 - NOTE: validators are generated for virtual columns too

      $function_name = 'validate_' . $col->get_name();
      $cast_function = $col->get_cast_function();

      $min = $col->get_min();
      $max = $col->get_max();
      $valid = $col->get_valid();
      $invalid = $col->get_invalid();

?>
    public function <?= $function_name ?>( &$value, $ignore_null = false ) {

      // generated by <?= $this->get_generated_by( __FILE__, __LINE__ ) ?>

      if ( $value === null ) {

        if ( $ignore_null ) { return; }

<?php
        if ( $col->get_nullable() ) :
?>
        return;

<?php
        else :
?>
        mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] );

<?php
        endif;
?>
      }

      $value = <?= $cast_function ?>( $value );

<?php
      if ( $min !== null && ( $col->is_ascii() || $col->is_binary() ) ) :

        if ( $min !== 0 ) :
?>
      if ( strlen( $value ) < <?= $min ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
        endif;

      elseif ( $min !== null && $col->is_unicode() ) :

        if ( $min !== 0 ) :
?>
      if ( mb_strlen( $value ) < <?= $min ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
        endif;

      elseif ( $min !== null ) :
?>
      if ( $value < <?= $min ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      endif;

      if ( $max !== null && ( $col->is_ascii() || $col->is_binary() ) ) :
?>
      if ( strlen( $value ) > <?= $max ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      elseif ( $max !== null && $col->is_unicode() ) :
?>
      if ( mb_strlen( $value ) > <?= $max ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      elseif ( $max !== null ) :
?>
      if ( $value > <?= $max ?> ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      endif;

      if ( $valid ) :
?>
      if ( ! preg_match( '<?= $this->quote( $valid ) ?>', $value ) ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      endif;

      if ( $invalid ) :
?>
      if ( preg_match( '<?= $this->quote( $invalid ) ?>', $value ) ) { mud_fail( MUD_ERR_DAL_VALUE_IS_INVALID, [ '$value' => $value ] ); }

<?php
      endif;
?>
    }

<?php

    endforeach;

?>

  }
<?php

  }
}