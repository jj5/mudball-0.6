<?php

// 2020-03-25 jj5 - SEE: https://www.iana.org/assignments/media-types/media-types.xhtml

// 2020-03-25 jj5 - NOTE: we call these things 'media types', but they could
// more accurately be called 'top-level media types', but that was a little
// too verbose for my tastes. Anyway, you can use these top-level media
// types in combination with a subtype to create a real bonafide media type...

// 2020-03-25 jj5 - considered values:
//* application (6)
//* audio (3)
//* font (5)
//* example
//* image (2)
//* message
//* model
//* multipart
//* text (1)
//* video (4)

abstract class MudMediaType extends MudEnum {

  use MudEnumTraits;

  const TEXT        = 1;
  const IMAGE       = 2;
  const AUDIO       = 3;
  const VIDEO       = 4;
  const FONT        = 5;
  const APPLICATION = 6;

  static $map = [
    MUD_MEDIA_TYPE_TEXT         => self::TEXT,
    MUD_MEDIA_TYPE_IMAGE        => self::IMAGE,
    MUD_MEDIA_TYPE_AUDIO        => self::AUDIO,
    MUD_MEDIA_TYPE_VIDEO        => self::VIDEO,
    MUD_MEDIA_TYPE_FONT         => self::FONT,
    MUD_MEDIA_TYPE_APPLICATION  => self::APPLICATION,
  ];

}
