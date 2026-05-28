<?php

class mud_facility_admin_user_add extends AppFacility {

  public function get_selector_spec() { return []; }

  public function query( $context ) {

    return [
      'contact-method-id' => [ mud_new_client_id(), ],
      'contact-method-type' => [ 'email', ],
      'contact-method-detail' => [ '' ],
    ];

  }

  public function render( $context ) {

    /*
    // 2021-10-20 jj5 - TODO: log this context (the full context) and also the actual output
    // (copy from output buffer); save all files with content-addressible names (not MD5, SHA512)
    // and then sym-link to them from timestamped log dir.

    $context = [
      'POST' => $_POST ?? null,
      'GET' => $_GET ?? null,
      'FILES' => $_FILES ?? null,
      'COOKIE' => $_COOKIE ?? null,
      'ENV' => $_ENV ?? null,
      'SESSION' => $_SESSION ?? null,
      'SERVER' => $_SERVER ?? null,
    ];

    header( 'Content-Type: text/plain' );

    $json = mud_json_compact( $context );

    echo 'json: ' . strlen( $json ) . '; ';

    $data = mud_jzon_encode( $context );

    echo 'data: ' . strlen( $data ) . ';';

    mud_json_gzip_decode_pretty( $data, $json );

    echo $json;
    exit;

    var_dump( $_ENV );

    var_dump( $_SERVER ); exit;
    */

    $description = 'Add User';
    $keywords = [ 'user', 'add', ];

    $tabindex = 1;

    $args = [
      'title' => $description,
      'description' => $description,
      'keywords' => $keywords,
    ];

    $this->render_head( $context, $args );

      $this->render_nav_header( $context );

      tag_open( 'main' );

        tag_text( 'h1', 'New User' );

        $this->render_form( $context );

      tag_shut( 'main' );

    $this->render_foot( $context );

  }

  protected function render_form( $context ) {

    //var_dump( $context ); exit;

    //$errors = $this->errors;

    tag_open(
      'form',
      [
        'method' => 'POST',
      ]
    );

      $this->render_input_text( $context, 'username', 'Username:', 'Username...' );

      $this->render_input_password( $context, 'password', 'Password:', 'Password...' );

      $this->render_input_password( $context, 'password-confirm', 'Confirm Password:', 'Password...' );

      tag_open( 'table', [ 'class' => 'nice-table' ] );

        tag_open( 'thead' );

          tag_open( 'tr' );

            tag_text( 'th', 'Contact Method' );
            tag_text( 'th', 'Details' );
            tag_text( 'th', 'Add/Remove' );

          tag_shut( 'tr' );

        tag_shut( 'thead' );

        tag_open( 'tbody' );

          foreach ( $context->get_value( 'contact-method-id', [] ) as $index => $id ) {

            $method = $context->get_list_value( 'contact-method-type', $index );
            $detail = $context->get_list_value( 'contact-method-detail', $index );

            $this->render_contact_method_row( $context, $index, $id, $method, $detail );

          }

        tag_shut( 'tbody' );

      tag_shut( 'table' );

      $this->render_button_submit( $context, APP_ACTION_ADMIN_USER_CREATE );

    tag_shut( 'form' );

  }

  protected function render_contact_method_row( IMudWebContext $context, $index, $id, $method, $detail ) {

    tag_open( 'tr' );

      tag_open( 'td' );

        tag_bare( 'input', [ 'type' => 'hidden', 'name' => 'contact-method-id[]', 'value' => $id ] );

        tag_open( 'select', [ 'name' => 'contact-method-type[]' ] );

          tag_text( 'option', 'Email', [ 'value' => 'email', 'selected' => $method === 'email' ? true : false ] );

          tag_text( 'option', 'Phone', [ 'value' => 'phone', 'selected' => $method === 'phone' ? true : false ] );

          tag_text( 'option', 'SMS', [ 'value' => 'sms', 'selected' => $method === 'sms' ? true : false ] );

        tag_shut( 'select' );

      tag_shut( 'td' );

      tag_open( 'td' );

        tag_bare(
          'input',
          [
            'type' => 'text',
            'name' => 'contact-method-detail[]',
            'value' => $detail,
            'placeholder' => 'Contact details...',
          ]
        );

        if ( $context->has_list_error( 'contact-method-detail', $index, $error ) ) {

          tag_text( 'div', $error, [ 'class' => 'error' ] );

        }

      tag_shut( 'td' );

      tag_open( 'td' );

        tag_text(
          'button',
          '+',
          [
            'type' => 'button',
            'class' => 'add',
            'onclick' => 'mud_duplicate_row( this, event )',
          ]
        );

        out_text( ' ' );

        tag_text(
          'button',
          '-',
          [
            'type' => 'button',
            'class' => 'remove',
            'onclick' => 'mud_remove_row( this, event )',
          ]
        );

      tag_shut( 'td' );

    tag_shut( 'tr' );

  }
}

return new mud_facility_admin_user_add();
