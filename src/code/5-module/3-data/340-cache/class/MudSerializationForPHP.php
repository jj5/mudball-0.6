<?php

class MudSerializationForPHP implements IMudSerializationStrategry {

  public function get_type() { return MudSerializationType::PHP; }

  public function encode( $value ) { return serialize( $value ); }
  public function decode( $encoded_data ) { return unserialize( $encoded_data ); }

}
