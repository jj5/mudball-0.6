<?php

enum MudDatabaseMutation : int {
  case INSERT = 1;
  case UPDATE = 2;
  case DELETE = 3;
  case SCHEMA = 4;
  case EXEC = 5;
}
