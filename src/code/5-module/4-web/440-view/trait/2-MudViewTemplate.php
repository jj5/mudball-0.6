<?php

trait MudViewTemplate {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function render_head( $context, $args = [] ) {

    return mud_render_head( $context, $args );

  }

  public function render_foot( $context, $args = [] ) {

    return mud_render_foot( $context, $args );

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
