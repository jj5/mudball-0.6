<?php

interface IMudSchemaTable {

  public function get_table_name() : string;

  public function get_table_type() : MudSchemaTableType;

}
