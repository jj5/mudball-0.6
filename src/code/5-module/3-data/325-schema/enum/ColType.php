<?php

namespace Kickass;

enum ColType {

  case aid32;

  case uint8;
  case uint16;
  case uint24;
  case uint32;

  case int8;
  case int16;
  case int24;
  case int32;
  case int64;

  // 2026-03-01 jj5 - these are for fixed-length ASCII strings
  //
  case char_bin;
  case char_ci;

  case ascii_bin;
  case ascii_ci;
  case unicode;

  case timestamp;
  case created_on;
  case updated_on;

}
