<?php

interface IMudDateTime extends IMudAtom {

  public function get_datetime() : DateTimeInterface;

  public function new_date_time() : DateTime;

  public function is_date() : bool;

  public function is_time() : bool;

  public function is_date_time() : bool;

  public function is_universal() : bool;

  public function is_local() : bool;

  public function is_zoned() : bool;

  public function get_value_min_datetime() : DateTimeInterface;

  public function get_value_max_datetime() : DateTimeInterface;

  public function get_timestamp() : int;

  public function get_for_utc() : DateTimeInterface;

  public function format_for_web() : string;

  public function format_for_sitemap() : string;

}
