<?php

class MudSerializationForJSON implements IMudSerializationStrategry {

  public function get_type() { return MudSerializationType::JSON; }

  public function encode( $value ) { return json_encode( $value, MUD_JSON_COMPACT ); }
  public function decode( $encoded_data ) { return json_decode( $encoded_data, true ); }

}
