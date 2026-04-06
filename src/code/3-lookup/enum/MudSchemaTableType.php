<?php

enum MudSchemaTableType : string {
  case ABINITIO = 'abinitio';
  case LOOKUP = 'lookup';
  case STATIC = 'static';
  case IDENT = 'ident';
  case ABOUT = 'about';
  case PARTICLE = 'particle';
  case PIECE = 'piece';
  case POT = 'pot';
  case PRODUCT = 'product';
  case PROVINCE = 'province';
  case ENTITY = 'entity';
  case CONFIG = 'config';
  case FACTOR = 'factor';
  case EPHEMERA = 'ephemera';
  case EVENT = 'event';
  case HISTORY = 'history';
  case LOG = 'log';
  case METRIC = 'metric';
  case TIDBIT = 'tidbit';
  case STATE = 'state';
  case JOURNAL = 'journal';
}

define( 'MUD_TAB_ABINITIO', MudSchemaTableType::ABINITIO );
define( 'MUD_TAB_LOOKUP', MudSchemaTableType::LOOKUP );
define( 'MUD_TAB_STATIC', MudSchemaTableType::STATIC );
define( 'MUD_TAB_IDENT', MudSchemaTableType::IDENT );
define( 'MUD_TAB_ABOUT', MudSchemaTableType::ABOUT );
define( 'MUD_TAB_PARTICLE', MudSchemaTableType::PARTICLE );
define( 'MUD_TAB_PIECE', MudSchemaTableType::PIECE );
define( 'MUD_TAB_POT', MudSchemaTableType::POT );
define( 'MUD_TAB_PRODUCT', MudSchemaTableType::PRODUCT );
define( 'MUD_TAB_PROVINCE', MudSchemaTableType::PROVINCE );
define( 'MUD_TAB_ENTITY', MudSchemaTableType::ENTITY );
define( 'MUD_TAB_CONFIG', MudSchemaTableType::CONFIG );
define( 'MUD_TAB_FACTOR', MudSchemaTableType::FACTOR );
define( 'MUD_TAB_EPHEMERA', MudSchemaTableType::EPHEMERA );
define( 'MUD_TAB_EVENT', MudSchemaTableType::EVENT );
define( 'MUD_TAB_HISTORY', MudSchemaTableType::HISTORY );
define( 'MUD_TAB_LOG', MudSchemaTableType::LOG );
define( 'MUD_TAB_METRIC', MudSchemaTableType::METRIC );
define( 'MUD_TAB_TIDBIT', MudSchemaTableType::TIDBIT );
define( 'MUD_TAB_STATE', MudSchemaTableType::STATE );
define( 'MUD_TAB_JOURNAL', MudSchemaTableType::JOURNAL );
