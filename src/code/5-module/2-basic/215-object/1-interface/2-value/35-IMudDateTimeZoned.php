<?php

interface IMudDateTimeZoned extends IMudDateTime, IMudComposite {

  public function get_time_zone() : IMudDateTimeZone;

}
