<?php

// 2019-11-23 jj5 - see t_lookup_file_type in schema.php for other details.

// 2020-03-25 jj5 - if you need to define your own file types start with
// enum value 9000.

abstract class MudFileType extends MudEnum {

  use MudEnumTraits;

  // 2020-03-25 jj5 - 'text' file types...
  //
  const CSS   = 101;
  const CSV   = 111;
  const HTML  = 1021;
  const ICS   = 1031;
  const TXT   = 1041;

  // 2020-03-25 jj5 - 'image' file types...
  //
  const BMP   = 201;
  const GIF   = 211;
  const ICO   = 221;
  const JPEG  = 231;
  const PNG   = 241;
  const SVG   = 251;
  const TIFF  = 261;
  const WEBP  = 271;

  // 2020-03-25 jj5 - 'audio' file types...
  //
  const AAC   = 301;
  const MIDI  = 311;
  const MP3   = 321;
  const OGA   = 331;
  const OPUS  = 341;
  const WAV   = 351;
  const WEBA  = 361;

  // 2020-03-25 jj5 - 'video' file types...
  //
  const AVI   = 401;
  const MPEG  = 411;
  const OGV   = 421;
  const TS    = 431;
  const WEBM  = 441;
  const _3GP  = 451;
  const _3G2  = 461;

  // 2020-03-25 jj5 - 'font' file types...
  //
  const OTF   = 501;
  const TTF   = 511;
  const WOFF  = 521;
  const WOFF2 = 531;

  // 2020-03-25 jj5 - 'application' file types...
  //
  const ABW     = 6001;
  const ARC     = 6011;
  const AZW     = 6021;
  const BIN     = 6031;
  const BZ      = 6041;
  const BZ2     = 6051;
  const CSH     = 6061;
  const DOC     = 6071;
  const DOCX    = 6081;
  const EOT     = 6091;
  const EPUB    = 6101;
  const GZ      = 6111;
  const JAR     = 6121;
  const JS      = 6131;
  const JSON    = 6141;
  const JSONLD  = 6151;
  const MJS     = 6161;
  const MPKG    = 6171;
  const ODP     = 6181;
  const ODS     = 6191;
  const ODT     = 6201;
  const OGX     = 6211;
  const PDF     = 6221;
  const PHP     = 6231;
  const PPT     = 6241;
  const PPTX    = 6251;
  const RAR     = 6261;
  const RTF     = 6271;
  const SH      = 6281;
  const SWF     = 6291;
  const TAR     = 6301;
  const VSD     = 6311;
  const XHTML   = 6321;
  const XLS     = 6331;
  const XLSX    = 6341;
  const XML     = 6351;
  const XUL     = 6361;
  const ZIP     = 6371;
  const _7Z     = 6381;

  static $map = [
    MUD_FILE_EXT_AAC    => self::AAC,
    MUD_FILE_EXT_ABW    => self::ABW,
    MUD_FILE_EXT_ARC    => self::ARC,
    MUD_FILE_EXT_AVI    => self::AVI,
    MUD_FILE_EXT_AZW    => self::AZW,
    MUD_FILE_EXT_BIN    => self::BIN,
    MUD_FILE_EXT_BMP    => self::BMP,
    MUD_FILE_EXT_BZ     => self::BZ,
    MUD_FILE_EXT_BZ2    => self::BZ2,
    MUD_FILE_EXT_CSH    => self::CSH,
    MUD_FILE_EXT_CSS    => self::CSS,
    MUD_FILE_EXT_CSV    => self::CSV,
    MUD_FILE_EXT_DOC    => self::DOC,
    MUD_FILE_EXT_DOCX   => self::DOCX,
    MUD_FILE_EXT_EOT    => self::EOT,
    MUD_FILE_EXT_EPUB   => self::EPUB,
    MUD_FILE_EXT_GZ     => self::GZ,
    MUD_FILE_EXT_GIF    => self::GIF,
    MUD_FILE_EXT_HTM    => self::HTML,
    MUD_FILE_EXT_HTML   => self::HTML,
    MUD_FILE_EXT_ICO    => self::ICO,
    MUD_FILE_EXT_ICS    => self::ICS,
    MUD_FILE_EXT_JAR    => self::JAR,
    MUD_FILE_EXT_JPEG   => self::JPEG,
    MUD_FILE_EXT_JPG    => self::JPEG,
    MUD_FILE_EXT_JS     => self::JS,
    MUD_FILE_EXT_JSON   => self::JSON,
    MUD_FILE_EXT_JSONLD => self::JSONLD,
    MUD_FILE_EXT_MID    => self::MIDI,
    MUD_FILE_EXT_MIDI   => self::MIDI,
    MUD_FILE_EXT_MJS    => self::MJS,
    MUD_FILE_EXT_MP3    => self::MP3,
    MUD_FILE_EXT_MPEG   => self::MPEG,
    MUD_FILE_EXT_MPKG   => self::MPKG,
    MUD_FILE_EXT_ODP    => self::ODP,
    MUD_FILE_EXT_ODS    => self::ODS,
    MUD_FILE_EXT_ODT    => self::ODT,
    MUD_FILE_EXT_OGA    => self::OGA,
    MUD_FILE_EXT_OGV    => self::OGV,
    MUD_FILE_EXT_OGX    => self::OGX,
    MUD_FILE_EXT_OPUS   => self::OPUS,
    MUD_FILE_EXT_OTF    => self::OTF,
    MUD_FILE_EXT_PNG    => self::PNG,
    MUD_FILE_EXT_PDF    => self::PDF,
    MUD_FILE_EXT_PHP    => self::PHP,
    MUD_FILE_EXT_PPT    => self::PPT,
    MUD_FILE_EXT_PPTX   => self::PPTX,
    MUD_FILE_EXT_RAR    => self::RAR,
    MUD_FILE_EXT_RTF    => self::RTF,
    MUD_FILE_EXT_SH     => self::SH,
    MUD_FILE_EXT_SVG    => self::SVG,
    MUD_FILE_EXT_SWF    => self::SWF,
    MUD_FILE_EXT_TAR    => self::TAR,
    MUD_FILE_EXT_TIF    => self::TIFF,
    MUD_FILE_EXT_TIFF   => self::TIFF,
    MUD_FILE_EXT_TS     => self::TS,
    MUD_FILE_EXT_TTF    => self::TTF,
    MUD_FILE_EXT_TXT    => self::TXT,
    MUD_FILE_EXT_VSD    => self::VSD,
    MUD_FILE_EXT_WAV    => self::WAV,
    MUD_FILE_EXT_WEBA   => self::WEBA,
    MUD_FILE_EXT_WEBM   => self::WEBM,
    MUD_FILE_EXT_WEBP   => self::WEBP,
    MUD_FILE_EXT_WOFF   => self::WOFF,
    MUD_FILE_EXT_WOFF2  => self::WOFF2,
    MUD_FILE_EXT_XHTML  => self::XHTML,
    MUD_FILE_EXT_XLS    => self::XLS,
    MUD_FILE_EXT_XLSX   => self::XLSX,
    MUD_FILE_EXT_XML    => self::XML,
    MUD_FILE_EXT_XUL    => self::XUL,
    MUD_FILE_EXT_ZIP    => self::ZIP,
    MUD_FILE_EXT_3GP    => self::_3GP,
    MUD_FILE_EXT_3G2    => self::_3G2,
    MUD_FILE_EXT_7Z     => self::_7Z,
  ];

}
