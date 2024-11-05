<?php

class mud_facility_dev_schema_schemata extends MudFacility {

  public function get_selector_spec() { return []; }

  public function render( $context ) {

    $this->render_head( $context, [ 'title' => 'schemata view' ] );

    $this->render_test_content( $context );

    $schemata = MudSchemata::Load( $use_cache = false );

    $this->render_schemata( $context, $schemata );

    $this->render_foot( $context );

  }

  protected function render_test_content( $context ) {

    tag_open( 'p' );
      tag_text( 'a', 'home', [ 'href' => app_url()->get_rel( '/home' ) ] );
      out_text( ' | ' );
      tag_text( 'a', 'favicon.ico', [ 'href' => app_url()->res( '/res/image/favicon.ico' ), 'target' => 'iframe' ] );
      out_text( ' | ' );
      tag_text( 'a', 'style.css', [ 'href' => app_url()->res( '/res/style' ), 'target' => 'iframe' ] );
      out_text( ' | ' );
      tag_text( 'a', 'script.js', [ 'href' => app_url()->res( '/res/script' ), 'target' => 'iframe' ] );
    tag_shut( 'p' );

    tag_bare( 'iframe', [ 'name' => 'iframe' ] );

  }

  protected function render_schemata( $context, $schemata ) {

    tag_text( 'h1', 'Schemata' );

    tag_open( 'table', [ 'class' => 'nice-table' ] );

      /*
      tag_open( 'tr' );
        tag_text( 'th', 'Revision' );
        tag_text( 'td', $schemata->revision );
      tag_shut( 'tr' );

      tag_open( 'tr' );
        tag_text( 'th', 'Revision Number' );
        tag_text( 'td', $schemata->revision_number );
      tag_shut( 'tr' );

      tag_open( 'tr' );
        tag_text( 'th', 'Tables' );
        tag_text( 'td', count( $schemata->tab_map ) );
      tag_shut( 'tr' );
      */

      tag_open( 'thead' );

        tag_open( 'tr' );

          tag_text( 'th', 'Schema' );
          tag_text( 'th', 'Revision' );
          tag_text( 'th', 'Revision Number' );

        tag_shut( 'tr' );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        foreach ( $schemata->get_rev_map() as $schema_name => $revision_number ) :

          // 2022-03-06 jj5 - here's an excuse to take our formatting functions for a spin...

          $revision_code = mud_format_as_revision_code( $revision_number );

          tag_open( 'tr' );

            tag_text( 'td', $schema_name );
            tag_text( 'td', mud_format_as_revision_code( $revision_number ) );
            tag_text( 'td', mud_format_as_revision_number( $revision_code ) );

          tag_shut( 'tr' );

        endforeach;

      tag_shut( 'tbody' );

    tag_shut( 'table' );

    tag_text( 'h2', 'Tables' );

    tag_open( 'table', [ 'class' => 'nice-table' ] );

      tag_open( 'thead' );

        tag_open( 'tr' );

          tag_text( 'th', '#' );
          tag_text( 'th', 'Schema' );
          tag_text( 'th', 'Revision' );
          //tag_text( 'th', 'Revision Number' );
          //tag_text( 'th', 'Revision File' );
          tag_text( 'th', 'File' );
          tag_text( 'th', 'Line' );
          tag_text( 'th', 'OID' );
          tag_text( 'th', 'Table Name' );
          tag_text( 'th', 'Table Type' );

        tag_shut( 'tr' );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        $counter = 1;

        foreach ( $schemata->tab_map as $tab_name => $tab ) {

          tag_open( 'tr' );

            tag_text( 'td', $counter++, [ 'class' => 'right' ] );
            tag_text( 'td', $tab->schema );
            tag_text( 'td', $tab->revision );
            //tag_text( 'td', $tab->revision_number );
            //tag_text( 'td', $tab->revision_file );
            tag_text( 'td', $tab->file );
            tag_text( 'td', $tab->line, [ 'class' => 'right' ] );

            tag_text( 'td', $tab->get_oid() );
            //tag_text( 'td', get_class( $tab ) );

            tag_open( 'td' );

              tag_text( 'a', $tab->tab_name, [ 'href' => '#' . $tab->tab_name ] );

            tag_shut( 'td' );

            tag_text( 'td', $tab->tab_type );

          tag_shut( 'tr' );

        }

      tag_shut( 'tbody' );

    tag_shut( 'table' );

    foreach ( $schemata->tab_map as $tab_name => $tab ) {

      $this->render_tab( $context, $tab );

    }
  }

  protected function render_tab( $context, $tab ) {

    tag_text( 'h2', $tab->get_name(), [ 'id' => $tab->get_name() ] );

    tag_open( 'table', [ 'class' => 'nice-table' ] );

      tag_open( 'thead' );

        tag_open( 'tr' );

          tag_text( 'th', '#' );
          tag_text( 'th', 'Schema' );
          tag_text( 'th', 'Revision' );
          //tag_text( 'th', 'Revision Number' );
          //tag_text( 'th', 'Revision File' );
          tag_text( 'th', 'File' );
          tag_text( 'th', 'Line' );
          tag_text( 'th', 'Table Name' );
          tag_text( 'th', 'Table Type' );

          tag_text( 'th', 'Column Name' );
          tag_text( 'th', 'Column Type' );

          tag_text( 'th', 'Is Key' );
          tag_text( 'th', 'Is Vrt' );
          tag_text( 'th', 'Is Ref' );
          tag_text( 'th', 'Is Flg' );

          tag_text( 'th', 'Is Unique' );
          tag_text( 'th', 'Is FK' );

          tag_text( 'th', 'Min' );
          tag_text( 'th', 'Max' );
          tag_text( 'th', 'Nullable?' );
          tag_text( 'th', 'Default' );
          tag_text( 'th', 'Valid' );
          tag_text( 'th', 'Invalid' );

          tag_text( 'th', 'Ref Table' );
          tag_text( 'th', 'Ref Column' );

          tag_text( 'th', 'Flag' );

          tag_text( 'th', 'Prop' );
          tag_text( 'th', 'Const' );
          tag_text( 'th', 'Cast Function' );
          tag_text( 'th', 'Is ASCII?' );
          tag_text( 'th', 'Is Unicode?' );
          tag_text( 'th', 'Is Binary?' );
          tag_text( 'th', 'String Type' );
          tag_text( 'th', 'Is Interaction ID?' );
          tag_text( 'th', 'Is Auto Inc?' );
          tag_text( 'th', 'Is Auto?' );
          tag_text( 'th', 'Classes' );
          tag_text( 'th', 'Human Name' );
          tag_text( 'th', 'Database Type' );
          tag_text( 'th', 'App Type' );

        tag_shut( 'tr' );

      tag_shut( 'thead' );

      tag_open( 'tbody' );

        $counter = 1;

        foreach ( $tab->col_map as $col_name => $col ) {

          tag_open( 'tr' );

            tag_text( 'td', $counter++, [ 'class' => 'right' ] );
            tag_text( 'td', $col->schema );
            tag_text( 'td', $col->revision );
            //tag_text( 'td', $col->revision_number );
            //tag_text( 'td', $col->revision_file );
            tag_text( 'td', $col->file );
            tag_text( 'td', $col->line, [ 'class' => 'right' ] );
            tag_text( 'td', $col->tab_name );
            tag_text( 'td', $col->tab_type );

            tag_text( 'td', $col->col_name );
            tag_text( 'td', $col->col_type );

            tag_text( 'td', $col->is_key ? 'key' : '' );
            tag_text( 'td', $col->is_vrt ? 'vrt' : '' );
            tag_text( 'td', $col->is_ref ? 'ref' : '' );
            tag_text( 'td', $col->is_flg ? 'flg' : '' );

            tag_text( 'td', $col->is_unique ? 'unique' : '' );
            tag_text( 'td', $col->is_fk ? 'FK' : '' );

            tag_text( 'td', $col->min );
            tag_text( 'td', $col->max );
            tag_text( 'td', $col->nullable ? 'nullable' : '' );
            tag_text( 'td', $col->default === MUD_UNSPECIFIED ? '' : $col->default );
            tag_text( 'td', $col->valid );
            tag_text( 'td', $col->invalid );

            //tag_text( 'td', $col->ref_tab_name );

            tag_open( 'td' );

              tag_text( 'a', $col->ref_tab_name, [ 'href' => '#' . $col->ref_tab_name ] );

            tag_shut( 'td' );

            tag_text( 'td', $col->ref_col_name );

            tag_text( 'td', $col->flag );

            tag_text( 'td', $col->prop );
            tag_text( 'td', $col->const );
            tag_text( 'td', $col->cast_function );
            tag_text( 'td', $col->is_ascii ? 'ascii' : '' );
            tag_text( 'td', $col->is_unicode ? 'unicode' : '' );
            tag_text( 'td', $col->is_binary ? 'binary' : '' );
            tag_text( 'td', $col->string_type );
            tag_text( 'td', $col->is_interaction_id ? 'interaction_id' : '' );
            tag_text( 'td', $col->is_auto_inc ? 'autoinc' : '' );
            tag_text( 'td', $col->is_auto ? 'auto' : '' );
            tag_text( 'td', implode( ', ', $col->classes ) );
            tag_text( 'td', $col->human_name );

            tag_text( 'td', $col->db_datatype );
            tag_text( 'td', $col->app_datatype );

          tag_shut( 'tr' );

        }

      tag_shut( 'tbody' );

    tag_shut( 'table' );

    if ( count( $tab->idx_map ) ) {

      tag_text( 'h3', $tab->get_name() . ' indexes' );

      tag_open( 'table', [ 'class' => 'nice-table' ] );

        tag_open( 'thead' );

          tag_open( 'tr' );

            tag_text( 'th', '#' );
            tag_text( 'th', 'Schema' );
            tag_text( 'th', 'Revision' );
            //tag_text( 'th', 'Revision Number' );
            //tag_text( 'th', 'Revision File' );
            tag_text( 'th', 'File' );
            tag_text( 'th', 'Line' );
            tag_text( 'th', 'Table Name' );
            tag_text( 'th', 'Table Type' );

            tag_text( 'th', 'Index Name' );
            tag_text( 'th', 'Index Type' );

            tag_text( 'th', 'Columns' );

          tag_shut( 'tr' );

        tag_shut( 'thead' );

        tag_open( 'tbody' );

          $counter = 1;

          foreach ( $tab->idx_map as $idx_name => $idx ) {

            tag_open( 'tr' );

              tag_text( 'td', $counter++, [ 'class' => 'right' ] );
              tag_text( 'td', $idx->schema );
              tag_text( 'td', $idx->revision );
              //tag_text( 'td', $idx->revision_number );
              //tag_text( 'td', $idx->revision_file );
              tag_text( 'td', $idx->file );
              tag_text( 'td', $idx->line, [ 'class' => 'right' ] );
              tag_text( 'td', $idx->tab_name );
              tag_text( 'td', $idx->tab_type );

              tag_text( 'td', $idx->idx_name );
              tag_text( 'td', $idx->idx_type );

              tag_text( 'td', implode( ', ', $idx->col_name_list ) );

            tag_shut( 'tr' );

          }

        tag_shut( 'tbody' );

      tag_shut( 'table' );

    }
  }
}

return new mud_facility_dev_schema_schemata();
