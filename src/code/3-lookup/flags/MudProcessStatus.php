<?php

// 2021-03-30 jj5 - THINK: do we want an initial 'WAIT' state for before 'LIVE'..?

abstract class MudProcessStatus extends MudFlags {

  use MudEnumTraits;

  const LIVE = 0;
  const DONE = 1;
  const FAIL = 2;

  static $map = [

    MUD_PROCESS_STATUS_LIVE => self::LIVE,
    MUD_PROCESS_STATUS_DONE => self::DONE,
    MUD_PROCESS_STATUS_FAIL => self::FAIL,

  ];

}
