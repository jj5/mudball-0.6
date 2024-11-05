<?php

trait MudViewMixin {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-20 jj5 - public methods...
  //

  public function get_auto_html_id( $name ) {

    return mud_attr_id( $name );

  }

  public function get_auto_html_label( $name ) {

    return ucfirst( str_replace( '-', ' ', $name ) ) . ':';

  }

  public function get_auto_html_placeholder( $name ) {

    return ucfirst( str_replace( '-', ' ', $name ) ) . '...';

  }

  public function render_input_hidden(
    $context,
    string $name,
    $value
  ) {

    tag_bare( 'input', [ 'type' => 'hidden', 'name' => $name, 'value' => $value ] );

  }

  public function render_input_text(
    $context,
    string $name,
    $label = null,
    $placeholder = null,
    $id = null
  ) {

    return $this->render_input( $context, 'text', $name, $label, $placeholder, $id );

  }

  public function render_input_password(
    $context,
    string $name,
    $label = null,
    $placeholder = null,
    $id = null
  ) {

    return $this->render_input( $context, 'password', $name, $label, $placeholder, $id );

  }

  public function render_input_email(
    $context,
    string $name,
    $label = null,
    $placeholder = null,
    $id = null
  ) {

    return $this->render_input( $context, DEBUG ? 'text' : 'email', $name, $label, $placeholder, $id );

  }

  public function render_input(
    $context,
    string $type,
    string $name,
    $label = null,
    $placeholder = null,
    $id = null,
    $value = null,
    $args = []
  ) {

    mud_require( $name, 'name is supplied.' );

    // 2022-03-20 jj5 - THINK: we might want to expose this so the caller can control...
    //
    $tabindex = mud_tab_index();
    $autofocus = $tabindex === 1 ? true : false;

    if ( $label === null ) { $label = $this->get_auto_html_label( $name ); }
    if ( $placeholder === null ) { $placeholder = $this->get_auto_html_placeholder( $name ); }
    if ( $id === null ) { $id = $this->get_auto_html_id( $name ); }

    if ( $value === null && $type !== 'password' ) {

      $value = $context->get_value( $name );

    }

    tag_open( 'div', [ 'class' => [ 'field', $name ] ] );

      tag_open( 'div', [ 'class' => 'label' ] );

        tag_text( 'label', $label, [ 'for' => $id ] );

      tag_shut( 'div', [ 'class' => 'label' ] );

      tag_open( 'div', [ 'class' => 'value' ] );

        tag_bare(
          'input',
          $args + [
            'type' => $type,
            'id' => $id,
            'name' => $name,
            'placeholder' => $placeholder,
            'tabindex' => $tabindex,
            'value' => $value,
            'autofocus' => $autofocus,
            //'size' => 37,
          ]
        );

      tag_shut( 'div', [ 'class' => 'value' ] );

      if ( $context->has_error( $name, $error ) ) {

        tag_text( 'div', $error, [ 'class' => 'error' ] );

      }

    tag_shut( 'div', [ 'class' => [ 'field', $name ] ] );

    return $id;

  }

  public function render_button_submit(
    $context,
    $action,
    $label = null,
    string $name = APP_INPUT_ACTION,
    $id = null
  ) {

    if ( $label === null ) { $label = 'Submit'; }
    if ( $id === null ) { $id = $this->get_auto_html_id( $name ); }

    tag_text(
      'button',
      $label,
      [
        'id' => $id,
        'name' => $name,
        'value' => $action,
        'tabindex' => mud_tab_index(),
      ]
    );

    return $id;

  }


  /*
  public function render_form_input_password_confirm(
    $context,
    $id = 'password',
    $confirm_id = 'password_confirm',
    $label = 'Password:',
    $placeholder = 'Password...',
    $confirm_placeholder = 'Re-enter password to confirm...',
    $name = null,
    $confirm_name = null
  ) {

    if ( $name === null ) { $name = $id; }
    if ( $confirm_name === null ) { $confirm_name = $confirm_id; }

    tag_open( 'div', [ 'class' => 'field' ] );

      tag_open( 'div', [ 'class' => 'label' ] );

        tag_text( 'label', $label, [ 'for' => $id ] );

      tag_shut( 'div', [ 'class' => 'label' ] );

      tag_open( 'div', [ 'class' => 'value' ] );

        tag_bare(
          'input',
          [
            'type' => 'password',
            'id' => $id,
            'name' => $name,
            'tabindex' => mud_tab_index(),
            'placeholder' => $placeholder,
            //'size' => 37,
          ]
        );

      tag_shut( 'div', [ 'class' => 'value' ] );

      if ( $context->has_error( $name, $error ) ) {

        tag_text( 'div', $error, [ 'class' => 'error' ] );

      }

      tag_open( 'div', [ 'class' => 'value' ] );

        tag_bare(
          'input',
          [
            'type' => 'password',
            'id' => $confirm_id,
            'name' => $confirm_name,
            'tabindex' => mud_tab_index(),
            'placeholder' => $confirm_placeholder,
            //'size' => 37,
          ]
        );

      tag_shut( 'div', [ 'class' => 'value' ] );

      if ( array_key_exists( $confirm_name, $this->errors ) ) {

        tag_text(
          'div',
          $this->errors[ $confirm_name ],
          [ 'class' => 'error' ]
        );

      }

    tag_shut( 'div', [ 'class' => 'field' ] );

  }
  */

}
