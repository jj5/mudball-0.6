<?php

class MudWebController extends MudController {


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-10 jj5 - public methods...
  //

  public function run() {

    $http_status_code = false;

    try {

      ob_start();

      $this->process();

      return $this->complete();

    }
    catch ( MudHttpException $ex ) {

      $http_status_code = $ex->get_http_status_code();

      if ( $http_status_code < 400 ) {

        return $this->complete();

      }

      // 2023-02-22 jj5 - the response code should already be set...
      //
      assert( http_response_code() === $http_status_code );

      // 2023-02-22 jj5 - but if it's not we'll set it here, just in case...
      //
      http_response_code( $http_status_code );

      app_interaction()->log_fail( $ex );

    }
    catch ( Throwable $ex ) {

      app_interaction()->log_fail( $ex );

      $http_status_code = 500;

      http_response_code( $http_status_code );

      if ( DEBUG ) { throw $ex; }

    }

    while ( ob_get_level() ) { ob_end_clean(); }

    $this->render_error( $http_status_code );

    return false;

  }

  public function success( $message = null, $path = null, $query = null, $fragment = null ) {

    app_orm()->save();

    app_trn()->checkpoint();

    if ( $message ) { app_session()->flash( $message ); }

    if ( $path === null ) {

      app_response()->redirect();

    }
    else {

      app_response()->redirect( app_url()->get_abs( $path, $query, $fragment ) );

    }
  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-26 jj5 - protected methods...
  //

  protected function process() {

    static $flags = [ 'DEBUG', 'DEV', 'TEST', 'BETA' ];

    foreach ( $flags as $flag ) { if ( ! defined( $flag ) ) { define( $flag, false ); } }

    app( $this );

    $request_reader = new_mud_request_reader();

    $request = $request_reader->read();

    app_request( $request );

    app_url( new_mud_url( $request ) );

    $facility = $request->get_facility();
    //$facility = $this->get_facility( $request );

    $session_token = app_session()->get_session_token();

    assert( $session_token ? true : false );

    mud_xsrf_configure( $session_token );

    $last_exception = null;

    if ( ! $this->is_online() ) {

      http_response_code( 500 );

      $this->render_offline();

      return false;

    }

    // 2022-04-10 jj5 - fail fast during debugging, time is money baby.
    //
    $attempts = DEBUG ? 3 : 10;

    for ( $attempt = 1; $attempt <= $attempts; $attempt++ ) {

      if ( $attempt !== 1 ) {

        // 2022-05-02 jj5 - SEE: https://aws.amazon.com/blogs/architecture/exponential-backoff-and-jitter/

        app_trn()->random_delay();

      }

      app_trn()->begin();

      try {

        ob_start();

        $this->try_process( $request );

        app_trn()->commit();

        ob_end_flush();

        return true;

      }
      catch ( MudDatabaseException $ex ) {

        $last_exception = $ex;

        app_trn()->rollback();

        if ( ! $ex->is_retryable() ) { break; }

      }
    }

    throw $last_exception;

  }

  protected function try_process( $request ) {

    $response = new_mud_response();

    app_response( $response );

    $request_path_parts = $request->get_request_path_parts();

    if ( ! $request_path_parts ) {

      $this->redirect( '/home' );

    }

    $facility_category = $request_path_parts[ 0 ];

    switch ( $facility_category ) {

      case MUD_WEB_CATEGORY_ADMIN :

        if ( ! app_user()->is_logged_in() ) {

          $this->redirect( '/util/login', [ 'goto' => $request->get_url() ] );

        }

        mud_require( app_user()->is_admin() );

        break;

      case MUD_WEB_CATEGORY_DEV :

        mud_require( DEV );

        break;

    }

    $facility = $request->get_facility();

    if ( mud_is_missing( $facility ) ) { $response->reply_404_not_found(); }

    $is_submission = $request->is_submission();

    $view_state = null;

    if ( $is_submission ) {

      $this->log_submission();

      $processor = $this->get_processor(
        $request,
        $processor,
        $action_input,
        $action,
        $action_args
      );

      $action_category = mud_get_action_category( $action );

      switch ( $action_category ) {

        case MUD_WEB_CATEGORY_ADMIN :

          mud_require( app_user()->is_admin() );

          break;

        case MUD_WEB_CATEGORY_DEV :

          mud_require( DEV );

          break;

      }

      if ( ! $processor->can_submit( $request ) ) {

        mud_fail( MUD_ERR_HOST_UNAUTHOIRZED );

      }

      if ( $processor->get_autoxsrf() ) {

        mud_xsrf_check( $request );

      }

      $view_state = $processor->process( $request, $response );

      if ( ! $view_state ) {

        $response->reply_404_not_found();

      }

      if ( $response->has_errors() ) {

        $this->log_web_input_errors( $response->get_errors() );

        http_response_code( 400 );

      }
    }

    if ( ! $facility->can_query( $request ) ) {

      if ( ! user()->is_logged_in() ) {

        $this->redirect( '/util/login', [ 'goto' => $request->get_url() ] );

      }

      mud_fail( MUD_ERR_HOST_UNAUTHOIRZED );

    }

    // 2023-02-22 jj5 - TODO: here we should switch the 'trn' connection from SERIALIZABLE
    // to something like READ COMMITTED. We should also enforce no more side effects from the
    // 'trn' connection. That is, 'trn' should go into readonly mode.

    if ( ! $view_state ) {

      $view_state = $facility->query( $request );

      if ( $view_state === false ) {

        $response->reply_404_not_found();

      }
    }

    $context = new_mud_web_context( $request, $response, $view_state );

    $facility->render( $context );

  }

  protected function get_facility( $request ) {

    $facility = mud_load_facility( $request, $selector );

    $request->set_facility( $facility );

    return $facility;

  }

  protected function get_processor(
    $request,
    &$processor,
    &$action_input,
    &$action,
    &$action_args
  ) {

    $action_input =
      $request->get_submission()[ APP_INPUT_ACTION ] ??
      $request->get_submission()[ APP_INPUT_ACTION_DEFAULT ];

    //$processor = MudAction::Find( $action_input, $action, $action_args );
    $processor = mud_load_processor( $action_input, $action, $action_args );

    return $processor;

  }

  protected function redirect( $path, $query = null ) {

    $url = app_url()->get_abs( $path, $query );

    return app_response()->redirect( $url );

  }

  protected function log_submission() {

    // 2022-02-19 jj5 - TODO: log this...

  }

  protected function log_web_input_errors( $errors ) {

    // 2022-02-19 jj5 - TODO: log this...

  }

  protected function render_error( $http_status_code = false ) {

    mud_render_head( app_null_object() );

      if ( $http_status_code ) {

        $this->render_http_error( $http_status_code );

      }
      else {

        $this->render_generic_error();

      }

    mud_render_foot( app_null_object() );

  }

  protected function render_offline() {

    mud_render_head( app_null_object() );

      tag_text( 'p', 'The database is offline for maintenance.' );

      tag_text( 'p', 'Please try again later.' );

    mud_render_foot( app_null_object() );

  }


  protected function render_http_error( $http_status_code ) {

    switch ( $http_status_code ) {

      case 404:

        tag_text( 'p', 'The page you requested cannot be found.' );

        return;

    }

    $status_string = strval( $http_status_code );

    if ( $status_string && $status_string[ 0 ] === '4' ) {

      tag_text( 'p', 'There was a problem with your request.' );

    }
    else {

      $this->render_generic_error();

    }
  }

  protected function render_generic_error() {

    tag_text( 'p', 'Something went wrong processing your request.' );

    tag_text( 'p', 'This has been logged and will be investigated.' );

    tag_text( 'p', 'In the mean time you can retry your operation, or try again later.' );

  }

  protected function complete() {

    app_interaction()->log_complete();

    while ( ob_get_level() ) { ob_end_flush(); }

    return true;

  }
}
