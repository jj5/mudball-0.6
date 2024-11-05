<?php

abstract class MudAction extends MudGadget {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public static methods...
  //

  public static function Parse( string $action_input, &$action_code = null, &$action_args = null ) {

    $action_parts = explode( '?', $action_input, 2 );

    $action_code = $action_parts[ 0 ];
    $action_args = [];

    if ( count( $action_parts ) === 2 ) {

      parse_str( $action_parts[ 1 ], $action_args );

    }

    return $action_code;

  }

  
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-03-06 jj5 - public instance methods...
  //

  public function can_submit( $request ) { return true; }

  public function get_autoxsrf() { return true; }

  public function process( $request, $response ) {

    if ( defined( 'DEBUG' ) && DEBUG ) {

      mud_dump( $request );

    }

    return false;

  }
}
