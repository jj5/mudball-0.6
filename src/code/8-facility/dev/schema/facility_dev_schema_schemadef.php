<?php

class mud_facility_dev_schema_schemadef extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context, [ 'title' => 'schemadef view' ] );

      //var_dump( $def ); exit;

      tag_text( 'h1', 'Schemadef' );

      MudSchemata::Load( $use_cache = false, $def );

      $this->render_schemadef_tables( $def );

      $this->render_schemadef_table_details( $def );

    $this->render_foot( $context );

  }

  protected function render_schemadef_tables( $def ) {

    tag_text( 'h2', 'Tables' );

    tag_open( 'table', [ 'class' => 'nice-table' ] );

      tag_open( 'thead' );

        tag_open( 'tr' );

          tag_text( 'th', '#' );
          tag_text( 'th', 'Schema' );
          tag_text( 'th', 'Revision' );
          tag_text( 'th', 'Table Type' );
          tag_text( 'th', 'Table Name' );
          tag_text( 'th', 'OID' );

        tag_shut( 'tr' );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        $counter = 1;

        foreach ( $def->tab_map as $tab_name => $tab ) {

          tag_open( 'tr' );

            tag_text( 'td', $counter );
            tag_text( 'td', $tab->file_info[ 'schema' ] );
            tag_text( 'td', $tab->file_info[ 'revision' ] );
            tag_text( 'td', $tab->tab_type );

            tag_open( 'td' );

              tag_text( 'a', $tab->tab_name, [ 'href' => '#' . $tab->tab_name ] );

            tag_shut( 'td' );

            tag_text( 'td', $tab->get_oid() );

          tag_shut( 'tr' );

        }

      tag_shut( 'tbody' );

    tag_shut( 'table' );

  }

  protected function render_schemadef_table_details( $def ) {

    tag_text( 'h2', 'Table details' );

    foreach ( $def->tab_map as $tab_name => $tab ) {

      $this->render_table( $tab );

    }
  }

  protected function render_table( $tab ) {

    tag_text( 'h3', $tab->tab_name, [ 'id' => $tab->tab_name ] );

    tag_open( 'table', [ 'class' => 'nice-table' ] );

      tag_open( 'thead' );

        tag_open( 'tr' );

          tag_text( 'th', '#' );
          tag_text( 'th', 'Schema' );
          tag_text( 'th', 'Revision' );
          tag_text( 'th', 'Table Type' );
          tag_text( 'th', 'Table Name' );
          tag_text( 'th', 'Line' );
          tag_text( 'th', 'Column Type' );
          tag_text( 'th', 'Column Name' );
          tag_text( 'th', 'Column OID' );

          tag_text( 'th', 'Is Key?' );
          tag_text( 'th', 'Is Vrt?' );
          tag_text( 'th', 'Is Ref?' );
          tag_text( 'th', 'Is Flg?' );
          tag_text( 'th', 'Is Unique?' );
          tag_text( 'th', 'Is FK?' );

          tag_text( 'th', 'Min' );
          tag_text( 'th', 'Max' );
          tag_text( 'th', 'Nullable?' );
          tag_text( 'th', 'Default' );
          tag_text( 'th', 'Valid' );
          tag_text( 'th', 'Invalid' );
          tag_text( 'th', 'Ref Table' );
          tag_text( 'th', 'Ref Column' );
          tag_text( 'th', 'Flag' );
          tag_text( 'th', 'Is Interaction ID?' );


          tag_text( 'th', 'Column Dump' );

        tag_shut( 'tr' );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        $counter = 1;

        foreach ( $tab->col_map as $col_name => $col ) {

          tag_open( 'tr' );

            tag_text( 'td', $counter );
            tag_text( 'td', $col->file_info[ 'schema' ] );
            tag_text( 'td', $col->file_info[ 'revision' ] );
            tag_text( 'td', $tab->tab_type );
            tag_text( 'td', $tab->tab_name );
            tag_text( 'td', $col->line, [ 'class' => 'right' ] );
            tag_text( 'td', $col->col_type );
            tag_text( 'td', $col->col_name );
            tag_text( 'td', $col->get_oid(), [ 'class' => 'right' ] );

            tag_text( 'td', $col->is_key ? 'key' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->is_vrt ? 'vrt' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->is_ref ? 'ref' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->is_flg ? 'flg' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->is_unique ? 'unique' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->is_fk ? 'FK' : '', [ 'class' => 'center' ] );

            tag_text( 'td', $col->min !== null ? number_format( $col->min ) : '', [ 'class' => 'right' ] );
            tag_text( 'td', $col->max !== null ? number_format( $col->max ) : '', [ 'class' => 'right' ] );
            tag_text( 'td', $col->nullable ? 'null' : '', [ 'class' => 'center' ] );
            tag_text( 'td', $col->default !== MUD_UNSPECIFIED ? $col->default : '' );
            tag_text( 'td', $col->valid );
            tag_text( 'td', $col->invalid );

            tag_open( 'td' );

              if ( $col->ref_tab_name ) {

                tag_text( 'a', $col->ref_tab_name, [ 'href' => '#' . $col->ref_tab_name ] );

              }

            tag_shut( 'td' );

            tag_text( 'td', $col->ref_col_name );
            tag_text( 'td', $col->flag, [ 'class' => 'right' ] );
            tag_text( 'td', $col->is_interaction_id ? 'interaction ID' : '', [ 'class' => 'center' ] );

            tag_open( 'td' );

              //var_dump( $col );

            tag_shut( 'td' );

          tag_shut( 'tr' );

        }

      tag_shut( 'tbody' );

    tag_shut( 'table' );

  }
}

return new mud_facility_dev_schema_schemadef();
