<?php

interface IMudNullValue extends
  IMudFalse,
  IMudInteger,
  IMudFloat,
  IMudPositive,
  IMudText,
  IMudBinary,
  IMudDate,
  IMudTime,
  IMudDateTimeUniversal,
  IMudDateTimeLocal,
  IMudDateTimeZoned,
  IMudDateTimeZone,
  IMudDateInterval {

}
