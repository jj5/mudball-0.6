<?php

abstract class MudExceptionSort extends MudEnum {

  use MudEnumTraits;

  // 2021-04-13 jj5 - previous exceptions are exceptions found in $ex->getPrevious() and are
  // usually not very interesting and are handled with their owner...
  //
  const PREVIOUS  = 10;

  // 2021-04-13 jj5 - application handled the exeption, not 'final'...
  //
  const HANDLED   = 20;

  // 2021-04-13 jj5 - application ignored the exception, not 'final'...
  //
  const IGNORED   = 23;

  // 2021-04-13 jj5 - exception in shutdown handler, not 'final'...
  //
  const SHUTDOWN  = 26;

  // 2021-04-13 jj5 - fatal exceptions are 'final' exceptions handled by the application...
  //
  const FATAL     = 30;

  // 2021-04-13 jj5 - unhandled exceptions are 'final' exceptions handled by pclog...
  //
  const UNHANDLED = 33;

  static $map = [

    MUD_EXCEPTION_PREVIOUS  => self::PREVIOUS,

    MUD_EXCEPTION_HANDLED   => self::HANDLED,
    MUD_EXCEPTION_IGNORED   => self::IGNORED,
    MUD_EXCEPTION_SHUTDOWN  => self::SHUTDOWN,

    MUD_EXCEPTION_FATAL     => self::FATAL,
    MUD_EXCEPTION_UNHANDLED => self::UNHANDLED,

  ];

}
