<?php


define( 'MUD_BOOLEAN_FORMAT_TRUE_FALSE', 'true/false' );
define( 'MUD_BOOLEAN_FORMAT_JSON', 'json' );
define( 'MUD_BOOLEAN_FORMAT_JSON_PRETTY', 'json-pretty' );
define( 'MUD_BOOLEAN_FORMAT_YES_NO', 'yes/no' );
define( 'MUD_BOOLEAN_FORMAT_ON_OFF', 'on/off' );

abstract class MudBoolean extends MudNumber implements IMudBoolean {

  public function format( mixed $spec = null ) : string {

    switch ( $spec ) {

      case MUD_BOOLEAN_FORMAT_TRUE_FALSE :
      case MUD_BOOLEAN_FORMAT_JSON :
      case MUD_BOOLEAN_FORMAT_JSON_PRETTY:

        return $this->is_true() ? 'true' : 'false';

      case MUD_BOOLEAN_FORMAT_YES_NO :

        return $this->is_true() ? 'yes' : 'no';

      case MUD_BOOLEAN_FORMAT_ON_OFF :

        return $this->is_true() ? 'on' : 'off';

      default :

        // 2024-06-29 jj5 - just do what PHP does...
        //
        return strval( $this->is_true() );

    }
  }
}
