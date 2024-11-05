<?php

enum MudExceptionKind : int {

  // 2024-10-21 jj5 - previous exceptions are exceptions found in $ex->getPrevious() and are usually not very interesting
  // and are handled with their owner...
  //
  case PREVIOUS   = 10;

  // 2024-10-21 jj5 - application handled the exception, not 'final'...
  //
  case HANDLED    = 20;

  // 2024-10-21 jj5 - application ignored the exception, not 'final'...
  //
  case IGNORED    = 30;

  // 2024-10-21 jj5 - fatal exceptions are 'final' non-recoverable exceptions handled by the application...
  //
  case FATAL      = 40;

  // 2024-10-21 jj5 - unhandled exceptions are 'final' non-recoverable exceptions handled by pclog...
  //
  case UNHANDLED  = 50;

}
