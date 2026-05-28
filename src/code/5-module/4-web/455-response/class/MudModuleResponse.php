<?php

class MudModuleResponse extends MudModuleWeb {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2026-05-28 jj5 - protected fields...
  //

  protected $client_id = 0;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-08 jj5 - factory methods...
  //

  public function new_mud_response() {

    return MudResponse::Create();

  }

  public function new_client_id() {

    $this->client_id--;

    return $this->client_id;

  }

  public function get_client_id() {

    return $this->client_id;

  }
}
