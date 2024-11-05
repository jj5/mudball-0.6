<?php

interface IMudSubmission {

  public function get_criteria();

  public function get_criterion( $key, $default = null );

  public function get_submission();

  public function get_value( $key, $default = null );

  public function get_action_code();
  public function get_action_args();

}
