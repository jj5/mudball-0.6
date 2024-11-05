<?php

interface IMudUrl extends IMudString {

  public function get_url_scheme() : IMudUrlScheme;

  public function get_url_user() : IMudUrlUser;

  public function get_url_pass() : IMudUrlPass;

  public function get_url_host() : IMudUrlHost;

  public function get_url_port() : IMudUrlPort;

  public function get_url_path() : IMudUrlPath;

  public function get_url_query() : IMudUrlQuery;

  public function get_url_fragment() : IMudUrlFragment;

  public function format_relative() : string;

  public function format_absolute() : string;

}
