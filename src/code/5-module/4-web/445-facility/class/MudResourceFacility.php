<?php

class MudResourceFacility extends MudFacility {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-05 jj5 - public methods...
  //

  function get_selector_spec() { return []; }

  public function render( $context ) {

    // 2021-09-05 jj5 - FIXME: this map is shit, use t_lookup_std_file_type instead...
    //
    static $type_map = [
      'js' => 'application/javascript',
      'css' => 'text/css',
      'png' => 'image/png',
      'ico' => 'image/x-icon',
    ];

    $request = $context->get_request();
    $response = $context->get_response();
    $request_path_parts = $request->get_request_path_parts();
    $extension = $request->get_file_extension();

    $res = $request_path_parts[ 0 ] ?? null;

    if ( $res !== 'res' ) { return $response->reply_404_not_found(); }

    $content_type = $type_map[ $extension ] ?? null;

    if ( ! $content_type ) { return $response->reply_404_not_found(); }

    $dir = $request_path_parts[ 1 ] ?? null;

    if ( $dir === 'script' ) {

      return $this->render_script( $request, $response );

    }

    if ( $dir === 'style' ) {

      return $this->render_style( $request, $response );

    }

    //$path = implode( '/', $request_path_parts ) . '.' . $extension;
    $path = implode( '/', $request_path_parts );

    return $this->render_file( $request, $response, $path, $content_type );

  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-09-05 jj5 - protected methods...
  //

  protected function render_script( $request, $response ) {

    $this->render_dir( $request, $response, 'res/script', 'application/javascript' );

  }

  protected function render_style( $request, $response ) {

    $this->render_dir( $request, $response, 'res/style', 'text/css' );

  }

  protected function render_dir( $request, $response, $path, $content_type ) {

    // 2021-12-08 jj5 - there should be some sort of hash in the URL, so if we hash the URL
    // we should be good...
    //
    $etag = md5( $request->get_request_path() );

    $this->send_headers( $response, $content_type, $etag );

    $dev = defined( 'DEV' ) && DEV;

    if ( ! $dev ) {

      if (
        $request->get_http_if_modified_since() ||
        $request->get_http_if_none_match()
      ) {

        $response->reply_304_not_modified();

      }
    }

    // 2021-09-05 jj5 - process mudball path first so we can override from app path if
    // necessary...
    //
    $dir_list = [ MUDBALL_PATH . "/src/web/$path", APP_PATH . "/src/web/$path" ];

    foreach ( $dir_list as $dir ) {

      if ( ! is_dir( $dir ) ) {

        //mud_fail( MUD_ERR_FACILITY_MISSING_DIR, [ 'dir' => $dir ] );

        continue;

      }

      foreach ( scandir( $dir ) as $rel_path ) {

        $abs_path = "$dir/$rel_path";

        if ( is_dir( $abs_path ) ) { continue; }

        if ( DEBUG ) {

          echo "\n\n/* $abs_path */\n\n";

        }

        readfile( $abs_path );
        echo "\n\n";

      }
    }
  }

  protected function render_file( $request, $response, $path, $content_type ) {

    // 2021-09-05 jj5 - look in the app path before the mudball path...
    //
    $file_list = [ APP_PATH . "/src/web/$path", MUDBALL_PATH . "/src/web/$path" ];

    $if_modified_since = @strtotime( $request->get_http_if_modified_since() ?? '' );
    $if_none_match = $request->get_http_if_none_match();

    foreach ( $file_list as $file ) {

      //error_log( $file );

      if ( ! is_file( $file ) ) { continue; }

      $last_modified_time = filemtime( $file );

      // 22021-12-08 jj5 - NEW: the last modified time is cheaper than processing the file
      // for the MD5 hash and it should work just fine...
      //
      $etag = $last_modified_time;
      //
      // 2021-12-08 jj5 - OLD:
      //$etag = md5_file( $file );

      $this->send_headers( $response, $content_type, $etag, $last_modified_time );

      if ( $if_modified_since == $last_modified_time || $if_none_match == $etag ) {

        $response->reply_304_not_modified();

      }

      readfile( $file );

      return;

    }

    $response->reply_404_not_found();

  }

  protected function send_headers( $response, $content_type, $etag, $last_modified_time = null ) {

    if ( ! $last_modified_time ) { $last_modified_time = time(); }

    $expires = gmdate( 'D, d M Y H:i:s', time() + ( 60 * 60 * 24 * 365 * 5 ) ) . ' GMT';
    $last_modified = gmdate( 'D, d M Y H:i:s', $last_modified_time ) . ' GMT';

    $response->set_header( "Content-Type: $content_type" );
    $response->set_header( 'Cache-Control: public' );
    $response->set_header( 'Pragma: cache' );
    $response->set_header( 'Expires: ' . $expires );
    $response->set_header( 'Last-Modified: ' . $last_modified );
    $response->set_header( "Etag: $etag" );

  }
}
