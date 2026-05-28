<?php

abstract class AppFacility extends MudFacility {

  public function render_nav_header( $context, $args = [] ) {

    // 2022-02-19 jj5 - TODO: make this more robust and flexible...

    tag_open( 'header', [ 'id' => 'site-header', 'class' => 'site-header' ] );

      tag_open( 'nav', [ 'id' => 'site-nav', 'class' => 'site-nav' ] );

        tag_open( 'ul' );

          tag_open( 'li' );

            tag_text( 'a', 'Home', [ 'href' => APP_URL_BASE . '/test' ] );

          tag_shut( 'li' );

          tag_open( 'li' );

            tag_text( 'a', 'Add User', [ 'href' => APP_URL_BASE . '/admin/user/add' ] );

          tag_shut( 'li' );

        tag_shut( 'ul' );

      tag_shut( 'nav' );

    tag_shut( 'header' );

  }
}
