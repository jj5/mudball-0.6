<?php

enum MudDatabaseConnectionType : int {

  case RAW = 1;
  case TRN = 2;

  case AUX = 3;
  case EMU = 4;
  case DBA = 5;

}
