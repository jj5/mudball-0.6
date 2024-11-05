<?php

// 2024-02-07 jj5 - NOTE: this class uses the Normalizer class from the php-intl library which is available with:
// $ sudo apt install php-intl


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-19 jj5 - class definition...
//

class MudModuleString extends MudModuleCritical {


  ////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-09 jj5 - constructor...
  //

  public function __construct( MudModuleString|null $previous = null) {

    parent::__construct( $previous );

  }


  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2021-10-18 jj5 - public functions...
  //

  public function utf8_strlen( $input ) : int {

    return mb_strlen( strval( $input ), MUD_UTF8 );

  }

  public function henc( $input ) : string {

    static $ent = ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5;

    // 2017-02-14 jj5 - DONE: fixed HTML encoding of NULL values

    $text = strval( $input );

    if ( $text === '' ) { return ''; }

    $result = htmlspecialchars( strval( $text ), $ent, MUD_UTF8, true );

    // 2019-07-18 jj5 - this should never happen due to
    // ENT_SUBSTITUTE | ENT_DISALLOWED being in $ent above...
    //
    if ( $result === '' ) {

      return '0x' . bin2hex( $text );

    }

    return $result;

  }

  public function hfmt( $input ) : string {

    static $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5;

    $text = strval( $input );

    if ( $text === '' ) { return ''; }

    $result = htmlentities( strval( $text ), $flags, MUD_UTF8, true );

    // 2019-07-18 jj5 - this should never happen due to
    // ENT_SUBSTITUTE | ENT_DISALLOWED being in BOM_ENT...
    //
    if ( $result === '' ) {

      return '0x' . bin2hex( $text );

    }

    return $result;

  }

  public function nbsp( $input ) : string {

    return str_replace( ' ', '&nbsp;', strval( $input ) );

  }

  // 2019-07-10 jj5 - SEE: PHP function to make slug (URL string):
  // https://stackoverflow.com/a/2955878
  //
  // 2019-07-12 jj5 - WARNING: after we go live for v1 we can never ever change
  // this function again, so make sure we're happy with it before then!
  //
  // 2019-09-11 jj5 - DONE: I patched this to allow dots (.) in slugs...
  //
  public function slugify( $input, int $ordinal = 1 ) : string {

    $text = strval( $input );

    // 2019-07-12 jj5 - I patched this so that apostrophes are ignored...
    //
    $text = str_replace( "'", '', $text );

    // 2021-01-19 jj5 - THINK: maybe custom replacements should be possible in addition to
    // these specific few. I had a usecase where I needed to change '#' to 'sharp' for e.g.
    // "C#" but that was very context specific.
    //
    $text = str_replace( '&', ' and ', $text );
    $text = str_replace( '+', ' plus ', $text );

    // replace non letter or digits by -
    $text = preg_replace( '~[^\pL\d\.]+~u', '-', $text );

    // transliterate
    $text = iconv( MUD_UTF8, 'us-ascii//TRANSLIT', $text );

    // remove unwanted characters
    $text = preg_replace( '~[^-\w\.]+~', '', $text );

    // remove duplicate -
    $text = preg_replace( '~-+~', '-', $text );

    // 2019-09-12 jj5 - remove duplicate .
    $text = preg_replace( '~\.+~', '.', $text );

    // 2019-09-12 jj5 - collapse consecutive '.-' etc, replace with '-' not '.'
    $text = preg_replace( '~[\.\-]+~', '-', $text );

    // 2019-09-12 jj5 - trim
    $text = trim( $text, '.-' );

    // lowercase
    $text = strtolower( $text );

    if ( empty( $text ) ) { return 'n-a'; }

    if ( $ordinal !== 1 ) {

      return "$text-$ordinal";

    }

    return $text;

  }

  public function errname( $input ) : string {

    return str_replace( '-', '_', strtoupper( $this->slugify( $input ) ) );

  }

  public function varname( $input ) : string {

    // 2019-09-12 jj5 - this function upgraded to support dots (.) which can
    // now appear in slugs...

    $result = $this->slugify( $input );
    $result = str_replace( '-', '_', $result );
    $result = str_replace( '.', '_', $result );

    if ( $result && ! preg_match( '/^[a-z]/', $result ) ) {

      bom_fail(
        BOM_ERR_VARNAME_MUST_START_WITH_A_LETTER,
        [ 'input' => $input, 'result' => $result ]
      );

    }

    return $result;

  }

  public function entick( $input ) : string {

    $name = preg_replace( '/[^a-z0-9_]/', '', strval( $input ) );

    return "`{$name}`";

  }

  public function enpdo( $input ) : string {

    $name = preg_replace( '/[^a-z0-9_]/', '', strval( $input ) );

    return ":{$name}";

  }

  public function ellipsis( $input, int $max_len = 32 ) : string {

    // 2019-07-15 jj5 - TODO: add support for placing the ellipsis left,
    // middle, or right.

    $text = strval( $input );

    if ( mb_strlen( $text, MUD_UTF8 ) <= $max_len ) { return $text; }

    return mb_substr( $text, 0, $max_len - 3, MUD_UTF8 ) . '...';

  }

  public function hash_bin( string $input, string $salt = '' ) : string {

    return hash( 'sha512/224', "{$salt}{$input}", $raw_output = true );

  }

  public function hash_hex( string $input, string $salt = '' ) : string {

    return hash( 'sha512/224', "{$salt}{$input}" );

  }

  public function hash_file_bin( string $path ) : string {

    return hash_file( 'sha512/224', $path, $raw_output = true );

  }

  public function hash_file_hex( string $path ) : string {

    return hash_file( 'sha512/224', $path );

  }

  // 2019-01-18 jj5 - SEE: stolen from ftwr.co.uk:
  // https://phpxref.ftwr.co.uk/wordpress/nav.html?wp-includes/formatting.php.source.html
  //
  function remove_accents( string $string ) : string {

    if ( ! preg_match( '/[\x80-\xff]/', $string ) ) { return $string; }

    static $chars = [
      // Decompositions for Latin-1 Supplement
      'ª' => 'a',
      'º' => 'o',
      'À' => 'A',
      'Á' => 'A',
      'Â' => 'A',
      'Ã' => 'A',
      'Ä' => 'A',
      'Å' => 'A',
      'Æ' => 'AE',
      'Ç' => 'C',
      'È' => 'E',
      'É' => 'E',
      'Ê' => 'E',
      'Ë' => 'E',
      'Ì' => 'I',
      'Í' => 'I',
      'Î' => 'I',
      'Ï' => 'I',
      'Ð' => 'D',
      'Ñ' => 'N',
      'Ò' => 'O',
      'Ó' => 'O',
      'Ô' => 'O',
      'Õ' => 'O',
      'Ö' => 'O',
      'Ù' => 'U',
      'Ú' => 'U',
      'Û' => 'U',
      'Ü' => 'U',
      'Ý' => 'Y',
      'Þ' => 'TH',
      'ß' => 's',
      'à' => 'a',
      'á' => 'a',
      'â' => 'a',
      'ã' => 'a',
      'ä' => 'a',
      'å' => 'a',
      'æ' => 'ae',
      'ç' => 'c',
      'è' => 'e',
      'é' => 'e',
      'ê' => 'e',
      'ë' => 'e',
      'ì' => 'i',
      'í' => 'i',
      'î' => 'i',
      'ï' => 'i',
      'ð' => 'd',
      'ñ' => 'n',
      'ò' => 'o',
      'ó' => 'o',
      'ô' => 'o',
      'õ' => 'o',
      'ö' => 'o',
      'ø' => 'o',
      'ù' => 'u',
      'ú' => 'u',
      'û' => 'u',
      'ü' => 'u',
      'ý' => 'y',
      'þ' => 'th',
      'ÿ' => 'y',
      'Ø' => 'O',
      // Decompositions for Latin Extended-A
      'Ā' => 'A',
      'ā' => 'a',
      'Ă' => 'A',
      'ă' => 'a',
      'Ą' => 'A',
      'ą' => 'a',
      'Ć' => 'C',
      'ć' => 'c',
      'Ĉ' => 'C',
      'ĉ' => 'c',
      'Ċ' => 'C',
      'ċ' => 'c',
      'Č' => 'C',
      'č' => 'c',
      'Ď' => 'D',
      'ď' => 'd',
      'Đ' => 'D',
      'đ' => 'd',
      'Ē' => 'E',
      'ē' => 'e',
      'Ĕ' => 'E',
      'ĕ' => 'e',
      'Ė' => 'E',
      'ė' => 'e',
      'Ę' => 'E',
      'ę' => 'e',
      'Ě' => 'E',
      'ě' => 'e',
      'Ĝ' => 'G',
      'ĝ' => 'g',
      'Ğ' => 'G',
      'ğ' => 'g',
      'Ġ' => 'G',
      'ġ' => 'g',
      'Ģ' => 'G',
      'ģ' => 'g',
      'Ĥ' => 'H',
      'ĥ' => 'h',
      'Ħ' => 'H',
      'ħ' => 'h',
      'Ĩ' => 'I',
      'ĩ' => 'i',
      'Ī' => 'I',
      'ī' => 'i',
      'Ĭ' => 'I',
      'ĭ' => 'i',
      'Į' => 'I',
      'į' => 'i',
      'İ' => 'I',
      'ı' => 'i',
      'Ĳ' => 'IJ',
      'ĳ' => 'ij',
      'Ĵ' => 'J',
      'ĵ' => 'j',
      'Ķ' => 'K',
      'ķ' => 'k',
      'ĸ' => 'k',
      'Ĺ' => 'L',
      'ĺ' => 'l',
      'Ļ' => 'L',
      'ļ' => 'l',
      'Ľ' => 'L',
      'ľ' => 'l',
      'Ŀ' => 'L',
      'ŀ' => 'l',
      'Ł' => 'L',
      'ł' => 'l',
      'Ń' => 'N',
      'ń' => 'n',
      'Ņ' => 'N',
      'ņ' => 'n',
      'Ň' => 'N',
      'ň' => 'n',
      'ŉ' => 'n',
      'Ŋ' => 'N',
      'ŋ' => 'n',
      'Ō' => 'O',
      'ō' => 'o',
      'Ŏ' => 'O',
      'ŏ' => 'o',
      'Ő' => 'O',
      'ő' => 'o',
      'Œ' => 'OE',
      'œ' => 'oe',
      'Ŕ' => 'R',
      'ŕ' => 'r',
      'Ŗ' => 'R',
      'ŗ' => 'r',
      'Ř' => 'R',
      'ř' => 'r',
      'Ś' => 'S',
      'ś' => 's',
      'Ŝ' => 'S',
      'ŝ' => 's',
      'Ş' => 'S',
      'ş' => 's',
      'Š' => 'S',
      'š' => 's',
      'Ţ' => 'T',
      'ţ' => 't',
      'Ť' => 'T',
      'ť' => 't',
      'Ŧ' => 'T',
      'ŧ' => 't',
      'Ũ' => 'U',
      'ũ' => 'u',
      'Ū' => 'U',
      'ū' => 'u',
      'Ŭ' => 'U',
      'ŭ' => 'u',
      'Ů' => 'U',
      'ů' => 'u',
      'Ű' => 'U',
      'ű' => 'u',
      'Ų' => 'U',
      'ų' => 'u',
      'Ŵ' => 'W',
      'ŵ' => 'w',
      'Ŷ' => 'Y',
      'ŷ' => 'y',
      'Ÿ' => 'Y',
      'Ź' => 'Z',
      'ź' => 'z',
      'Ż' => 'Z',
      'ż' => 'z',
      'Ž' => 'Z',
      'ž' => 'z',
      'ſ' => 's',
      // Decompositions for Latin Extended-B
      'Ș' => 'S',
      'ș' => 's',
      'Ț' => 'T',
      'ț' => 't',
      // Euro Sign
      '€' => 'E',
      // GBP (Pound) Sign
      '£' => '',
      // Vowels with diacritic (Vietnamese)
      // unmarked
      'Ơ' => 'O',
      'ơ' => 'o',
      'Ư' => 'U',
      'ư' => 'u',
      // grave accent
      'Ầ' => 'A',
      'ầ' => 'a',
      'Ằ' => 'A',
      'ằ' => 'a',
      'Ề' => 'E',
      'ề' => 'e',
      'Ồ' => 'O',
      'ồ' => 'o',
      'Ờ' => 'O',
      'ờ' => 'o',
      'Ừ' => 'U',
      'ừ' => 'u',
      'Ỳ' => 'Y',
      'ỳ' => 'y',
      // hook
      'Ả' => 'A',
      'ả' => 'a',
      'Ẩ' => 'A',
      'ẩ' => 'a',
      'Ẳ' => 'A',
      'ẳ' => 'a',
      'Ẻ' => 'E',
      'ẻ' => 'e',
      'Ể' => 'E',
      'ể' => 'e',
      'Ỉ' => 'I',
      'ỉ' => 'i',
      'Ỏ' => 'O',
      'ỏ' => 'o',
      'Ổ' => 'O',
      'ổ' => 'o',
      'Ở' => 'O',
      'ở' => 'o',
      'Ủ' => 'U',
      'ủ' => 'u',
      'Ử' => 'U',
      'ử' => 'u',
      'Ỷ' => 'Y',
      'ỷ' => 'y',
      // tilde
      'Ẫ' => 'A',
      'ẫ' => 'a',
      'Ẵ' => 'A',
      'ẵ' => 'a',
      'Ẽ' => 'E',
      'ẽ' => 'e',
      'Ễ' => 'E',
      'ễ' => 'e',
      'Ỗ' => 'O',
      'ỗ' => 'o',
      'Ỡ' => 'O',
      'ỡ' => 'o',
      'Ữ' => 'U',
      'ữ' => 'u',
      'Ỹ' => 'Y',
      'ỹ' => 'y',
      // acute accent
      'Ấ' => 'A',
      'ấ' => 'a',
      'Ắ' => 'A',
      'ắ' => 'a',
      'Ế' => 'E',
      'ế' => 'e',
      'Ố' => 'O',
      'ố' => 'o',
      'Ớ' => 'O',
      'ớ' => 'o',
      'Ứ' => 'U',
      'ứ' => 'u',
      // dot below
      'Ạ' => 'A',
      'ạ' => 'a',
      'Ậ' => 'A',
      'ậ' => 'a',
      'Ặ' => 'A',
      'ặ' => 'a',
      'Ẹ' => 'E',
      'ẹ' => 'e',
      'Ệ' => 'E',
      'ệ' => 'e',
      'Ị' => 'I',
      'ị' => 'i',
      'Ọ' => 'O',
      'ọ' => 'o',
      'Ộ' => 'O',
      'ộ' => 'o',
      'Ợ' => 'O',
      'ợ' => 'o',
      'Ụ' => 'U',
      'ụ' => 'u',
      'Ự' => 'U',
      'ự' => 'u',
      'Ỵ' => 'Y',
      'ỵ' => 'y',
      // Vowels with diacritic (Chinese, Hanyu Pinyin)
      'ɑ' => 'a',
      // macron
      'Ǖ' => 'U',
      'ǖ' => 'u',
      // acute accent
      'Ǘ' => 'U',
      'ǘ' => 'u',
      // caron
      'Ǎ' => 'A',
      'ǎ' => 'a',
      'Ǐ' => 'I',
      'ǐ' => 'i',
      'Ǒ' => 'O',
      'ǒ' => 'o',
      'Ǔ' => 'U',
      'ǔ' => 'u',
      'Ǚ' => 'U',
      'ǚ' => 'u',
      // grave accent
      'Ǜ' => 'U',
      'ǜ' => 'u',
    ];

    //return strtr( $string, $chars );

    foreach ( $chars as $from => $to ) {

      $string = strtr( $string, $from, $to );

    }

    return $string;

  }

  public function strip_control_chars( string $string ) : string {

    // 2019-11-07 jj5 - SEE: Remove control characters from PHP string:
    // https://stackoverflow.com/a/23066553

    return preg_replace( '/[^\PC\s]/u', '', $string );

  }

  public function normalize_space( string $string ) : string {

    return trim( preg_replace( '/\s+/', ' ', $string ) );

  }

  public function format( $value ) {

    if ( $value === null ) { return ''; }

    if ( $value === true ) { return 'true'; }

    if ( $value === false ) { return 'false'; }

    if ( $value === 0 || $value === 0.0 || $value === -0.0 ) { return '0'; }

    if ( is_int( $value ) ) { return number_format( $value ); }

    if ( is_float( $value ) ) { return number_format( $value, 2 ); }

    if ( is_a( $value, 'DateTimeInterface' ) ) { return $value->format( MUD_SQL_DATE_FORMAT ); }

    return strval( $value );

  }

  public function cell_format( $value ) : string {

    if ( $value ) { return number_format( $value ); }

    return '';

  }

  public function ascii_upper( string $string ) : string {

    $string = trim( $string );

    $string = iconv( 'UTF-8', 'us-ascii//TRANSLIT', $string );

    return strtoupper( $string );

  }

  public function ascii_lower( string $string ) : string {

    $string = trim( $string );

    $string = iconv( 'UTF-8', 'us-ascii//TRANSLIT', $string );

    return strtolower( $string );

  }

  public function asciival( string $input ) : string {

    $encoding = mb_detect_encoding( $input );

    if ( $encoding === 'ASCII' ) {

      $result = $input;

    }
    else {

      $result = mb_convert_encoding( $input, 'ASCII', $encoding );

    }

    assert( mb_check_encoding( $input, 'ASCII' ) );

    return $result;

  }

  public function utf8val( string $input ) : string {

    $encoding = mb_detect_encoding( $input );

    if ( $encoding === 'ASCII' || $encoding === 'UTF-8' ) {

      $result = $input;

    }
    else {

      $result = mb_convert_encoding( $input, 'UTF-8', $encoding );

    }

    $result = $this->unicode_normalize( $result );

    assert( mb_check_encoding( $input, 'UTF-8' ) );
    assert( Normalizer::isNormalized( $result ) );

    return $result;

  }

  public function unicode_normalize( $data ) {

    return self::unicode_normalize_internal( $data );

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2024-02-07 jj5 - string helpers...
  //

  public function quote( string $input ) {

    return "'" . $this->escape( $input ) . "'";

  }

  public function escape( string $utf8_input ) {

    // 2024-02-07 jj5 - NOTE: this function escapes quotes and backslashes and encodes control characters.

    // 2024-02-07 jj5 - SEE: https://www.php.net/manual/en/mysqli.real-escape-string.php

    // 2024-02-07 jj5 - SEE: https://github.com/MariaDB/server/blob/11.4/mysys/charset.c#L1096

    static $map = [

      // 2024-02-07 jj5 - escaped characters...
      //
      "\\"    => '\\\\',
      "'"     => "\\'",
      '"'     => '\\"',

      // 2024-02-07 jj5 - encoded characters...
      //
      "\0"    => '\0',
      "\x01"  => '\x01',
      "\x02"  => '\x02',
      "\x03"  => '\x03',
      "\x04"  => '\x04',
      "\x05"  => '\x05',
      "\x06"  => '\x06',
      "\x07"  => '\x07',
      "\x08"  => '\x08',
      "\t"    => '\t',
      "\n"    => '\n',
      "\v"    => '\v',
      "\f"    => '\f',
      "\r"    => '\r',
      "\x0e"  => '\x0e',
      "\x0f"  => '\x0f',
      "\x10"  => '\x10',
      "\x11"  => '\x11',
      "\x12"  => '\x12',
      "\x13"  => '\x13',
      "\x14"  => '\x14',
      "\x15"  => '\x15',
      "\x16"  => '\x16',
      "\x17"  => '\x17',
      "\x18"  => '\x18',
      "\x19"  => '\x19',
      "\x1a"  => '\x1a',
      "\e"    => '\e',
      "\x1c"  => '\x1c',
      "\x1d"  => '\x1d',
      "\x1e"  => '\x1e',
      "\x1f"  => '\x1f',
      "\x7f"  => '\x7f',

    ];

    $result = $utf8_input;

    foreach ( $map as $from => $to ) {

      $result = str_replace( $from, $to, $result );

    }

    if ( mb_check_encoding( $result, 'UTF-8' ) ) { return $result; }

    mud_require(
      false,
      'string is in valid UTF-8 format.',
      [ 'detected_encoding' => mb_detect_encoding( $result ) ]
    );

    assert( false );

  }

  ///////////////////////////////////////////////////////////////////////////////////////////////
  // 2022-04-10 jj5 - protected static methods...
  //

  protected static function unicode_normalize_internal( $data ) {

    // 2022-04-10 jj5 - NOTE: we use the default normalization form Normalizer::FORM_C

    // 2022-04-10 jj5 - SEE: https://www.unicode.org/reports/tr15/

    if ( is_string( $data ) ) {

      $result = Normalizer::normalize( $data );

      if ( $result === false ) {

        mud_fail( MUD_ERR_STRING_NORMALIZATION_FAILED, [ 'input' => $data ] );

      }

      return $result;

    }

    if ( is_array( $data ) ) {

      $result = [];

      foreach ( $data as $key => $val ) {

        if ( is_string( $key ) ) {

          $normal_key = Normalizer::normalize( $key );

          if ( $normal_key === false ) {

            mud_fail( MUD_ERR_STRING_NORMALIZATION_FAILED, [ 'input' => $key ] );

          }

          $result[ $normal_key ] = self::unicode_normalize_internal( $val );

        }
        else {

          $result[ $key ] = self::unicode_normalize_internal( $val );

        }
      }

      return $result;

    }

    return $data;

  }
}
