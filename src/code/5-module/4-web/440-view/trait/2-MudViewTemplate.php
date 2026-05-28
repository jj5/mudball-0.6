<?php

trait MudViewTemplate {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function render_head( $context, $args = [] ) {

    return mud_render_head( $context, $args );

  }

  public function render_foot( $context, $args = [] ) {

    return mud_render_foot( $context, $args );

  }

  public function render_nav_header( $context, $args = [] ) {

    // 2022-02-19 jj5 - TODO: make this more robust and flexible...

    tag_open( 'header', [ 'id' => 'page-header' ] );

      tag_open( 'nav', [ 'id' => 'top-nav' ] );

        tag_open( 'ul' );

          tag_open( 'li' );

            tag_text( 'a', 'Home', [ 'href' => APP_URL_BASE . '/test' ] );

          tag_shut( 'li' );

        tag_shut( 'ul' );

      tag_shut( 'nav' );

    tag_shut( 'header' );

  }

  public function render_form_open(
    $context,
    $name = null,
    $default_action = null,
    $method = 'POST',
    $id = null,
    $attrs = []
  ) {

    return mud_render_form_open( $context, $name, $default_action, $method, $id, $attrs );

  }

  public function render_form_shut( $context ) {

    return mud_render_form_shut( $context );

  }
}
