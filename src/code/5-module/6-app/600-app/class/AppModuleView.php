<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2026-05-28 jj5 - class definition...
//

class AppModuleView extends MudModuleView {

  public function render_stylesheets( $context = null, $args = [] ) {

    parent::render_stylesheets( $context, $args );

    // 2026-05-28 jj5 - this will load all CSS files for both the application and the mudball framework.
    //
    $this->render_style_html( 'style/mudball.css' );

    if ( DEBUG ) {

      $this->render_style_html( 'debug/style.css' );

    }
  }

  public function render_head_scripts( $context = null, $args = [] ) {

    parent::render_head_scripts( $context, $args );

  }

  public function render_foot_scripts( $context = null, $args = [] ) {

    parent::render_foot_scripts( $context, $args );

    // 2026-05-28 jj5 - this will load all JavaScript files for both the application and the mudball framework.
    //
    $this->render_script_html( 'script/mudball.js' );

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
}
