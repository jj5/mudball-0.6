<?php

class mud_facility_dev_schema_info extends MudFacility {

  public function get_selector_spec() { return [ 'a', 'b', 'c' ]; }

  public function render( $context ) {

    $this->render_head( $context );

      //var_dump( $context->get_selector() );

      tag_open( 'ul' );

        tag_open( 'li' );

          $href = app_url()->get_rel( '/dev/schema/schemadecl' );

          tag_text( 'a', 'view schemadecl', [ 'href' => $href ] );

        tag_shut( 'li' );

        tag_open( 'li' );

          $href = app_url()->get_rel( '/dev/schema/schemadef' );

          tag_text( 'a', 'view schemadef', [ 'href' => $href ] );

        tag_shut( 'li' );

        tag_open( 'li' );

          $href = app_url()->get_rel( '/dev/schema/schemata' );

          tag_text( 'a', 'view schemata', [ 'href' => $href ] );

        tag_shut( 'li' );

      tag_shut( 'ul' );

      $info = MudSchemata::Load( $use_cache = false )->get_info();

      foreach ( $info as $schema_info ) {

        tag_open( 'dl' );

          foreach ( $schema_info as $key => $val ) {

            tag_text( 'dt', $key );
            tag_text( 'dd', $val );

          }

        tag_shut( 'dl' );

      }

    $this->render_foot( $context );

  }
}

return new mud_facility_dev_schema_info();
