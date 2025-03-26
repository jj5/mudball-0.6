<?php

enum MudModelSpecificType : string {
  case ABINITIO = 'abinitio';
  case LOOKUP   = 'lookup';
}

enum MudModelChangeType : string {
  case ADDITION     = 'addition';
  case MODIFICATION = 'modification';
  case DELETION     = 'deletion';
}

enum MudModelConstraintType : string {
  case PRIMARY  = 'primary';
  case UNIQUE   = 'unique';
  case INDEX    = 'index';
}

define( 'IDX_PRIMARY', MudModelConstraintType::PRIMARY );
define( 'IDX_UNIQUE', MudModelConstraintType::UNIQUE );
define( 'IDX_INDEX', MudModelConstraintType::INDEX );
