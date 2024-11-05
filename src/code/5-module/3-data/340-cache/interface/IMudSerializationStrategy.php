<?php

interface IMudSerializationStrategry {

  public function get_type();

  public function encode( $value );
  public function decode( $encoded_data );

}
