<?php

class mud_facility_dev_app_info extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context );

      $software_map = app_interaction()->get_software_map();

      foreach ( $software_map as $heading => $software_info ) {

        tag_text( 'h2', $heading );

        tag_open( 'dl' );

          foreach ( $software_info as $key => $val ) {

            tag_text( 'dt', $key );
            tag_text( 'dd', $val );

          }

        tag_shut( 'dl' );

      }

      // 2022-04-10 jj5 - NOTE: the modules and services reported here will simply be the ones
      // loaded for this particular request...

      tag_text( 'h2', 'Modules' );

      if ( count( MudModule::$module_info_map ) ) {

        tag_open( 'dl' );

          foreach ( MudModule::$module_info_map as $module => $class ) {

            tag_text( 'dt', $module );
            tag_text( 'dd', $class );

          }

        tag_shut( 'dl' );

      }
      else {

        tag_text( 'p', 'No modules loaded.' );

      }

      tag_text( 'h2', 'Services' );

      if ( count( MudService::$service_info_map ) ) {

        tag_open( 'dl' );

          foreach ( MudService::$service_info_map as $service => $class ) {

            tag_text( 'dt', $service );
            tag_text( 'dd', $class );

          }

        tag_shut( 'dl' );

      }
      else {

        tag_text( 'p', 'No services loaded.' );

      }

    $this->render_foot( $context );

  }
}

return new mud_facility_dev_app_info();
