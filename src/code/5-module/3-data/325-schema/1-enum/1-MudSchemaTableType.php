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
