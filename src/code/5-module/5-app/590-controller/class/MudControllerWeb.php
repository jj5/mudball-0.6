<?php

class MudControllerWeb extends MudController {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-10 jj5 - public methods...
  //

  public function run() {

    $http_status_code = null;
    $http_status_message = null;
    $fatal_exception = null;

    try {

      ob_start();

      $this->process();

      $http_status_code = 200;

    }
    catch ( MudHttpException $ex ) {

      $http_status_code = $ex->get_http_status_code();
      $http_status_message = $ex->get_http_status_message();

      if ( $http_status_code >= 300 && $http_status_code < 400 ) {

        header( 'Location: ' . $ex->get_location(), $replace = true, $http_status_code );

      }
      elseif ( $http_status_code >= 400 ) {

        $fatal_exception = $ex;

        mud_pclog_log_fatal( $ex );

      }
    }
    catch ( Throwable $ex ) {

      $fatal_exception = $ex;

      $http_status_code = 500;
      $http_status_message = 'An error occurred processing your request.';

      mud_pclog_log_fatal( $ex );

    }

    http_response_code( $http_status_code );

    if ( ! $fatal_exception ) {

      assert( $http_status_code < 400 );

      try {

        $this->complete();

        while ( ob_get_level() ) { ob_end_flush(); }

        return true;

      }
      catch ( Throwable $ex ) {

        $fatal_exception = $ex;

        $http_status_code = 500;
        $http_status_message = 'An error occurred completing your request.';

        mud_pclog_log_fatal( $ex );

      }
    }

    while ( ob_get_level() ) { ob_end_clean(); }

    $this->render_error( $http_status_code, $http_status_message );

    return false;

  }

  public function success( $message = null, $path = null, $query = null, $fragment = null ) {

    mud_orm()->save();

    mud_trn()->checkpoint();

    if ( $message ) { mud_session()->flash( $message ); }

    if ( $path === null ) {

      mud_response()->redirect();

    }
    else {

      mud_response()->redirect( mud_url()->get_abs( $path, $query, $fragment ) );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-08-26 jj5 - protected methods...
  //

  protected function process() {

    static $flags = [ 'DEBUG', 'DEV', 'TEST', 'BETA' ];

    foreach ( $flags as $flag ) { if ( ! defined( $flag ) ) { define( $flag, false ); } }

    mud_controller( $this );

    mud_url();

    $facility = mud_request()->get_facility();
    //$facility = $this->get_facility( $request );

    $session_token = mud_session()->get_session_token();

    assert( $session_token ? true : false );

    mud_xsrf_configure( $session_token );

    $last_exception = null;

    if ( ! $this->is_online() ) {

      throw new_mud_http_exception( 500, 'The database is offline for maintenance.' );

    }

    // 2022-04-10 jj5 - fail fast during debugging, time is money baby.
    //
    $attempts = DEBUG ? 3 : 10;

    for ( $attempt = 1; $attempt <= $attempts; $attempt++ ) {

      if ( $attempt !== 1 ) {

        // 2022-05-02 jj5 - SEE: https://aws.amazon.com/blogs/architecture/exponential-backoff-and-jitter/

        mud_trn()->random_delay();

      }

      mud_trn()->begin();

      try {

        ob_start();

        $this->try_process( $request );

        mud_trn()->commit();

        ob_end_flush();

        return true;

      }
      catch ( MudDatabaseException $ex ) {

        $last_exception = $ex;

        mud_trn()->rollback();

        if ( ! $ex->is_retryable() ) { break; }

      }
    }

    throw $last_exception;

  }

  protected function try_process( $request ) {

    $response = new_mud_response();

    mud_response( $response );

    $request_path_parts = $request->get_request_path_parts();

    if ( ! $request_path_parts ) {

      $this->redirect( '/home' );

    }

    $facility_category = $request_path_parts[ 0 ];

    switch ( $facility_category ) {

      case MUD_WEB_CATEGORY_ADMIN :

        if ( ! mud_user()->is_logged_in() ) {

          $this->redirect( '/util/login', [ 'goto' => $request->get_url() ] );

        }

        mud_require( mud_user()->is_admin() );

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

          mud_require( mud_user()->is_admin() );

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

    $url = mud_url()->get_abs( $path, $query );

    return mud_response()->redirect( $url );

  }

  protected function log_submission() {

    // 2022-02-19 jj5 - TODO: log this...

  }

  protected function log_web_input_errors( $errors ) {

    // 2022-02-19 jj5 - TODO: log this...

  }

  protected function render_error( int $http_status_code, string $http_status_message = '' ) {

    http_response_code( $http_status_code );

    mud_render_head( mud_null_object() );

      tag_text( 'h1', 'Error ' . $http_status_code );

      $status_string = strval( $http_status_code );

      if ( $http_status_message ) {

        tag_text( 'p', $http_status_message );

      }
      elseif ( $http_status_code === 404 ) {

        tag_text( 'p', 'The page you requested could not be found.' );

      }
      elseif ( $status_string && $status_string[ 0 ] === '4' ) {

        tag_text( 'p', 'There was a problem with your request.' );

      }
      else {

        tag_text( 'p', 'Something went wrong processing your request.' );

        tag_text( 'p', 'This has been logged and will be investigated.' );

      }

      tag_text( 'p', 'This problem has been logged and will be investigated.' );

      tag_text( 'p', 'In the mean time you can retry your operation, or try again later.' );

    mud_render_foot( mud_null_object() );

  }

  protected function complete() {

    mud_interaction()->log_complete();

    return true;

  }
}
