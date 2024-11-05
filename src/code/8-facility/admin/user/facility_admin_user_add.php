<?php

class mud_facility_admin_user_add extends MudFacility {

  public function get_selector_spec() { return []; }

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

    var_dump( app_request() ); exit;

    $description = 'Add User';
    $keywords = [ 'user', 'add', ];

    $tabindex = 1;

    $this->render_head(
      $context,
      [
        'title' => $description,
        'description' => $description,
        'keywords' => $keywords,
      ]
    );

      tag_bare( 'div', [ 'id' => 'logo' ] );

      //$this->render_admin_menu();

      tag_open( 'div', [ 'id' => 'content' ] );

        tag_text( 'h1', 'New User' );

        $this->render_form( $context );

      tag_shut( 'div', [ 'id' => 'content' ] );

    $this->render_foot( $context );

  }

  protected function render_form( $context ) {

    $errors = $this->errors;

    tag_open(
      'form',
      [
        'method' => 'POST',
      ]
    );

      $this->render_input_text( $context, 'username', 'Username:', 'Username...' );

      $this->render_input_password_confirm( $context );

      $this->render_button_submit( $context, ACTION_DEFAULT_ADMIN_USER_ADD::class );

    tag_shut( 'form' );

  }
}

return new mud_facility_admin_user_add();
