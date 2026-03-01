<?php

abstract class MudSchemaVendor {

  abstract public function get_col_type( $type, int $len ) : string;

  abstract public function has_length( $type ) : bool;

  abstract public function get_col_sql( $col ) : string;

  abstract public function get_ref_sql( $ref ) : string;

}
