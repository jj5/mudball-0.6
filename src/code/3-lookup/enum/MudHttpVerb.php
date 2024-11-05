<?php

// 2020-03-25 jj5 - SEE: https://annevankesteren.nl/2007/10/http-methods

abstract class MudHttpVerb extends MudEnum {

  use MudEnumTraits;

  // 2020-03-25 jj5 - RFC 2616...
  //
  const GET               =  1;
  const POST              =  2;
  const PUT               =  3;
  const DELETE            =  4;
  const TRACE             =  5;
  const CONNECT           =  6;
  const OPTIONS           =  7;
  const HEAD              =  8;

  // 2020-03-25 jj5 - RFC 2518...
  //
  const PROPFIND          = 10;
  const PROPPATCH         = 11;
  const MKCOL             = 12;
  const COPY              = 13;
  const MOVE              = 14;
  const LOCK              = 15;
  const UNLOCK            = 16;

  // 2020-03-25 jj5 - RFC 3253...
  //
  const VERSION_CONTROL   = 20;
  const REPORT            = 21;
  const CHECKOUT          = 22;
  const CHECKIN           = 23;
  const UNCHECKOUT        = 24;
  const MKWORKSPACE       = 25;
  const UPDATE            = 26;
  const LABEL             = 27;
  const MERGE             = 28;
  const BASELINE_CONTROL  = 29;
  const MKACTIVITY        = 30;

  // 2020-03-25 jj5 - RFC 3648...
  //
  const ORDERPATCH        = 40;

  // 2020-03-25 jj5 - 3744...
  //
  const ACL               = 50;

  // 2020-03-25 jj5 - draft-dusseault-http-patch...
  //
  const PATCH             = 60;

  // 2020-03-25 jj5 - draft-reschke-webdav-search...
  //
  const SEARCH            = 70;

  // 2020-03-25 jj5 - WebDAV methods...
  //
  const BCOPY             = 80;
  const BDELETE           = 81;
  const BMOVE             = 82;
  const BPROPFIND         = 83;
  const BPROPPATCH        = 84;
  const NOTIFY            = 85;
  const POLL              = 86;
  const SUBSCRIBE         = 87;
  const UNSUBSCRIBE       = 88;
  const X_MS_ENUMATTS     = 89;

  static $map = [

    MUD_HTTP_VERB_GET               => self::GET,
    MUD_HTTP_VERB_POST              => self::POST,
    MUD_HTTP_VERB_PUT               => self::PUT,
    MUD_HTTP_VERB_DELETE            => self::DELETE,
    MUD_HTTP_VERB_TRACE             => self::TRACE,
    MUD_HTTP_VERB_CONNECT           => self::CONNECT,
    MUD_HTTP_VERB_OPTIONS           => self::OPTIONS,
    MUD_HTTP_VERB_HEAD              => self::HEAD,

    MUD_HTTP_VERB_PROPFIND          => self::PROPFIND,
    MUD_HTTP_VERB_PROPPATCH         => self::PROPPATCH,
    MUD_HTTP_VERB_MKCOL             => self::MKCOL,
    MUD_HTTP_VERB_COPY              => self::COPY,
    MUD_HTTP_VERB_MOVE              => self::MOVE,
    MUD_HTTP_VERB_LOCK              => self::LOCK,
    MUD_HTTP_VERB_UNLOCK            => self::UNLOCK,

    MUD_HTTP_VERB_VERSION_CONTROL   => self::VERSION_CONTROL,
    MUD_HTTP_VERB_REPORT            => self::REPORT,
    MUD_HTTP_VERB_CHECKOUT          => self::CHECKOUT,
    MUD_HTTP_VERB_CHECKIN           => self::CHECKIN,
    MUD_HTTP_VERB_UNCHECKOUT        => self::UNCHECKOUT,
    MUD_HTTP_VERB_MKWORKSPACE       => self::MKWORKSPACE,
    MUD_HTTP_VERB_UPDATE            => self::UPDATE,
    MUD_HTTP_VERB_LABEL             => self::LABEL,
    MUD_HTTP_VERB_MERGE             => self::MERGE,
    MUD_HTTP_VERB_BASELINE_CONTROL  => self::BASELINE_CONTROL,
    MUD_HTTP_VERB_MKACTIVITY        => self::MKACTIVITY,

    MUD_HTTP_VERB_ORDERPATCH        => self::ORDERPATCH,

    MUD_HTTP_VERB_ACL               => self::ACL,

    MUD_HTTP_VERB_PATCH             => self::PATCH,

    MUD_HTTP_VERB_SEARCH            => self::SEARCH,

    MUD_HTTP_VERB_BCOPY             => self::BCOPY,
    MUD_HTTP_VERB_BDELETE           => self::BDELETE,
    MUD_HTTP_VERB_BMOVE             => self::BMOVE,
    MUD_HTTP_VERB_BPROPFIND         => self::BPROPFIND,
    MUD_HTTP_VERB_BPROPPATCH        => self::BPROPPATCH,
    MUD_HTTP_VERB_NOTIFY            => self::NOTIFY,
    MUD_HTTP_VERB_POLL              => self::POLL,
    MUD_HTTP_VERB_SUBSCRIBE         => self::SUBSCRIBE,
    MUD_HTTP_VERB_UNSUBSCRIBE       => self::UNSUBSCRIBE,
    MUD_HTTP_VERB_X_MS_ENUMATTS     => self::X_MS_ENUMATTS,

  ];

}
