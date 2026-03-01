<?php

interface IMudSchemaColumn {

  public function get_column_name() : string;

  public function get_column_type() : MudSchemaColumnType;

}
