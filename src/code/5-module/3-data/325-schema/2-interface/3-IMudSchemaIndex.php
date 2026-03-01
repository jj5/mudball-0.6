<?php

interface IMudSchemaIndex {

  public function get_index_name() : string;

  public function get_index_type() : MudSchemaIndexType;

}
